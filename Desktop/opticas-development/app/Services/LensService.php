<?php

namespace App\Services;

use App\Models\ItemModel;
use App\Models\LensColorModel;
use App\Models\LensCorrectionTypeModel;
use App\Models\LensDesignModel;
use App\Models\LensMaterialModel;
use App\Models\LensModel;
use App\Models\LensTreatmentModel;
use App\Models\LensTypeModel;
use App\Models\RangeModel;

class LensService
{
    protected ItemModel $itemModel;
    protected LensModel $lensModel;

    private array $properties = [
        "id",
        "design",
        "category_sphere",
        "range_sphere" ,
        "category_cylinder",
        "range_cylinder",
        "max_graduation" ,
        "over_processed" ,
        "arrival_days" ,
    ];
    private array $catalogs = [
        //"correction_types"=>"Tipo Corrección",
        "ranges"=>"Rangos",
        "designs" => "Diseño",
        "materials" => "Materiales",
        "types" => "Tipos",
        "colors" => "Colores",
        "treatments" => "Tratamientos",
    ];


    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->lensModel = new LensModel();
    }
    public function createLensItem(array $lensData): ?int
    {
        // Preparar los datos básicos del item
        $itemData = [
            'name' => $this->generateLensName($lensData),
            'cost' => 195.00, // Precio especificado en los datos
            // El key puede ser generado con un formato específico
            'key' => 'LENS-' . uniqid(),
            // Podemos dejar barcode como null inicialmente
            'line' => null, // Si tienes una línea específica para lentes
            'brand' => null, // Si tienes una marca específica para este tipo de lentes
            // El color podría ser mapeado desde el color del lente si es necesario
        ];

        // Insertar el item
        if ($this->itemModel->insert($itemData)) {
            return $this->itemModel->getInsertID();
        }

        return null;
    }

    private function generateLensName(array $lensData): string
    {
        // Construir un nombre descriptivo basado en los datos del lente
        $parts = [];

        // Material (CR-39)
        $parts[] = "CR-39";

        // Color (BLANCO)
        $parts[] = "BLANCO";

        // Tipo (MONOFOCAL)
        $parts[] = "MONOFOCAL";

        // Rango de esfera
        $rangeSphere = "+2.00 a -2.00";
        $parts[] = "ESF: {$rangeSphere}";

        // Tratamiento (SIN AR)
        $parts[] = "SIN AR";

        return implode(' ', $parts);
    }

    public function createFullLens(array $lensData): bool
    {
        try {
            $this->db->transStart();

            // Primero crear el item
            $itemId = $this->createLensItem($lensData);

            if (!$itemId) {
                return false;
            }

            // Luego crear el lente con la referencia al item
            $lensData['item'] = $itemId;

            // Mapear los datos del lente según la estructura de la tabla
            $mappedLensData = [
                'item' => $itemId,
                'design' => 1, // Según los datos proporcionados
                'category_sphere' => 0, // De los datos
                'range_sphere' => '+2.00', // De los datos
                'category_cylinder' => 0, // De los datos
                'range_cylinder' => '-2.00', // De los datos
                'max_graduation' => 6, // De los datos
                'over_processed' => 'T', // Terminado
                'arrival_days' => 5, // De los datos
                'frame_type' => 1, // De los datos
                'optical_correction' => 'MONOFOCAL',
                'material' => 1, // CR-39
                'type' => 1, // De los datos
                'color' => 1, // BLANCO
                'correction_type' => 'NO', // NO APLICA
                'treatment' => 2, // SIN AR
                'comments' => 'NO APLICA'
            ];

            $success = $this->lensModel->insert($mappedLensData);

            $this->db->transComplete();

            return $success && $this->db->transStatus();

        } catch (\Exception $e) {
            log_message('error', 'Error creando lente: ' . $e->getMessage());
            return false;
        }
    }


    public function getCatalogs(): array
    {
        return $this->catalogs;
    }
    public function getProperties(): array
    {
        return $this->properties;
    }
    
    public function getCatalogsData(): array
    {
        return [
            "ranges"=>model(RangeModel::class)->findAll(),
            //"correction_types"=>model(LensCorrectionTypeModel::class)->findAll(),
            "designs"=>model(LensDesignModel::class)->findAll(),
            "materials"=>model(LensMaterialModel::class)->findAll(),
            "types"=>model(LensTypeModel::class)->findAll(),
            "colors"=>model(LensColorModel::class)->findAll(),
            "treatments"=>model(LensTreatmentModel::class)->findAll(),
        ];
    }
    
}
