<?php

namespace App\Http\Controllers;

use App\Models\ChatNode;
use Exception;
use Illuminate\Http\Request;

class ChatNodeController extends Controller
{
    public function get_all_nodes() {
        return ChatNode::all();
    }

    public function get_node_by_id($id) {
        return ChatNode::find($id);
    }

    public function insert(Request $request) {
        try{
            $title = $request->title;
            if (!$title) {
                $lastId = (ChatNode::max('id') ?? 0) + 1;
                $title = "Node " . $lastId;
            }

            ChatNode::create([
                'title' => $title,
                'message' => $request->message,
                'next_nodes' => $request->input('next_nodes'),
            ]);

            $response = [
                'message' => 'El mensaje se creo correctamente.',
                'status' => 201
            ];

            return response()->json($response);
        } catch(Exception $e) {
            $response = [
                'message' => 'Ocurrio un error, revise los campos o hablen con desarrollo XD',
                'error' => $e,
                'status' => 500
            ];

            return response()->json($response);
        }
    }

    public function update($id, Request $request){
        try {
            $node = ChatNode::find($id);

            $title = $request->title;
            if (!$title) {
                $title = "Node " . $id;
            }

            $node->title = $title;
            $node->message = $request->message;
            $node->next_nodes = $request->input('next_nodes');

            $node->save();

            $response = [
                'message' => 'El mensaje se actualizo correctamente. Bien peke',
                'status' => 500
            ];

            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'message' => 'Ocurrio un error, revise los campos o hablen con desarrollo XD',
                'error' => $e,
                'status' => 500
            ];

            return response()->json($response);
        }
    }

    public function destroy($id) {
        try {
            if ($id == 1) {
                $response = [
                    'message' => 'No se puede eliminar el nodo inicial.',
                    'status' => 400
                ];

                return response()->json($response);
            }

            $node = ChatNode::find($id);
            $node->delete();

            $response = [
                'message' => 'El mensaje se elimino correctamente',
                'status' => 201
            ];

            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'message' => 'Ocurrio un error, revise los campos o hablen con desarrollo XD',
                'error' => $e,
                'status' => 500
            ];

            return response()->json($response);
        }
    }

    public function start() {
        return ChatNode::find(1);
    }

    public function next(Request $request) {
        $node = ChatNode::find($request->node_id);
        $nextId = $node->next_nodes[$request->selected_option];

        return ChatNode::find($nextId);
    }
}
