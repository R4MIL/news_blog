<?php

namespace App\Http\Controllers\Blog;

use App\Events\StoreViewsBlogArticleEvent;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        return Inertia::render('Blog/ArticlesList',[
            'articles' => Article::orderBy('created_at','desc')->paginate(20)
        ]);
    }

    public function get(int $id)
    {
        $article = Article::where('id', $id)->with('comments','comments.user')->first();
        if (Auth::user()->isAdmin() == false) {
            $article->views()->create([
                'created_at' => now()
            ]);
    
            $viewData = [
                'article_id' => $article->id,
                'views_quantity' => $article->views()->count()
            ];

            broadcast(new StoreViewsBlogArticleEvent($viewData));
        }
       
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

        return redirect()->route('administration.index');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required'
        ]);

        $article = Article::find($id);
        $article->fill([
            'title' => $request->title,
            'text' => $request->text    
        ]);
        $article->save();

        return redirect()->route('administration.index');
    }

    public function delete(int $id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect()->route('administration.index');
    }
}
