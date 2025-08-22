<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $articles = $query->with(['category', 'user'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        $categories = Category::all();

        return view('home', compact('articles', 'categories'));
    }
}