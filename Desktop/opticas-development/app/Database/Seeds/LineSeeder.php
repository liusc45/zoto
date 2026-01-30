<?php

namespace App\Database\Seeds;

use App\Models\LineModel;
use CodeIgniter\Database\Seeder;

class LineSeeder extends Seeder
{
    public function run()
    {
        $lines = [
            ["name"=>"Armazon Oftalmico"],
            ["name"=>"Armazon Solar"],
            ["name"=>"Lente de Contacto"],
            ["name"=>"Portalentes"],
            ["name"=>"Gotas"],
            ["name"=>"Soluciones"],
            ["name"=>"Micas"],
            ["name"=>"Paños"],
            ["name"=>"Plaquetas"],
            ["name"=>"Puentes"],
            ["name"=>"Accesorios"],
            ["name"=>"Varillas"]
        ];


        model(LineModel::class)->insertBatch($lines);

    }
}
