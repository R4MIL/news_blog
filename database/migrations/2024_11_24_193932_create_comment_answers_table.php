<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comment_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('comment_id');
            $table->integer('user_id');
            $table->text('text');
            $table->datetime('created_at');
            
            $table->foreign('comment_id')
            ->references('id')
            ->on('comments')
            ->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_answers');
    }
};