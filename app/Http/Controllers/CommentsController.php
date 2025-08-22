<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function reply(Request $request, Comment $comment)
    {
        $request->validate(['content' => 'required|string|max:500']);
        $comment->replies()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'article_id' => $comment->article_id,
            'parent_id' => $comment->id,
        ]);
        return redirect()->back()->with('success', 'تم إضافة الرد!');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) abort(403);
        $comment->delete();
        return redirect()->back()->with('success', 'تم حذف التعليق!');
    }
    public function store(Request $request, $articleId)
{
    $request->validate(['content' => 'required|string']);
    Comment::create([
        'article_id' => $articleId,
        'user_id' => auth()->id(),
        'content' => $request->content,
    ]);
    return back()->with('success', 'تم إضافة التعليق بنجاح');
}
}
