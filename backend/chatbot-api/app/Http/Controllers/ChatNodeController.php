<?php

namespace App\Http\Controllers;

use App\Models\ChatNode;
use Illuminate\Http\Request;

class ChatNodeController extends Controller
{
    public function start() {
        return ChatNode::find(1);
    }

    public function next($node, $option) {
        $node = ChatNode::find($node);
        $nextId = $node->next_nodes[$option];

        return ChatNode::find($nextId);
    }
}
