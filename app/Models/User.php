<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'Followers',
        'Following',
        'biography',
        'phone',
        'first_name',
        'last_name',
        'user_name',
        'email',
        'password',
        'profile_pic',
        'additional_name',
        'birthday',
        'request',
        'privacy',
        'like_notification',
        'comment_notification',
        'follow_notification',
        'follow_request_notification'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
