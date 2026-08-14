<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();          // the public URL
            $table->string('excerpt', 500)->nullable(); // card text + meta description
            $table->longText('body');                   // markdown-ish / HTML
            $table->string('image')->nullable();
            $table->string('category')->default('laravel');
            $table->unsignedSmallInteger('read_minutes')->default(3);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
