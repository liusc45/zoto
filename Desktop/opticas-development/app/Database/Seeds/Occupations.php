<?php

namespace App\Database\Seeds;

use App\Models\OccupationModel;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;
use Config\Database;

class Occupations extends Seeder
{
    public function run()
    {
        $occupations = Database::connect("base")
            ->table('Clientes')
            ->select("DISTINCT(puesto) as title")
            ->where("puesto is not null")
            ->get()->getResultArray();

        try {
            model(OccupationModel::class)->insertBatch($occupations);
        } catch (\ReflectionException $e) {
            CLI::write($e->getMessage());
        }
        CLI::write("Ocupaciones insertadas : ".count($occupations));
    }
}
