<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likeStory extends Model
{
    use HasFactory;

    protected $table = 'like_story';

    protected $fillable = [
        'id',
        'UID',
        'story_id',
        'user_story_id',
        'type',
    ];
}
