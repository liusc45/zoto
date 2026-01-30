<?php

namespace App\Database\Seeds;

use App\Entities\Patient;
use App\Entities\Person;
use App\Models\CompanyModel;
use App\Models\OccupationModel;
use App\Models\PatientModel;
use App\Models\PersonModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Config\Database;

class PatientsOrigin extends Seeder
{
    private array $apellidoTokens = [
        'de', 'del', 'de la', 'de los', 'de las', 'la', 'las', 'los'
    ];

    public function run()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        $occupations = model(OccupationModel::class)->findAll();
        $acc = [];
        $occupations = array_reduce($occupations, function ($carry, $occupation) {
            $carry[$occupation->title] = $occupation->id;
            return $carry;
        }, $acc);

        $personModel = new PersonModel();
        $patientModel = new PatientModel();

        $originDb = db_connect("access");
        $customersTable = $originDb->table('customers');

        $originCustomer = $customersTable->get()->getResultArray();

        foreach ($originCustomer as $customer) {
            $newPatient = new Patient();

            [$nombres, $apellidoPaterno, $apellidoMaterno] = $this->separarNombre($customer["Nombre"]);

            $dob = ($customer["dob"] ?? false) ? Time::parse($customer["dob"])->toDateString() : null;

            $newPerson = new Person([
                "last_name" => trim($apellidoPaterno . ' ' . $apellidoMaterno),
                "name" => trim($nombres),
                "dob" => $dob,
                "street" => $customer["Direccion"],
                "city" => $customer["Ciudad"],
                "state" => $customer["Estado"],
                "postal_code" => $customer["CP"],
                "occupation" => $this->resolveOccupationId($occupations, $customer['Puesto']),
            ]);

            $company = model(CompanyModel::class)->where("name", $customer["Empresa"])->first();

            $newPatient->fill([
                "person" => $personModel->insert($newPerson),
                "store" => 1,
                "user" => null,
                "company" => $company?->id,
                "original_id" => $customer["id"],
                "card_id" => $customer["card_id"]
            ]);

            $patientModel->save($newPatient);
        }
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

    private function resolveOccupationId(array $occupationMap, ?string $title): ?int
    {
        /**
         * @param array<string,int> $occupationMap Mapa título => id
         * @param string|null $title Título de ocupación
         * @return int|null Id de ocupación o null si no aplica
         */
        if ($title === null || $title === '') {
            return null;
        }

        return $occupationMap[$title] ?? null;
    }

}
