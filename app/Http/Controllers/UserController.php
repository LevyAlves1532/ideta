<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show(string $id)
    {
        if (Auth::user()->id != $id) return redirect()->back();

        $user = User::find($id);

        if (!$user) return redirect()->back();

        return view('profile.view', [
            'user' => $user,
        ]);
    }

    public function edit(string $id)
    {
        if (Auth::user()->id != $id) return redirect()->back();

        $user = User::find($id);

        if (!$user) return redirect()->back();

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, string $id)
    {
        if (Auth::user()->id != $id) return redirect()->back();

        $user = User::find($id);

        if (!$user) return redirect()->back();

        $body = $request->only('name', 'email');

        $body['id'] = $id;
        $validated = $this->validate($body);
        unset($body['id']);

        if ($validated->fails()) {
            return redirect()
                ->route('profile.edit', ['user_id' => Auth::user()->id])
                ->withErrors($validated->errors())
                ->withInput();
        }

        $user->update($body);

        return redirect()->route('profile.show', ['user_id' => $id]);
    }

    private function validate($body)
    {
        $rules = [
            'name' => 'min:4|max:255',
            'email' => 'email|unique:users,email,' . $body['id'],
        ];

        $messages = [
            'name.required' => 'O campo de nome é obrigatório',
            'name.min' => 'O campo de nome deve ter no mínimo 4 caracteres',
            'name.max' => 'O campo de nome deve ter no máximo 255 caracteres',
            'email.unique' => 'Já existe um usuário com esse email',
            'email.email' => 'O e-mail apresentado é inválido!',
        ];

        return Validator::make($body, $rules, $messages);
    }
}
