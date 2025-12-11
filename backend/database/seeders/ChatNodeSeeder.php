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
            'options' => [
                ["text" => "Retiros", "next_node" => 2],
                ["text" => "Pensiones", "next_node" => 3]
            ]
        ]);

        ChatNode::create([
            'title' => 'Retiros',
            'message' => 'Para retiros puedo ayudarlo con...',
            'options' => [
                ["text" => "Certificados", "next_node" => 4]
            ]
        ]);

        ChatNode::create([
            'title' => 'Pensiones',
            'message' => 'Sobre Pensiones puedo ayudarlo con lo siguiente...',
            'options' => [
                ["text" => "Iniciar Pension", "next_node" => 5]
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
            'options' => [
                ["text" => "Quiero hacer otra consula", "next_node" => 1]
            ]
        ]);

         ChatNode::create([
            'title' => 'Iniciar Pensión',
            'message' =>
                'Puede realizarlo de manera presencial en la Unidad Militar más próxima a su domicilio.',
            'options' => [
                ["text" => "Quiero hacer otra consula", "next_node" => 1]
            ]
        ]);
    }
}
