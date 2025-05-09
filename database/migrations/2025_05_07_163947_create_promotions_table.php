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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url');
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('text_color')->default('text-white');
            $table->string('overlay_color')->default('bg-black bg-opacity-40');
            $table->enum('text_position', ['left', 'center', 'right'])->default('left');
            $table->enum('type', ['hero_slider', 'banner', 'popup'])->default('hero_slider');
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
