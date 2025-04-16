<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'UID'); // Assuming 'UID' is the foreign key
    }
    
    protected $table = 'comments';

    protected $fillable = [
        'post_id',
        'comment_value',
        'UID',
        'user_name',
        'user_profile',
        'isDeleted'
    ];
}
