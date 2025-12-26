<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NodePosition extends Model
{
    protected $fillable = [
        'chat_node_id',
        'x',
        'y',
    ];

    public function node()
    {
        return $this->belongsTo(ChatNode::class, 'chat_node_id');
    }
}
