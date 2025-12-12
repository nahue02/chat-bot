<?php

namespace Database\Seeders;

use App\Models\ChatNode;
use App\Models\NodeOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatNodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Inicio
        $inicio = ChatNode::create([
            'title' => 'Inicio',
            'message' =>
                "Fui entrenado para poder resolver las dudas más frecuentes relacionadas con nuestra Dirección.
                Por favor, elija una de las opciones de más abajo:"
        ]);

        // 2. Retiros
        $retiros = ChatNode::create([
            'title' => 'Retiros',
            'message' => 'Para retiros puedo ayudarlo con...'
        ]);

        // 3. Pensiones
        $pensiones = ChatNode::create([
            'title' => 'Pensiones',
            'message' => 'Sobre Pensiones puedo ayudarlo con lo siguiente...'
        ]);

        /*
        |--------------------------------------------------------------------------
        | OPCIONES
        |--------------------------------------------------------------------------
        */

        // Inicio → Retiros / Pensiones
        NodeOption::create([
            'chat_node_id' => $inicio->id,
            'text' => 'Retiros',
            'next_node' => $retiros->id
        ]);

        NodeOption::create([
            'chat_node_id' => $inicio->id,
            'text' => 'Pensiones',
            'next_node' => $pensiones->id
        ]);
    }
}
