<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hashtag extends Model
{
    use HasFactory;

    protected $table = 'hashtag';

    protected $fillable = [
        'id',
        'name',
        'number',
        'post_id',
    ];
}
