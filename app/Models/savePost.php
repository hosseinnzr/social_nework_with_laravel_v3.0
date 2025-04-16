<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class savePost extends Model
{
    use HasFactory;

    protected $table = 'save_post';

    protected $fillable = [
        'id',
        'UID',
        'post_id',
        'user_post_id',
    ];
}
