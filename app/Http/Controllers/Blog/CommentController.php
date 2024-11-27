<?php

namespace App\Http\Controllers\Blog;

use App\Events\StoreBlogCommentEvent;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article) {
        $request->validate([
            'comment' => 'required'
        ]);

        $commentData = [
            'user_id' => Auth::user()->id,
            'text' => $request->comment,
            'created_at' => now(),
            'user' => [
                'name' => Auth::user()->name
            ]  
        ];

        $article->comments()->create($commentData);

        broadcast(new StoreBlogCommentEvent($commentData))->toOthers();

        return response()->json($commentData);
    }
}
