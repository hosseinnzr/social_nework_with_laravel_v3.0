<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('id'); // bigint unsigned PK
            $table->string('UID');       // varchar(255) not null
            $table->longText('post')->nullable(); // longtext nullable
            $table->longText('tag')->nullable();  // longtext nullable
            $table->boolean('delete')->default(0); // tinyint(1) default 0
            $table->integer('like_number')->default(0); // int(11) default 0
            $table->string('post_picture')->nullable(); // varchar(255) nullable
            $table->string('post_video')->nullable();   // varchar(255) nullable
            $table->string('video_cover')->nullable();  // varchar(255) nullable
            $table->timestamps(); // created_at & updated_at with current timestamp
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
