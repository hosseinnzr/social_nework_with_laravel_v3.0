<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'UID'); // Assuming 'UID' is the foreign key
    }
    
    protected $table = 'post';

    protected $fillable = [
        'UID',
        'title',
        'post',
        'tag',
        'delete',
        'like',
        'like_number',
        'post_picture',
        'post_number',
        'post_video',
        ];
}
