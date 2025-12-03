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
            'id' => 1,
            'question' =>
                "Fui entrenado para poder resolver las dudas más frecuentes relacionadas con nuestra Dirección. Por favor, elija una de las opciones de más abajo:",
            'options' => ['Retiros', 'Pensiones'],
            'next_nodes' => [
                'Retiros' => 2,
                'Pensiones' => 3
            ],
            'is_end' => false
        ]);

        ChatNode::create([
            'id' => 2,
            'question' => 'Para retiros puedo ayudarlo con...',
            'options' => ['Certificados'],
            'next_nodes' => [
                'Certificados' => 4,
            ],
            'is_end' => false
        ]);

        ChatNode::create([
            'id' => 3,
            'question' => 'Sobre Pensiones puedo ayudarlo con lo siguiente...',
            'options' => ['A donde debo dirigirme para iniciar una pensión militar'],
            'next_nodes' => [
                'A donde debo dirigirme para iniciar una pensión militar' => 5
            ],
            'is_end' => false
        ]);

        ChatNode::create([
            'id' => 4,
            'question' =>
                'Los certificados que otorga la Dirección de Bienestar son los siguientes:
                -ANSES
                -HABER TOPE
                -DESTINOS FINES LABORALES (EMPRESA DE SEGURIDAD)
                -SERVICIOS MILITARES FINES LABORALES (FECHA DE INGRESO Y RETIRO)
                -MOVILIZADOS
                -NO MOVILIZADO CERTIFICANDO QUE PRESTO SERVICIO EN LA UNIDAD CERCANA',
            'options' => [],
            'next_nodes' => [],
            'is_end' => true
        ]);

         ChatNode::create([
            'id' => 5,
            'question' =>
                'Puede realizarlo de manera presencial en la Unidad Militar más próxima a su domicilio.',
            'options' => [],
            'next_nodes' => [],
            'is_end' => true
        ]);
    }
}
