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
        Schema::create('like_comment', function (Blueprint $table) {
            $table->id();
            $table->string('UID');
            $table->string('comment_id');
            $table->string('user_comment_id');
            $table->string('type')->default('like');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'like_comment');
    }
};
