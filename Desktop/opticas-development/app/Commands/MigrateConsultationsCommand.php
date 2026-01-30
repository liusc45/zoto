<?php

namespace App\Commands;

use App\Models\OldConsultasModel;
use App\Models\ConsultationModel;
use App\Models\PrescriptionModel;
use App\Models\ConsultationVisualBackgroundModel;
use App\Models\ConsultationContactLensesModel;
use App\Models\ConsultationGeneralBackgroundModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigrateConsultationsCommand extends BaseCommand
{
    protected $group = 'Migration';
    protected $name = 'migrate:consultations';
    protected $description = 'Migra los registros de la tabla Consultas antigua al nuevo modelo normalizado.';
    protected $usage = 'migrate:consultations';

    public function run(array $params)
    {
        $oldModel = new OldConsultasModel(); // Modelo que apunta a la tabla Consultas
        $consultationModel = new ConsultationModel();
        $prescriptionModel = new PrescriptionModel();
        $visualBackgroundModel = new ConsultationVisualBackgroundModel();
        $contactLensModel = new ConsultationContactLensesModel();
        $generalBackgroundModel = new ConsultationGeneralBackgroundModel();

        $consultas = $oldModel->findAll();

        foreach ($consultas as $consulta) {
            // Insertar en consultations
            $consultationId = $consultationModel->insert([
                'patient'     => $consulta['Clientes'],
                'attended_by' => 1, // Actualizar con ID real del doctor
                'created_at'  => $consulta['fecha_consulta'],
            ], true); // true para retornar el ID

            // Insertar en prescriptions
            $prescriptionModel->insert([
                'patient'              => $consulta['Clientes'],
                'consultation'         => $consultationId,
                'consultation_date'    => $consulta['fecha_consulta'],
                'total_right_sphere'   => $consulta['GDESF'] ?? null,
                'total_left_sphere'    => $consulta['GIESF'] ?? null,
                'total_right_cylinder' => $consulta['GDCIL'] ?? null,
                'total_left_cylinder'  => $consulta['GICIL'] ?? null,
                'total_right_axis'     => $consulta['GDEJE'] ?? null,
                'total_left_axis'      => $consulta['GIEJE'] ?? null,
                'total_right_addition' => $consulta['GDADD'] ?? null,
                'total_left_addition'  => $consulta['GIADD'] ?? null,
            ]);

            // Insertar en consultation_visual_background
            $visualBackgroundModel->insert([
                'consultation'           => $consultationId,
                'glasses'                => $consulta['USADOANTEOJOS'] ?? null,
                'rx_prev_right_sphere'   => $consulta['GDESF'] ?? null,
                'rx_prev_left_sphere'    => $consulta['GIESF'] ?? null,
                'rx_prev_right_cylinder' => $consulta['GDCIL'] ?? null,
                'rx_prev_left_cylinder'  => $consulta['GICIL'] ?? null,
                'rx_prev_right_axis'     => $consulta['GDEJE'] ?? null,
                'rx_prev_left_axis'      => $consulta['GIEJE'] ?? null,
                'rx_prev_right_add'      => $consulta['GDADD'] ?? null,
                'rx_prev_left_add'       => $consulta['GIADD'] ?? null,
                'comments'               => $consulta['SEGMANTPOST'] ?? null,
            ]);

            // Insertar en consultation_contact_lenses
            $contactLensModel->insert([
                'consultation'                => $consultationId,
                'patient'                     => $consulta['Clientes'],
                'right_keratometry_a'         => $consulta['LCDQ'] ?? null,
                'right_keratometry_b'         => $consulta['LCDC'] ?? null,
                'right_base'                  => $consulta['LCDAP'] ?? null,
                'right_diameter'              => $consulta['LCDP'] ?? null,
                'right_cpp'                   => $consulta['LCDRL'] ?? null,
                'right_thickness'             => null,
                'left_keratometry_a'          => $consulta['LCIQ'] ?? null,
                'left_keratometry_b'          => $consulta['LCIC'] ?? null,
                'left_base'                   => $consulta['LCIAP'] ?? null,
                'left_diameter'               => $consulta['LCIP'] ?? null,
                'left_cpp'                    => $consulta['LCIRL'] ?? null,
                'left_thickness'              => null,
                'contact_right_acuity_after'  => $consulta['LCDAV'] ?? null,
                'contact_left_acuity_after'   => $consulta['LCIAV'] ?? null,
                'suggested'                   => $consulta['LCUSO'] ? 1 : null,
            ]);

            $generalBackgroundModel->insert([
                'consultation'             => $consultationId,
                'healthy'                  => ($consulta['Salud_General'] === 'Saludable') ? 1 : 0,
                'comments'                 => $consulta['NOTAS'] ?? null,
                'observations'            => $consulta['NOTAS'] ?? null,
            ]);
        }

        CLI::write('✔ Migración completada con éxito.', 'green');
    }
}
