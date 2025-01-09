<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) return redirect()->route('index');

        return view('profile.view', [
            'user' => $user,
        ]);
    }
}
