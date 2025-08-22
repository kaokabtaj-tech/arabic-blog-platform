<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleUserLikesTable extends Migration
{
    public function up()
    {
        Schema::create('article_user_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['article_id', 'user_id']); // لضمان عدم تكرار الإعجاب
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_user_likes');
    }
}