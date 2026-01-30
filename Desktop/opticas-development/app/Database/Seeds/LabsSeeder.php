<?php

namespace App\Database\Seeds;

use App\Entities\Company;
use App\Models\CompanyModel;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;
use ReflectionException;

class LabsSeeder extends Seeder
{
    /**
     * @throws ReflectionException
     */
    public function run(): void
    {
        $labs = [ 'Argos - Centro Optico',
            'Articulos Opticos de Higiene y Seguridad',
            'Centro Integral Optico',
            'ESSILOR',
            'Ga',
            'Lab-España',
            'Paco',
            'Ricardo',
            'Corporativo STAR LAB',
            'Pedro Vargas',
            '- - - - - - - - - -',
            'Blas Cardenas y Asociados',
            'Hidrosoft de Mexico',
            'Lumilent'
        ];

        $laboratorios =[];

        foreach ($labs as $lab) {
            $laboratorios[] = new Company([
                "name" => $lab,
                "type" => "lab",
                "contact"=>null,
                "address"=> null,
                "phone"=> null,
            ]);
        }

        $labModel = new CompanyModel();

        $saved = $labModel->insertBatch($laboratorios);

        CLI::write("laboratorios insertados: $saved"  );
    }
}
