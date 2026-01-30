<?php

namespace App\Database\Seeds;

use App\Models\PersonModel;
use CodeIgniter\Database\Seeder;

class PatientNamesUpdate extends Seeder
{
    private array $apellidoTokens = [
        'de', 'del', 'de la', 'de los', 'de las', 'la', 'las', 'los'
    ];

    public function run()
    {
        $model = new PersonModel();
        $persons = $model
            ->select(["id", "concat_ws(' ',name,last_name) as full_name"])
            ->findAll();

        foreach ($persons as $person){
            [$_lastName, $_motherName, $_names] = $this->separarNombre($person->full_name);

            $person->fill([
                "last_name" => trim($_lastName . ' ' . $_motherName),
                "name" => trim($_names),
            ]);
        }
       $model->updateBatch($persons,'id');

    }
    /**
     * Separa en Apellido Paterno, Apellido Materno y Nombres
     *
     * @param string $nombreCompleto
     * @return array [apellidoPaterno, apellidoMaterno, nombres]
     */
    private function separarNombre(string $nombreCompleto): array
    {
        $partes = preg_split('/\s+/', trim($nombreCompleto));
        $apellidoPaterno = '';
        $apellidoMaterno = '';
        $nombres = '';

        if (count($partes) >= 2) {
            // Asignamos las dos primeras posiciones como base
            $apellidoPaterno = array_shift($partes);
            $apellidoMaterno = array_shift($partes);

            // Revisar partículas en el apellido paterno
            while (!empty($partes)) {
                $next = strtolower($partes[0]);
                if (in_array($next, $this->apellidoTokens)) {
                    $apellidoPaterno .= ' ' . array_shift($partes);
                } else {
                    break;
                }
            }

            // Revisar partículas en el apellido materno
            while (!empty($partes)) {
                $next = strtolower($partes[0]);
                if (in_array($next, $this->apellidoTokens)) {
                    $apellidoMaterno .= ' ' . array_shift($partes);
                } else {
                    break;
                }
            }

            // Lo que quede son los nombres
            $nombres = implode(' ', $partes);
        } else {
            $nombres = $nombreCompleto;
        }

        return [$apellidoPaterno, $apellidoMaterno, $nombres];
    }
}
