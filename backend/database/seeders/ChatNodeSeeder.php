<?php

namespace Database\Seeders;

use App\Models\ChatNode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatNodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatNode::create([
            'title' => 'Inicio',
            'message' =>
                "Fui entrenado para poder resolver las dudas más frecuentes relacionadas con nuestra Dirección. Por favor, elija una de las opciones de más abajo:",
            'next_nodes' => [
                'Retiros' => 2,
                'Pensiones' => 3
            ]
        ]);

        ChatNode::create([
            'title' => 'Retiros',
            'message' => 'Para retiros puedo ayudarlo con...',
            'next_nodes' => [
                'Certificados' => 4,
            ]
        ]);

        ChatNode::create([
            'title' => 'Pensiones',
            'message' => 'Sobre Pensiones puedo ayudarlo con lo siguiente...',
            'next_nodes' => [
                'A donde debo dirigirme para iniciar una pensión militar' => 5
            ]
        ]);

        ChatNode::create([
            'title' => 'Certificados',
            'message' =>
                'Los certificados que otorga la Dirección de Bienestar son los siguientes:
                -ANSES
                -HABER TOPE
                -DESTINOS FINES LABORALES (EMPRESA DE SEGURIDAD)
                -SERVICIOS MILITARES FINES LABORALES (FECHA DE INGRESO Y RETIRO)
                -MOVILIZADOS
                -NO MOVILIZADO CERTIFICANDO QUE PRESTO SERVICIO EN LA UNIDAD CERCANA',
            'next_nodes' => []
        ]);

         ChatNode::create([
            'title' => 'Iniciar Pensión',
            'message' =>
                'Puede realizarlo de manera presencial en la Unidad Militar más próxima a su domicilio.',
            'next_nodes' => []
        ]);
    }
}
