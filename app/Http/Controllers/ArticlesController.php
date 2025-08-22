<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        
        $categories = Category::all();
        $query = Article::query();
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        $articles = $query->with('category', 'user')
            ->withCount('likes', 'comments')
            ->latest()
            ->paginate(10);

        return view('home', compact('categories', 'articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
            'image' => $imagePath,
            'published_at' => now(),
        ]);

        return redirect()->route('home')->with('success', 'تم إضافة المقالة بنجاح!');
    }

    public function mine(Request $request)
    {
        $query = Article::where('user_id', auth()->id());
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $myArticles = $query->with('category')->withCount('likes', 'comments')->latest()->paginate(10);
        return view('articles.mine', compact('myArticles'));
    }

    public function edit(Article $article)
    {
        if ($article->user_id !== auth()->id()) abort(403);
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $article->image = $imagePath;
        }

        $article->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'image' => $article->image,
        ]);

        return redirect()->route('articles.mine')->with('success', 'تم تعديل المقالة بنجاح!');
    }

    public function destroy(Article $article)
    {
        if ($article->user_id !== auth()->id()) abort(403);
        $article->delete();
        return redirect()->route('articles.mine')->with('success', 'تم حذف المقالة!');
    }

    public function show(Article $article)
    {
        $article->load(['category', 'user', 'comments.replies.user', 'comments.user', 'likes']);
        return view('articles.show', compact('article'));
    }

 public function like(Article $article)
{
    $userId = auth()->id();
    if ($article->likes()->where('user_id', $userId)->exists()) {
        return redirect()->back()->with('info', 'لقد أعجبت بالفعل بهذه المقالة.');
    }
    $article->likes()->attach($userId);
    return redirect()->back()->with('success', 'تم إضافة إعجابك!');
}

    public function comment(Request $request, Article $article)
    {
        $request->validate(['content' => 'required|string|max:500']);
        $article->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);
        return redirect()->back()->with('success', 'تم إضافة التعليق!');
    }
    
}