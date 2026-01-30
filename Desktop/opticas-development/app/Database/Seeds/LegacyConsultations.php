<?php

namespace App\Database\Seeds;

use App\Entities\Consultation;
use App\Entities\GeneralBackground;
use App\Entities\Prescription;
use App\Entities\PrescriptionDetail;
use App\Entities\VisualEvaluation;
use App\Models\ConsultationModel;
use App\Models\GeneralBackgroundModel;
use App\Models\PatientModel;
use App\Models\PrescriptionDetailModel;
use App\Models\PrescriptionModel;
use App\Models\VisualEvaluationModel;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class LegacyConsultations extends Seeder
{
    /**
     * Configura la ruta del CSV por defecto.
     */
    private string $defaultCsvPath = WRITEPATH . 'uploads/Consultas.csv';
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

    public function run()
    {
        $csvPath = $this->defaultCsvPath;

        if (! is_file($csvPath)) {
            throw new \RuntimeException("No se encontró el archivo CSV en: {$csvPath}");
        }

        $rows = $this->readCsvRows($csvPath, $this->hasHeader, $this->delimiter);

        // Prepara archivo temporal de salida (evita truncar el original mientras leemos)
        $out = fopen($this->tempCsvPath, 'wb');
        if ($out === false) {
            throw new \RuntimeException("No se pudo abrir archivo temporal: {$this->tempCsvPath}");
        }

        try {
     
            foreach ($rows as $index => $row) {
                // Procesa la fila y obtén el ID resultante (define tu lógica adentro)
                $generatedId = $this->processRow($row);

                // Prepara la fila de salida respetando el orden original y agregando/actualizando el ID al final
                if ($this->hasHeader) {
                    $dataRow = [];
                    foreach ($this->lastHeaders as $h) {
                        // Si el CSV ya traía 'resultado_id', lo ignoramos aquí para reemplazarlo al final
                        if ($h === 'resultado_id') {
                            continue;
                        }
                        $dataRow[] = $row[$h] ?? null;
                    }
                } else {
                    $dataRow = array_values($row);
                }

                // Escribe el ID al final (sobrescribe/añade)
                $dataRow[] = $generatedId;

                log_message("debug",json_encode($dataRow));
              //  fputcsv($out, $dataRow, $delim);
            }
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
        $patient = model(PatientModel::class)->where("original_id",$row["original_id"])->first();

        if(is_null($patient))
        {
            CLI::write("Paciente no encontrado:". json_encode($row),"red");
            log_message("info","paciente no encontrado:". json_encode($row));
            return null;
        }
        $doctor = $row["doctor"];

        $comments = $this->setLegacyComments($row);
        if(($doctor ==='Dra. Monica Duran' || $doctor === 'Dra.  Monica Duran')) {
            $doctor = 1;
        }elseif ($doctor ==='Dr. Dante Alilleri') {

            $doctor = 2;
        }else{
            $doctor = null;
            $comments .= "\natendido por: \t" . $row["doctor"];

        }

        $consultation = new Consultation([
            "patient"=>$patient->id,
            "attended_by"=>$doctor,
            "sale"=>null,
            "comments"=>$comments,
            "created_at"=>date("Y-m-d H:i:s",strtotime($row["created_at"])),

        ]);

        $consultation->id =  model(ConsultationModel::class)->insert($consultation,true);
        $this->setGeneralBackground($row, $consultation->id);
        //$this->setLastPrescription($row,$patient, $consultation->id);
        $this->setPrescription($row,$patient, $consultation->id);
        $this->setVisualEvaluation($row,$consultation->id);

        return $consultation->id;



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

    private function setLegacyComments($row): string
    {
        $comments = "Información legada \n";
        $comments .= "fecha: \t" . $row["created_at"];
        foreach ($row as $key => $value) {
            $comments .= "\n\n" . $key . ": \t" . $value;
        }
        return $comments;
    }

    private function setGeneralBackground($row, $consultationId): void
    {

        if($row["Salud General"]===null)
        {
            return;
        }
        $data=[];
        switch ($row["Salud General"])
        {
            case "Sano":
                $data["healthy"] = true;
                $data["diabetes"] = false;
                $data["hypertensive"] = false;
                break;
            case "Diabetico": case "Diabetica":
                    $data["healthy"] = false;
                    $data["diabetes"] = true;
                    $data["hypertensive"] = false;
                    break;
            case "Hipertenso": case "Hipertensa":
                $data["healthy"] = false;
                $data["diabetes"] = false;
                $data["hypertensive"] = true;
                break;
            default:
                $data["healthy"] = false;
                $data["diabetes"] = false;
                $data["hypertensive"] = false;
                $data["observations"] = "Estado no reconocido: " . $row["Salud General"];
        }
        $gb = new GeneralBackground([
            ...$data,
            "consultation"=>$consultationId,
        ]);
        model(GeneralBackgroundModel::class)->insert($gb,true);

    }
    private function setLastPrescription($row,$patient,$consultationId): void
    {
        $lastYear = Time::parse($row["created_at"])->addYears(-1);
        $prescription = new Prescription([
            "patient"=>$patient->id,
            "consultation"=>null,
            "created_at"=>$lastYear->format("Y-m-d H:i:s"),
            ]);
        $details = [];
        $prescription->id = model(PrescriptionModel::class)->insert($prescription,true);
        $details[] = new PrescriptionDetail([
            "prescription"=>$prescription->id,
            "eye"=> "right",
            "source"=> "final",
            "sphere"=>	$row["GDESF3"],
            "cylinder"=>$row["GDCIL3"],
            "axis"      => 	$row["GDEJE3"],
            "addition" => $row["GAVD3"],
        ]);
        $details[] = new PrescriptionDetail([
            "prescription"=>$prescription->id,
            "eye"=> "left",
            "source"=> "final",
            "sphere" =>    $row["GIESF3"],
            "cylinder"	=>    $row["GICIL3"],
            "axis"	 =>    $row["GIEJE3"],
            "addition"	 =>   $row["GAVI3"],

        ] );

        model(PrescriptionDetailModel::class)->insertBatch($details,true);

    }
    private function setPrescription($row,$patient,$consultationId): void
    {
        $prescription = new Prescription([
            "patient"=>$patient->id,
            "consultation"=>$consultationId,
            "created_at"=>date("Y-m-d H:i:s",strtotime($row["created_at"])),
        ]);
        $details = [];
        $prescription->id = model(PrescriptionModel::class)->insert($prescription,true);
        $details[] = new PrescriptionDetail([
            "prescription"=>$prescription->id,
            "eye"=> "right",
            "source"=> "final",
            "sphere"=>$row["GDESF"],
            "cylinder"=> $row["GDCIL"],
            "axis" => $row["GDEJE"],
            "addition" => $row["GDADD"],

        ]);
        $details[] = new PrescriptionDetail([
            "prescription"=>$prescription->id,
            "eye"=> "left",
            "source"=> "final",
            "sphere"=>$row["GIESF"]	,
            "cylinder"=> $row["GICIL"]	,
            "axis" => $row["GIEJE"]	,
            "addition" => $row["GIADD"],
        ] );

        model(PrescriptionDetailModel::class)->insertBatch($details,true);

    }
    private function setVisualEvaluation($row,$consultationId): void
    {
        $data = [];
        $data["consultation"]           =   $consultationId;
        $data["interpupilar_distance"]  =   $this->getInterpupilarDistance($row["GDIP"]);
        $data["anterior_segment"]       =	$row["SEGMANTPOST"];
        $data["left_acuity_before"]     =	$row["AVI"];
        $data["right_acuity_before"]    =   $row["AVD"];
        $data["left_acuity_after"]      =	$row["GAVI"];
        $data["right_acuity_after"]     =	$row["GAVD"];
        $data["left_capacity"]          =	$row["CVI"]	;
        $data["right_capacity"]         =	$row["CVD"];

       $visualEvaluation = new VisualEvaluation($data);

       model(VisualEvaluationModel::class)->insert($visualEvaluation);

    }
    private function getInterpupilarDistance($dip): ?array
    {
        if(is_null($dip))return [null,null];

        $distance = [];

        if(str_contains($dip,"/") &&( strlen($dip)===5 || strlen($dip)===3))
        {
            $distance = explode("/", $dip);

        }else{
            if(strlen($dip)===4)
            {
                $distance = str_split($dip,2);
            }elseif(strlen($dip)<3 )
            {
                $distance =[$dip,null];
            }
        }


        return $distance;
    }

}
