<?php

namespace App\Http\Controllers;

use App\Models\ChatNode;
use Illuminate\Http\Request;

class ChatNodeController extends Controller
{
    public function start() {
        return ChatNode::find(1);
    }

    public function next(Request $request) {
        $node = ChatNode::find($request->node_id);
        $nextId = $node->next_nodes[$request->selected_option];

        return ChatNode::find($nextId);
    }
}
