<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // bigint unsigned, auto-increment
            $table->string('comment_value', 255);
            $table->string('UID', 200)->nullable();
            $table->string('post_id', 10000)->nullable();
            $table->boolean('isDeleted')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
