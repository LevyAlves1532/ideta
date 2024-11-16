<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('idea.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function validate($body)
    {
        $rules = [
            'title' => 'required|min:3|max:255|unique:ideas',
            'categories' => 'required|array',
            'categoreis.*' => 'exists:categories,id',
        ];

        $messages = [
            'title.required' => 'O campo de nome é obrigatório',
            'title.min' => 'O campo de nome deve ter no mínimo 3 caracteres',
            'title.max' => 'O campo de nome deve ter no máximo 255 caracteres',
            'title.unique' => 'Já existe uma ideia com esse título',
            'categories.required' => 'O campo de categorias é obrigatório',
            'categories.array' => 'O campo de categorias deve ser um array',
            'categories.*.exists' => 'Uma ou mais categorias selecionadas são inválidas',
        ];

        return Validator::make($body, $rules, $messages);
    }
}
