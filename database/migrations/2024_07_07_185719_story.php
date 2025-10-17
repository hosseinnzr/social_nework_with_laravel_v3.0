<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('story_picture');
            $table->timestamps();
            $table->string('UID');
            $table->longText('like')->nullable();
            $table->string('like_number')->default('0');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('story');
    }
};
