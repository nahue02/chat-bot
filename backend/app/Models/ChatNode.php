<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatNode extends Model
{
    protected $fillable = [
        'title',
        'question',
        'options',
        'next_nodes',
        'is_end'
    ];

    protected $casts = [
        'options' => 'array',
        'next_nodes' => 'array',
    ];

    protected $table = 'chatnode';
}
