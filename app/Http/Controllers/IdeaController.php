<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Idea;
use App\Models\IdeaShare;
use App\Models\Note;
use Carbon\Carbon;
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
        $userId = Auth::user()->id;
        $search = $request->get('search') ?? '';
        $categoryId = $request->get('category_id') ?? '';
        $qtd_rows = $request->get('qtd_rows') ?? '5';

        $ideas = Idea::where('user_id', $userId)
            ->where('title', 'LIKE', '%' . $search . '%')
            ->when($categoryId, function ($query, $categoryId) {
                if (!empty($categoryId)) {
                    $query->whereHas('categories', function ($query) use ($categoryId) {
                        $query->where('categories.id', $categoryId);
                    });
                }
            })
            ->paginate($qtd_rows);
        $categories = Category::where('user_id', $userId)->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'request' => $request->all(),
            'categories' => $categories,
            'qtd_rows' => $qtd_rows,
            'total' => $ideas->toArray()['total'],
            'category_id' => $categoryId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::user()->id)->where('is_default', false)->get();
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
                ->route('ideas.create')
                ->withErrors($validated->errors())
                ->withInput();
        }

        $body['user_id'] = Auth::user()->id;

        $category = Category::where('user_id', $body['user_id'])->where('is_default', true)->first();

        $body['categories'][] = "{$category->id}";

        $idea = Idea::create($body);
        $idea->categories()->attach($body['categories']);

        return redirect()->route('ideas.edit', [
            'ideia' => $idea->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $qtd_rows = $request->get('qtd_rows') ?? '5';

        $userId = Auth::user()->id;

        $idea = Idea::where('id', $id)->where('user_id', $userId)->first();

        if (!$idea) return redirect()->route('categories.index');

        $categories = $idea->categories()->paginate($qtd_rows);

        $unrelatedCategories = Category::whereDoesntHave('ideas', function ($query) use ($idea) {
            $query->where('ideas.id', $idea->id);
        })->where('user_id', $userId)->get();

        return view('idea.view', [
            'idea' => $idea,
            'categories' => $categories,
            'request' => $request->all(),
            'unrelatedCategories' => $unrelatedCategories->map(fn ($unrelatedCategory) => [
                'id' => $unrelatedCategory->id,
                'name' => $unrelatedCategory->name,
            ])->toArray(),
            'qtd_rows' => $qtd_rows,
            'total' => $categories->toArray()['total'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $idea = Idea::where('id', $id)->where('user_id', Auth::user()->id)->first();
        $categories = Category::where('user_id', Auth::user()->id)->where('is_default', false)->get();
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
        $userId = Auth::user()->id;
        $idea = Idea::where('id', $id)->where('user_id', $userId)->first();

        if (!$idea) return redirect()->route('ideas.index');

        $body = $request->only('title', 'categories');

        $body['id'] = $idea->id;
        $validated = $this->validate($body, true);
        unset($body['id']);

        if ($validated->fails()) {
            return redirect()
                ->route('ideas.edit', ['ideia' => $idea->id])
                ->withErrors($validated->errors())
                ->withInput();
        }

        $idea->update([
            'title' => $body['title']
        ]);

        $category = Category::where('user_id', $userId)->where('is_default', true)->first();
        $body['categories'][] = "{$category->id}";
        $idea->categories()->sync($body['categories']);

        return redirect()->route('ideas.edit', ['ideia' => $idea->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $idea = Idea::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!$idea) return redirect()->route('ideas.index');

        $idea->categories()->detach();

        foreach ($idea->notes as $note) {
            $note->delete();
        }

        $idea->delete();

        return redirect()->route('ideas.index');
    }

    public function addCategoryIdea(Request $request)
    {
        $body = $request->only('idea_id', 'category_id');
        $idea = Idea::where('id', $body['idea_id'])->where('user_id', Auth::user()->id)->first();

        if (!$idea) return redirect()->route('ideas.index');

        $validated = $this->validateRelations($body);

        if ($validated->fails()) {
            return redirect()
                ->back()
                ->withErrors($validated->errors());
        }

        $idea->categories()->attach($body['category_id']);

        return redirect()->route('ideas.show', [
            'ideia' => $idea->id,
        ]);
    }

    public function removeCategoryIdea(Request $request, $id)
    {
        $body = $request->only('idea_id');
        $idea = Idea::where('id', $body['idea_id'])->where('user_id', Auth::user()->id)->first();
        $category = Category::where('id', $id)->first();

        if ($category->is_default) {
            return redirect()
                ->back()
                ->with('system_errors', [
                    'Essa categoria não pode ser desvinculada!',
                ]);
        }

        $body['category_id'] = $id;

        if (!$idea) return redirect()->route('ideas.index');

        $validated = $this->validateRelations($body);

        if ($validated->fails()) {
            return redirect()
                ->back()
                ->withErrors($validated->errors());
        }

        $idea->categories()->detach($body['category_id']);

        return redirect()->route('ideas.show', [
            'ideia' => $idea->id,
        ]);
    }

    public function shareIdea(Request $request)
    {
        $body = $request->only('idea_id');

        $validated = Validator::make($body, [
            'idea_id' => 'required|exists:ideas,id',
        ], [
            'idea_id.required' => 'Tarefa não foi enviada',
            'idea_id.exists' => 'Essa tarefa não existe',
        ]);

        if ($validated->fails()) {
            return redirect()
                ->route('ideas.index')
                ->withErrors($validated->errors());
        }

        $token = '';

        $idea = Idea::where('id', $body['idea_id'])->where('user_id', Auth::user()->id)->first();
        $ideaShare = IdeaShare::where('idea_id', $body['idea_id'])->where('expires_in', '>', Carbon::now())->first();

        if (!$idea) {
            return redirect()
                ->route('ideas.index')
                ->withErrors(['system' => 'Está tarefa não pertence a você']);
        }

        if (!$ideaShare) {
            $token = md5(time());

            $idea = IdeaShare::create([
                'user_id' => Auth::user()->id,
                'idea_id' => $idea->id,
                'token' => $token,
                'expires_in' => Carbon::now()->addDay(),
            ]);
        } else {
            $token = $ideaShare->token;
        }

        return redirect()->route('notes.idea-shared', ['token' => $token]);
    }

    public function copyIdea(string $token)
    {
        $ideaShare = IdeaShare::where('token', $token)->where('expires_in', '>', Carbon::now())->first();

        if (!$ideaShare) {
            return redirect()->back();
        }

        $user_id = Auth::user()->id;
        $category = Category::where('user_id', $user_id)->where('is_default', true)->first();

        $idea = Idea::create([
            'user_id' => $user_id,
            'title' => $ideaShare->idea->title,
        ]);

        $idea->categories()->attach($category->id);

        foreach ($ideaShare->idea->notes as $note) {
            Note::create([
                'user_id' => $user_id,
                'idea_id' => $idea->id,
                'body' => $note->body,
                'position' => $note->position,
            ]);
        }

        return redirect()->route('notes.index', ['idea_id' => $idea->id]);
    }

    private function validateRelations($body)
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
        ];

        $messages = [
            'category_id.required' => 'O campo de ideia é obrigatório',
            'category_id.exists' => 'A ideia é inválida',
        ];

        return Validator::make($body, $rules, $messages);
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
            $rules['title'] = [
                'required',
                'min:3',
                'max:255',
                Rule::unique('ideas')->where(function($query) {
                    return $query->where('user_id', Auth::user()->id);
                })->ignore($body['id']),
            ];
        }

        return Validator::make($body, $rules, $messages);
    }
}
