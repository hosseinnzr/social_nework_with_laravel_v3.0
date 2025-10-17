<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('body', 255);
            $table->string('type', 255);
            $table->longText('from')->nullable();
            $table->boolean('seen')->default(0);
            $table->timestamps();
            $table->string('user_profile', 255)->default('/default/default_profile.jpg');
            $table->string('delete', 10)->default('0');
            $table->string('to', 255)->nullable();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
