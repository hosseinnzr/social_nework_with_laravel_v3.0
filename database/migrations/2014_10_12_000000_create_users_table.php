<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id UNSIGNED AUTO_INCREMENT
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 11)->default('01234567890');
            $table->string('biography')->nullable();
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); // created_at و updated_at
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('followers_number')->default(0);
            $table->integer('following_number')->default(0);
            $table->string('profile_pic')->nullable();
            $table->string('additional_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('post_number')->default('0');
            $table->string('status', 250)->default('active');
            $table->string('privacy')->default('public'); // اصلاح مقدار پیشفرض
            $table->integer('request_number')->default(0);
            $table->boolean('like_notification')->default(false);
            $table->boolean('comment_notification')->default(false);
            $table->boolean('follow_notification')->default(false);
            $table->boolean('follow_request_notification')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
