<?php

namespace Database\Seeders;

use App\Models\ChatNode;
use App\Models\NodeOption;
use App\Models\NodePosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatNodeSeeder extends Seeder
{
    public function run(): void
    {
        //Nodos

        $inicio = ChatNode::create([
            'title' => 'Inicio',
            'message' =>
                "¡Hola! Soy Chatbot. Estoy acá para guiarte por el trabajo de Nahuel Palacio, desarrollador full-stack, y mostrarte sus proyectos de manera interactiva. Podés elegir por dónde empezar:"
        ]);

        $sobre_mi = ChatNode::create([
            'title' => 'Sobre mi',
            'message' => 'Tengo que usar el cerebro'
        ]);

        $sobre_chatbot = ChatNode::create([
            'title' => 'Sobre Chatbot',
            'message' => 'Tengo que usar el cerebro otra vez'
        ]);

        // Opciones

        NodeOption::create([
            'chat_node_id' => $inicio->id,
            'text' => 'Sobre mi',
            'next_node' => $sobre_mi->id
        ]);

        NodeOption::create([
            'chat_node_id' => $inicio->id,
            'text' => 'Sobre Chatbot',
            'next_node' => $sobre_chatbot->id
        ]);

        // Positions

        NodePosition::create([
            'chat_node_id' => $inicio->id,
            'x' => 0,
            'y' => 0
        ]);

        NodePosition::create([
            'chat_node_id' => $sobre_mi->id,
            'x' => -300,
            'y' => 250
        ]);

        NodePosition::create([
            'chat_node_id' => $sobre_chatbot->id,
            'x' => 300,
            'y' => 250
        ]);
    }
}
