<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatNode extends Model
{
    protected $fillable = [
        'title',
        'message',
        'options',
        'next_nodes',
    ];

    protected $casts = [
        'options' => 'array',
        'next_nodes' => 'array',
    ];

    protected $table = 'chatnode';
}
