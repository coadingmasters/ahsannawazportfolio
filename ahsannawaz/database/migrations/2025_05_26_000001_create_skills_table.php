<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // backend, frontend, cms, database, tools
            $table->unsignedTinyInteger('percentage')->default(80);
            $table->string('level')->default('advanced'); // expert, advanced, good
            $table->string('icon')->default('⚡'); // emoji icon
            $table->string('color')->default('#F97316'); // hex color
            $table->string('color_gradient')->default('linear-gradient(90deg,#F97316,#fb923c)');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
