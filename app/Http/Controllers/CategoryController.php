<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('category.index');
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
                ->route('categorias.create')
                ->withErrors($validated->errors())
                ->withInput();
        }

        $body['user_id'] = Auth::user()->id;
        $body['slug'] = Str::slug($body['name']);

        $category = Category::create($body);

        return redirect()->route('categorias.edit', [
            'categoria' => $category->id,
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

    private function validate($body, $isUpdate = false)
    {
        $rules = [
            'name' => 'required|min:3|max:255|unique:categories',
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
