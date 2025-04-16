<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversations extends Model
{
    use HasFactory;

    
    protected $table = 'conversations';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'deleted_at',
    ];
}
