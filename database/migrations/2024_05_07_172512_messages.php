<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('body');
            $table->string('conversation_id');
            $table->string('sender_id');
            $table->string('receiver_id');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sender_deleted_at')->nullable();
            $table->timestamp('receiver_deleted_at')->nullable();
            $table->timestamps();
        });
        
    }


    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
