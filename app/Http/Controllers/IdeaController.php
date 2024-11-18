<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search') ?? '';
        $ideas = Idea::where('user_id', Auth::user()->id)->where('title', 'LIKE', '%' . $search . '%')->paginate(5);

        return view('idea.index', [
            'ideas' => $ideas,
            'request' => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::user()->id)->get();
        return view('idea.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $body = $request->only('title', 'categories');

        $validated = $this->validate($body);

        if ($validated->fails()) {
            return redirect()
                ->route('ideias.create')
                ->withErrors($validated->errors())
                ->withInput();
        }

        $body['user_id'] = Auth::user()->id;

        $idea = Idea::create($body);
        $idea->categories()->attach($body['categories']);

        return redirect()->route('ideias.edit', [
            'ideia' => $idea->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $idea = Idea::where('id', $id)->where('user_id', Auth::user()->id)->first();
        $categories = Category::where('user_id', Auth::user()->id)->get();
        $selectedCategories = $idea->categories->map(function ($category) {
            return $category->id;
        })->toArray();

        if (!$idea) return redirect()->route('categories.index');

        return view('idea.edit', [
            'idea' => $idea,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $idea = Idea::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!$idea) return redirect()->route('ideias.index');

        $body = $request->only('title', 'categories');

        $body['id'] = $idea->id;
        $validated = $this->validate($body, true);
        unset($body['id']);

        if ($validated->fails()) {
            return redirect()
                ->route('ideias.edit', ['ideia' => $idea->id])
                ->withErrors($validated->errors())
                ->withInput();
        }

        $idea->update([
            'title' => $body['title']
        ]);

        if (isset($body['categories'])) {
            $idea->categories()->sync($body['categories']);
        }

        return redirect()->route('ideias.edit', ['ideia' => $idea->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function validate($body, $isUpdate = false)
    {
        $rules = [
            'title' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('ideas')->where(function($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
            ],
            'categories' => 'required|array',
            'categoreis.*' => 'exists:categories,id',
        ];

        $messages = [
            'title.required' => 'O campo de título é obrigatório',
            'title.min' => 'O campo de título deve ter no mínimo 3 caracteres',
            'title.max' => 'O campo de título deve ter no máximo 255 caracteres',
            'title.unique' => 'Já existe uma ideia com esse título',
            'categories.required' => 'O campo de categorias é obrigatório',
            'categories.array' => 'O campo de categorias deve ser um array',
            'categories.*.exists' => 'Uma ou mais categorias selecionadas são inválidas',
        ];

        if ($isUpdate) {
            $rules['title'] = $rules['title'] . ',title,' . $body['id'];
        }

        return Validator::make($body, $rules, $messages);
    }
}
