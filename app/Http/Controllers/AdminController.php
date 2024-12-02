<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Administration',[
            'articles' => Article::with('views','comments')->orderBy('created_at','desc')->get()
        ]);
    }
}
