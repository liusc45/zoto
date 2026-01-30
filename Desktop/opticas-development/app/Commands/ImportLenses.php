<?php

namespace App\Commands;

use App\Entities\Consultation;
use App\Models\ConsultationModel;
use App\Models\ItemModel;
use App\Models\ItemPriceModel;
use App\Models\LensCorrectionTypeModel;
use App\Models\LensModel;
use App\Models\LensDesignModel;
use App\Models\LensMaterialModel;
use App\Models\LensTypeModel;
use App\Models\LensColorModel;
use App\Models\LensTreatmentModel;
use App\Models\PatientModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ImportLenses extends BaseCommand
{
    /**
     * Configura la ruta del CSV por defecto.
     */
    private string $defaultCsvPath = WRITEPATH . 'uploads/lentes.csv';
    private string $tempCsvPath    = WRITEPATH . 'uploads/Consultas.tmp.csv';

    /**
     * Si el CSV tiene cabecera en la primera fila, márcalo como true.
     */
    private bool $hasHeader = true;

    /**
     * Delimitador por defecto. Si es null, intentará detectarlo de forma simple.
     */
    private ?string $delimiter = null; // ',', ';', "\t" o null para autodetección

    /** Headers detectados en la lectura cuando $hasHeader = true */
    private array $lastHeaders = [];

    /** Delimitador usado finalmente (autodetectado si $delimiter viene null) */
    private ?string $lastDelimiter = null;
    protected $group = 'Import';
    protected $name = 'import:lenses';
    protected $description = 'Importa lentes desde un archivo CSV';

    private $materialIndexed;
    private $correctionTypeIndexed;
    private $designIndexed;
    private $typeIndexed;
    private $colorIndexed;
    private $treatmentIndexed;


    public function run(array $params)
    {
        $csvPath = $this->defaultCsvPath;



         if (! is_file($csvPath)) {
            throw new \RuntimeException("No se encontró el archivo CSV en: {$csvPath}");
        }

        $lensColors = model(LensColorModel::class)->findAll();
        $this->colorIndexed = array_reduce($lensColors, function ($acc, $color) {
            $acc[$color->id] = $color;
            return $acc;
        });
        $lensCTypes = model(LensCorrectionTypeModel::class)->findAll();
        $this->correctionTypeIndexed= array_reduce($lensCTypes, function ($acc, $type) {
            $acc[$type->id] = $type;
            return $acc;
        });

        $lensDesigns = model(LensDesignModel::class)->findAll();
        $this->designIndexed = array_reduce($lensDesigns, function ($acc, $design) {
            $acc[$design->id] = $design;
            return $acc;
        });

        $lensMaterials = model(LensMaterialModel::class)->findAll();
        $this->materialIndexed = array_reduce($lensMaterials, function ($acc, $material) {
            $acc[$material->id] = $material;
            return $acc;
        });

        $lensTreatments = model(LensTreatmentModel::class)->findAll();

        $this->treatmentIndexed = array_reduce($lensTreatments, function ($acc, $treatment) {
            $acc[$treatment->id] = $treatment;
            return $acc;
        });

        $lensTypes = model(LensTypeModel::class)->findAll();
        $this->typeIndexed = array_reduce($lensTypes, function ($acc, $type) {
            $acc[$type->id] = $type;
        });


        $rows = $this->readCsvRows($csvPath, $this->hasHeader, $this->delimiter);

        // Prepara archivo temporal de salida (evita truncar el original mientras leemos)
        $out = fopen($this->tempCsvPath, 'wb');
        if ($out === false) {
            throw new \RuntimeException("No se pudo abrir archivo temporal: {$this->tempCsvPath}");
        }

        try {

            $dataRow = [];
            foreach ($rows as $index => $row) {
                // Procesa la fila y obtén el ID resultante (define tu lógica adentro)
                $generatedId = $this->processRow($row);


                // Escribe el ID al final (sobrescribe/añade)
                $dataRow[] = $generatedId;

                //  fputcsv($out, $dataRow, $delim);
            }
            log_message("debug",json_encode($dataRow));

        } finally {
            fclose($out);
        }

    }

    /**
     * Lee un CSV y produce filas como arrays.
     * - Si $hasHeader es true, devuelve arrays asociativos usando la primera fila como cabecera.
     * - Si $hasHeader es false, devuelve arrays indexados.
     *
     * @param string      $filePath
     * @param bool        $hasHeader
     * @param string|null $delimiter
     * @return \Generator<int, array<string,mixed>|array<int,mixed>>
     */
    private function readCsvRows(string $filePath, bool $hasHeader = true, ?string $delimiter = null): \Generator
    {
        $handle = fopen($filePath, 'rb');
        if ($handle === false) {
            throw new \RuntimeException("No se pudo abrir el archivo CSV: {$filePath}");
        }

        try {
            // Lee la primera línea cruda para detectar BOM y delimitador si es necesario
            $firstLine = fgets($handle);
            if ($firstLine === false) {
                return;
            }

            // Elimina BOM UTF-8 si existe
            $firstLine = $this->stripBom($firstLine);

            // Si no viene delimitador, intenta detectarlo de forma sencilla
            $delim = $delimiter ?? $this->guessDelimiter($firstLine);
            $this->lastDelimiter = $delim;

            // Rebobina al inicio y vuelve a consumir la primera línea con fgetcsv para consistencia
            rewind($handle);

            // Si hay encabezado, construye la cabecera
            $headers = null;
            if ($hasHeader) {
                $headers = fgetcsv($handle, 0, $delim);
                if ($headers === false) {
                    return;
                }
                // Limpia espacios y BOM en el primer encabezado
                $headers = array_map(static function ($h) {
                    $h = trim((string) $h);
                    return $h;
                }, $headers);

                $this->lastHeaders = $headers;
            }

            // Itera sobre las filas siguientes
            while (($data = fgetcsv($handle, 0, $delim)) !== false) {
                // Salta filas completamente vacías
                if ($this->isEmptyRow($data)) {
                    continue;
                }

                if ($hasHeader) {
                    // Alinea con headers (si la fila tiene menos columnas, rellena con null)
                    $assoc = [];
                    $colCount = max(count($headers), count($data));
                    for ($i = 0; $i < $colCount; $i++) {
                        $key = $headers[$i] ?? "col{$i}";
                        $assoc[$key] = $data[$i] ?? null;
                    }
                    yield $assoc;
                } else {
                    yield $data;
                }
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * Define aquí cómo procesar cada fila y devolver el ID que quieres anexar.
     * Retorna string|int según corresponda.
     *
     * @param array<string,mixed>|array<int,mixed> $row
     * @return string|int|null
     */
    private function processRow(array $row): int|string|null
    {
        $name = $this->generateLensName($row);

        $itemData = [
            'name' => $name,
            'line' => 13,
            "stockable"=>0,
            'cost' => floatval($row["cost"]??0 ), // Índice del precio

        ];


        $itemId =model(ItemModel::class)->insert($itemData);
        $this->setLens($itemId,$row);
        return $itemId;

    }

    private function stripBom(string $line): string
    {
        $bom = "\xEF\xBB\xBF";
        if (strncmp($line, $bom, 3) === 0) {
            return substr($line, 3);
        }
        return $line;
    }

    private function guessDelimiter(string $sample): string
    {
        // Conteo simple de posibles delimitadores
        $candidates = [
            ','  => substr_count($sample, ','),
            ';'  => substr_count($sample, ';'),
            "\t" => substr_count($sample, "\t"),
            '|'  => substr_count($sample, '|'),
        ];

        arsort($candidates);

        // Toma el más frecuente; si todos 0, usa coma por defecto
        $top = array_key_first($candidates);
        if ($top === null || $candidates[$top] === 0) {
            return ',';
        }
        return $top;
    }

    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }
        return true;
    }

    private function setLens($item,$row): void
    {


        $lensModel = new LensModel();
        $itemPrice = new ItemPriceModel();

        $db = db_connect();
        $db->transStart();

        try {

            CLI::newLine();
            echo $item;
            CLI::newLine();
            echo "\n";
            // Daos del lente
            $lensData = [
                'item' => $item,
                // 'design' => $this->findOrCreateDesign($data[2]), // INCOLORO
                'category_sphere' => intval($row['category_sphere']), // CATEGORIA ESFERA
                'range_sphere' => $row['range_sphere'], // Rango Esfera
                'category_cylinder' => intval($row['category_cylinder']), // CATEGORIA CIL
                'range_cylinder' => $row['range_cylinder'], // Rango Cilindro
                'max_graduation' => intval($row['max_graduation']), // RANGO MAXIMO
                'over_processed' => $row['over_processed'], // Terminado o Procesado
                'arrival_days' => intval($row['arrival_days']), // Dias
                'frame_type' => intval($row['frame_type']), // armazon
                'optical_correction' => $row['optical_correction'], // CORECCION OPTICA
                'material' =>$row['material'], // MATERIAL
                'type' => $row['type'], // TIPO
                'color' => $row['color'], // COLOR
                'correction_type' => $row['correction_type'], // TIPO CORRECCION
                'treatment' => $row['treatment']===''?null:$row["treatment"], // TRATAMIENTO
                'comments' => implode(' ', [$row['range'],$row['interval1'],$row['interval2'],$row['interval3'],$row['interval4']])
            ];

            $lensPrice =[
                "item"=>$item,
                "type"=>'regular',
                "amount"=> $row['price'],
                "shipping_cost"=>0,


            ];
            $lensModel->insert($lensData);
            $itemPrice->insert($lensPrice);

            CLI::write($db->transStatus());

            $db->transComplete();

            if ($db->transStatus() === false) {
                CLI::error('Error en la transacción');
                $this->logger->error(json_encode($lensData));
                CLI::write($lensModel->db->getLastQuery());
                die();

            }

        } catch (\Exception | DatabaseException $e) {
            $db->transRollback();
            CLI::error($e->getMessage());
            $this->logger->error($e->getMessage());
            $this->logger->error(json_encode($lensPrice));
            die() ;
        }
    }



    private function generateLensName(array $data): string
    {
        CLI::newLine();
        CLI::write("generando nombre ");
        $oc =$data["optical_correction"] ??'';
        $material = $this->materialIndexed[$data["material"]]?->name ??'';
        $type = $this->typeIndexed[$data["type"]]?->name ??'';
        $color = $this->colorIndexed[$data["color"]]?->name ??'';
        $ct = $this->correctionTypeIndexed[     $data["correction_type"]]?->name ??'';
        $treatment = $this->treatmentIndexed[$data["treatment"]]?->name ??'';


        $nameParts = [
            $oc,
            $material,
            $type,
            $color,
            $ct,
            $treatment
        ];

        $name = implode(' ', array_filter($nameParts));
        $this->logger->info($name);
        CLI::write(" nombre : $name ");
        return $name;
    }

    private function findOrCreateDesign(string $name): ?int
    {
        if(empty($name))
        {
            return null;
        }
        CLI::write("Buscando nombre: {$name}");
        $this->designModel = new LensDesignModel();

        $design = $this->designModel->where('name', $name)->first();
        if (!$design) {
            $this->designModel->insert(['name' => $name]);
            return $this->designModel->getInsertID();
        }
        return $design->id;
    }

    private function findOrCreateMaterial(string $name): int
    {
        $this->materialModel = new LensMaterialModel();
        $material = $this->materialModel->where('name', $name)->first();
        if (!$material) {
            $this->materialModel->insert(['name' => $name]);
            return $this->materialModel->getInsertID();
        }
        return $material->id;
    }

    private function findOrCreateType(string $name): int
    {
        $this->typeModel = new LensTypeModel();

        $type = $this->typeModel->where('name', $name)->first();
        if (!$type) {
            $this->typeModel->insert(['name' => $name]);
            return $this->typeModel->getInsertID();
        }
        return $type->id;
    }

    private function findOrCreateColor(string $name): int
    {
        $this->colorModel = new LensColorModel();

        $color = $this->colorModel->where('name', $name)->first();
        if (!$color) {
            $this->colorModel->insert(['name' => $name]);
            return $this->colorModel->getInsertID();
        }
        return $color->id;
    }

    private function findOrCreateTreatment(string $name): ?int
    {
        if($name==='NO APLICA')
        {
            return null;
        }
        $this->treatmentModel = new LensTreatmentModel();

        $treatment = $this->treatmentModel->where('name', $name)->first();
        if (!$treatment) {
            $this->treatmentModel->insert(['name' => $name,'created_by'=>1]);
            return $this->treatmentModel->getInsertID();
        }
        return $treatment->id;
    }
}