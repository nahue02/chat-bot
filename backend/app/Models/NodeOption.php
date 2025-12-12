<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NodeOption extends Model
{
    protected $fillable = [
        'chat_node_id',
        'text',
        'next_node',
    ];

    public function node()
    {
        return $this->belongsTo(ChatNode::class, 'chat_node_id');
    }
}
