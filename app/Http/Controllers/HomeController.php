<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::user()->id)->get();

        return view('index', [
            'categories' => $categories,
        ]);
    }
}
