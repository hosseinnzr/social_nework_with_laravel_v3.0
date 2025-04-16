<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('phone')->lenghth(11)->default(0);
            $table->string('biography')->nullable();
            $table->string('followers')->default('0');
            $table->string('following')->default('0');

            $table->string('user_name')->unique();
            $table->string('email')->unique();
            
            $table->string('password');
            $table->integer('followers_number')->default(0);
            $table->integer('following_number')->default(0);
            $table->string('profile_pic')->default('/default/default_profile.jpg');
            $table->string('additional_name')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('post_number')->default(0);

            $table->rememberToken();
            $table->timestamps();

            $table->timestamp('email_verified_at')->nullable();
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
