<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function show(Request $request)
    {
        $body = $request->only('email', 'password');

        $validated = $this->validate($body);

        if (!$validated->fails()) {
            $isUser = Auth::attempt([
                'email' => $body['email'],
                'password' => $body['password'],
            ]);

            if ($isUser) {
                return redirect()
                    ->route('index');
            } else {
                return redirect()
                    ->route('login')
                    ->with('system_errors', [
                        'E-mail ou senha estão incorretos!',
                    ])
                    ->withInput();
            }
        } else {
            return redirect()
                ->route('login')
                ->withErrors($validated->errors())
                ->withInput();
        }
    }

    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $body = $request->only('name', 'email', 'password');

        $validated = $this->validate($body, true);

        if (!$validated->fails()) {
            $user = User::create($body);

            Category::create([
                'user_id' => $user->id,
                'name' => 'Todas',
                'slug' => 'todas',
                'color' => '#000000',
                'is_default' => true,
            ]);

            Auth::attempt([
                'email' => $body['email'],
                'password' => $body['password'],
            ]);

            return redirect()->route('index');
        } else {
            return redirect()
                ->route('register')
                ->withErrors($validated->errors())
                ->withInput();
        }
    }

    private function validate($body, $isRegister = false)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6|max:255',
        ];

        $messages = [
            'email.required' => 'O campo de e-mail é obrigatório',
            'email.email' => 'O campo de e-mail é invalído',
            'password.required' => 'O campo de senha é obrigatório',
            'password.min' => 'O campo de senha deve ter no mínimo 6 caracteres',
            'password.max' => 'O campo de senha deve ter no máximo 255 caracteres',
        ];

        if ($isRegister) {
            $rules['name'] = 'required|min:4|max:255';
            $rules['email'] = $rules['email'] . '|unique:users';

            $messages['name.required'] = 'O campo de nome é obrigatório';
            $messages['name.min'] = 'O campo de nome deve ter no mínimo 4 caracteres';
            $messages['name.max'] = 'O campo de nome deve ter no máximo 255 caracteres';
            $messages['email.unique'] = 'Já existe um usuário com esse e-mail';
        }

        return Validator::make($body, $rules, $messages);
    }
}
