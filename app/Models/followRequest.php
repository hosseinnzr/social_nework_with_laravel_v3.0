<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class followRequest extends Model
{
    use HasFactory;

    protected $table = 'follow_request';

    protected $fillable = [
        'id',
        'follower_id',
        'following_id',
    ];
}
