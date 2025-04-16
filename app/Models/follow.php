<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class follow extends Model
{
    use HasFactory;

    protected $table = 'follow';

    protected $fillable = [
        'id',
        'follower_id',
        'following_id',
    ];
}
