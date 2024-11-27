<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        return Inertia::render('Blog/ArticlesList',[
            'articles' => Article::orderBy('created_at','desc')->get()
        ]);
    }

    public function get(string $id)
    {
        $article = Article::where('id', $id)->with('comments','comments.user')->first();
        return Inertia::render('Blog/ArticlesCardForm', [
            'article' => $article
        ]);
    }

    public function add()
    {
        return Inertia::render('Blog/ArticlesAddForm');
    }

    public function edit(Article $article)
    {
        return Inertia::render('Blog/ArticlesEditForm', [
            'article' => $article
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required'
        ]);

        Article::create([
            'title' => $request->title,
            'text' => $request->text,
            'created_at' => now()  
        ]);

        return redirect()->route('articles.index');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required'
        ]);

        $article = Article::find($id);
        $article->fill($request->validated());
        $article->save();

        return redirect()->route('articles.index');
    }

    public function delete(string $id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect()->route('articles.index');
    }
}
