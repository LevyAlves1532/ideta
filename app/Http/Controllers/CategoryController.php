<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search') ?? '';
        $qtd_rows = $request->get('qtd_rows') ?? '5';

        $categories = Category::where('user_id', Auth::user()->id)->where('name', 'LIKE', '%' . $search . '%')->paginate($qtd_rows);
        return view('category.index', [
            'categories' => $categories,
            'request' => $request->all(),
            'qtd_rows' => $qtd_rows,
            'total' => $categories->toArray()['total'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $body = $request->only('name', 'color');

        $validated = $this->validate($body);

        if ($validated->fails()) {
            return redirect()
                ->route('categories.create')
                ->withErrors($validated->errors())
                ->withInput();
        }

        $body['user_id'] = Auth::user()->id;

        $category = Category::create($body);

        return redirect()->route('categories.edit', [
            'categoria' => $category->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $qtd_rows = $request->get('qtd_rows') ?? '5';

        $category = Category::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!$category) return redirect()->route('categories.index');

        $ideas = $category->ideas()->paginate($qtd_rows);
        $unrelatedIdeas = Idea::whereDoesntHave('categories', function ($query) use ($category) {
            $query->where('categories.id', $category->id);
        })->where('user_id', Auth::user()->id)->get();

        return view('category.view', [
            'category' => $category,
            'ideas' => $ideas,
            'request' => $request->all(),
            'unrelatedIdeas' => $unrelatedIdeas,
            'qtd_rows' => $qtd_rows,
            'total' => $ideas->toArray()['total'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!$category) return redirect()->route('categories.index');

        return view('category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!$category) return redirect()->route('categories.index');

        $body = $request->only('name', 'color');

        $body['id'] = $category->id;
        $validated = $this->validate($body, true);
        unset($body['id']);

        if ($validated->fails()) {
            return redirect()
                ->route('categories.edit', ['categoria' => $category->id])
                ->withErrors($validated->errors())
                ->withInput();
        }

        $category->update($body);

        return redirect()->route('categories.edit', ['categoria' => $category->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user =  Auth::user();

        $category = Category::where('id', $id)->where('user_id', $user->id)->first();

        if (!$category) return redirect()->route('categories.index');

        if ($category->is_default) {
            return redirect()
                ->route('categories.index')
                ->with('system_errors', [
                    'Está categoria não pode ser deletada!',
                ]);
        }

        $category->ideas()->detach();

        $metric = $user->metric;

        if ($metric->last_category_created === $category->id) {
            $metric->last_category_created = null;
            $metric->save();
        }

        $category->delete();

        return redirect()->route('categories.index');
    }

    public function addIdeaCategory(Request $request)
    {
        $body = $request->only('category_id', 'idea_id');
        $category = Category::where('id', $body['category_id'])->where('user_id', Auth::user()->id)->first();

        if (!$category) return redirect()->route('categories.index');

        $validated = $this->validateRelations($body);

        if ($validated->fails()) {
            return redirect()
                ->back()
                ->withErrors($validated->errors());
        }

        $category->ideas()->attach($body['idea_id']);

        return redirect()->route('categories.show', [
            'categoria' => $category->id,
        ]);
    }

    public function removeIdeaCategory(Request $request, $id)
    {
        $body = $request->only('category_id');
        $category = Category::where('id', $body['category_id'])->where('user_id', Auth::user()->id)->first();

        $body['idea_id'] = $id;

        if (!$category) return redirect()->route('categories.index');

        if ($category->is_default) {
            return redirect()
                ->back()
                ->with('system_errors', [
                    'Essa ideia não pode ser desvinculada desta categoria!',
                ]);
        }

        $validated = $this->validateRelations($body);

        if ($validated->fails()) {
            return redirect()
                ->back()
                ->withErrors($validated->errors());
        }

        $category->ideas()->detach($body['idea_id']);

        return redirect()->route('categories.show', [
            'categoria' => $category->id,
        ]);
    }

    private function validateRelations($body)
    {
        $rules = [
            'idea_id' => 'required|exists:ideas,id',
        ];

        $messages = [
            'idea_id.required' => 'O campo de ideia é obrigatório',
            'idea_id.exists' => 'A ideia é inválida',
        ];

        return Validator::make($body, $rules, $messages);
    }

    private function validate($body, $isUpdate = false)
    {
        $rule = Rule::unique('categories')->where(function($query) {
            return $query->where('user_id', Auth::user()->id);
        });

        if ($isUpdate) {
            $rule->ignore($body['id']);
        }

        $rules = [
            'name' => [
                'required',
                'min:3',
                'max:255',
                $rule
            ],
            'color' => 'required|hex_color'
        ];

        $messages = [
            'name.required' => 'O campo de nome é obrigatório',
            'name.min' => 'O campo de nome deve ter no mínimo 3 caracteres',
            'name.max' => 'O campo de nome deve ter no máximo 255 caracteres',
            'name.unique' => 'Já existe uma categoria com esse nome',
            'color.required' => 'O campo de cor é obrigatório',
            'color.hex_color' => 'O valor do campo cor deve ser uma cor hexadecimal',
        ];

        return Validator::make($body, $rules, $messages);
    }
}
