<?php

namespace Tests\Unit;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $this->assertCount(20, Article::orderBy('created_at', 'desc')->get());

        $response = $this->get('/articles');
        $response->assertStatus(200);
    }
    
    public function test_add()
    {
        $article = Article::factory()->create();
        $response = $this->get('/articles/add');
        $response->assertStatus(200);
    }
    
    public function test_store()
    {
        $data = [
            'title' => 'Article Title',
            'text' => 'Sample text for the article.'
        ];

        $response = $this->post('/articles/store', $data);
        $response->assertStatus(200);
    }
    
    public function test_edit()
    {
        $article = Article::factory()->create();
        $response = $this->get('/articles/'.$article->id.'/edit');
        $response->assertStatus(200);
    }
    
    public function test_update()
    {
        $article = Article::factory()->create();
        
        $data = [
            'title' => 'Тестовая статья',
            'text' => 'Текст статьи.'
        ];
        $response = $this->post('/articles/'.$article->id.'/update', $data);
        $response->assertStatus(200);
    }
    
    public function test_delete()
    {
        $article = Article::factory()->create();
        $response = $this->delete('/articles/'.$article->id.'/delete');
        $response->assertStatus(200);
    }

}
