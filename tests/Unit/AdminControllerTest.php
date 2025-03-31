<?php

namespace Tests\Unit;

use App\Http\Controllers\AdminController;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index() {
        $articles = Article::factory()->count(3)->create();
        
        $response = (new AdminController())->index();
        $response->assertViewHas('articles', function ($viewArticles) use ($articles) {
            return count($viewArticles) === 3 && $viewArticles[0]->id === $articles[2]->id;
        });
    }
}
