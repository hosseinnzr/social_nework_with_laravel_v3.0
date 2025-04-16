<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class story extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'UID'); // Assuming 'UID' is the foreign key
    }
    
    protected $table = 'story';

    protected $fillable = [
        'UID',
        'title',
        'description',
        'story_picture',
        'like',
        'like_number'
        ];
}
