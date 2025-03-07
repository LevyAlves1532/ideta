<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id') ?? '';

        $latestIdeas = Idea::query()
            ->where('user_id', Auth::user()->id)
            ->when($categoryId, function ($query, $categoryId) {
                if (!empty($categoryId)) {
                    $query->whereHas('categories', function ($query) use ($categoryId) {
                        $query->where('categories.id', $categoryId);
                    });
                }
            })
            ->where(function($query) {
                return $query->whereNotNull('updated_at')
                    ->orWhereHas('notes', function ($subQuery) {
                        return $subQuery->whereNotNull('updated_at');
                    });
            })
            ->orderBy(DB::raw('GREATEST(ideas.updated_at, (SELECT MAX(notes.updated_at) FROM notes WHERE notes.idea_id = ideas.id))'), 'desc')
            ->take(5)
            ->get();

        $categoriesLatestIdeas = Category::query()
            ->where('user_id', Auth::user()->id)
            ->whereIn('id', function ($query) use ($latestIdeas) {
                $query->select('category_id')
                      ->from('categories_ideas');
            })
            ->distinct()
            ->take(5)
            ->get();

        return view('index', [
            'latestIdeas' => $latestIdeas,
            'categoriesLatestIdeas' => $categoriesLatestIdeas,
            'category_id' => $categoryId,
        ]);
    }
}
