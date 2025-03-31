<?php

namespace Tests\Unit;

use App\Events\StoreBlogCommentEvent;
use App\Models\Article;
use App\Models\User;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_store() {
        $article = Article::factory()->create();
        $user = User::factory()->create();

        Event::fake([StoreBlogCommentEvent::class]);

        Auth::login($user);
        $response = $this->post('/articles/'.$article->id.'/comments', [
            'comment' => 'Sample comment text'
        ]);
        
        $response->assertJson([
            'user_id' => $user->id,
            'text' => 'Sample comment text',
            'user' => [
                'name' => $user->name
            ]
        ]);
        
        Event::assertDispatched(function (StoreBlogCommentEvent $event) use ($article, $user) {
            return $event->comment['user_id'] === $user->id && 
                $event->comment['text'] === 'тестовый комментарий' && 
                $event->comment['user']['name'] === $user->name;
        });
    }

}
