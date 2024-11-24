<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Article::factory(20)->create();

        $users = User::where('name', '<>', 'Admin')->limit(5)->get();
        $role = Role::where('name', 'user')->first();

        foreach ($users as $user) { 
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);
        }

        $articles = Article::limit(3)->get();
        foreach ($users as $user) {
            foreach ($articles as $article) {
                Comment::factory()->create([
                    'user_id' => $user->id,
                    'article_id' => $article->id
                ]);       
            }
        }


    }
}
