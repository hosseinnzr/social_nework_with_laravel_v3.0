<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likeComment extends Model
{
    use HasFactory;
    

    protected $table = 'like_comment';

    protected $fillable = [
        'id',
        'UID',
        'comment_id',
        'user_comment_id',
        'type',
    ];
}