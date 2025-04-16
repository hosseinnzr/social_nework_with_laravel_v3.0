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
            $table->string('UID');
            $table->string('body');
            $table->string('type');
            $table->string('user_profile')->default('/default/default_profile.jpg');
            $table->longText('from')->nullable();
            $table->boolean('seen')->default('0');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
