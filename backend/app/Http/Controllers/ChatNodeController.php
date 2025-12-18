<?php

namespace App\Http\Controllers;

use App\Models\ChatNode;
use App\Models\NodeOption;
use Exception;
use Illuminate\Http\Request;

class ChatNodeController extends Controller
{
    public function index() {
        return ChatNode::with('options')->get();
    }

    public function show($id) {
        $node = ChatNode::with('options')->find($id);

         if (!$node) {
            return response()->json(['message' => 'Nodo no encontrado'], 404);
        }

        return $node;
    }

    public function store(Request $request) {
        $request->validate([
                'title' => 'nullable|string',
                'message' => 'required|string',
                'options' => 'array',
                'options.*.text' => 'required|string',
                'options.*.next_node' => 'required|integer|exists:chat_node,id',
        ]);

        try{
            $node = ChatNode::create([
                'title' => $request->title ?? 'Node ' . (ChatNode::max('id') + 1),
                'message' => $request->message,
            ]);

            foreach ($request->options as $opt) {
                NodeOption::create([
                    'chat_node_id' => $node->id,
                    'text' => $opt['text'],
                    'next_node' => $opt['next_node'],
                ]);
            }

            return response()->json(['message' => 'Nodo creado correctamente'], 201);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id, Request $request){
        $request->validate([
                'title' => 'nullable|string',
                'message' => 'required|string',
                'options' => 'array',
                'options.*.text' => 'required|string',
                'options.*.next_node' => 'required|integer|exists:chat_node,id',
        ]);

        try {
            $node = ChatNode::find($id);

            if (!$node) {
                return response()->json(['message' => 'Nodo no encontrado'], 404);
            }

            foreach ($request->options as $opt) {
                if ($node->id == $opt['next_node']){
                    return response()->json(['message' => 'Una opción no puede dirigir al mismo nodo'], 400);
                }
            }

            $node->update(([
                'title' => $request->title ?? 'Node ' . $id,
                'message' => $request->message,
            ]));

            NodeOption::where('chat_node_id', $id)->delete();

            foreach ($request->options as $opt) {
                NodeOption::create([
                    'chat_node_id' => $node->id,
                    'text' => $opt['text'],
                    'next_node' => $opt['next_node'],
                ]);
            }

            return response()->json(['message' => 'Nodo actualizado correctamente'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id) {
        $node = ChatNode::find($id);

        if (!$node) {
            return response()->json(['message' => 'Nodo no encontrado'], 404);
        }

        $node->delete();

        return response()->json(['message' => 'Nodo eliminado correctamente'], 200);
    }

    public function start() {
        return ChatNode::with('options')->find(1);
    }

    public function next(Request $request) {
        $nextId = $request->selected_option;
        return ChatNode::with('options')->find($nextId);
    }
}
