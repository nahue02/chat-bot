<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatNode extends Model
{
    protected $fillable = [
        'title',
        'message',
        'next_nodes',
    ];

    protected $casts = [
        'next_nodes' => 'array',
    ];

    protected $table = 'chatnode';
}
