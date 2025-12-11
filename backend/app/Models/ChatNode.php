<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatNode extends Model
{
    protected $fillable = [
        'title',
        'message',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    protected $table = 'chatnode';
}
