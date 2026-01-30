<?php

namespace App\Models;

use App\Entities\VisualEvaluation;
use CodeIgniter\Model;

class VisualEvaluationModel extends Model
{
    protected $table            = 'consultation_visual_evaluation';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = VisualEvaluation::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "consultation",
        "anterior_segment",
        "cover_test",
        "posterior_segment",
        "anomalies_image",
        "oftalmoscopy",
        "others",
        'left_acuity_before',
        'right_acuity_before',
        'left_acuity_after',
        'right_acuity_after',
        'left_capacity',
        'right_capacity',
        'acuity_ocular',
        'interpupilar_distance',
        'right_wafer_height',
        'left_wafer_height',
        "chromatic_vision",
        "ease_accommodation",
        "brock_string",
        "stereotest",
        "worth_bridge",
        "convergence_break",
        "convergence_recover",
        "amsler_grid",

        'comments',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id" =>"int",
        "consultation" =>"?int",
        "ease_accommodation" =>"?int",
        "convergence_break" =>"?int",
        "convergence_recover" => "?int",
        "interpupilar_distance" => "?json",
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = ['bin2string'];
    protected $beforeFind     = [];
    protected $afterFind      = ['bin2string'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    
    public function bin2string(array $data):array|null
    {
        if(is_null($data["data"])) return $data;
        
        $instanceOf = $data["data"] instanceof VisualEvaluation;
        $base64Image = $instanceOf ?
            $data["data"]->anomalies_image :
            (isset($data["data"]["anomalies_image"])?$data["data"]["anomalies_image"]:null);
        
        if(is_null($base64Image)) return $data;
        
        $imageData = base64_encode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        if($instanceOf)
        {
            $data["data"]->anomalies_image = $imageData;
        }else{
            $data["data"]["anomalies_image"] = $imageData;
        }

        if ($imageData === false) {
            return null; // Or handle the error as needed
        }
        // 2. Create a WebP image from the decoded data
        return $data;
//        $image = imagecreatefromstring($imageData);
//        dd($image);
//        if ($image === false) {
//            return null; // Or handle the error as needed
//        }
//
//        // 3. Create a temporary file to save the WebP image
//        $tempFile = tempnam(sys_get_temp_dir(), 'webp_');
//        if ($tempFile === false) {
//            return null; // Or handle the error as needed
//        }
//        $tempFile .= '.webp';
//
//        // 4. Save the WebP image to the temporary file
//        if (imagewebp($image, $tempFile, 80) === false) {
//            return null; // Or handle the error as needed
//        }
//
//        // 5.  Get the file contents
//        $fileContent = file_get_contents($tempFile);
//
//        // Clean up the temporary file
//        unlink($tempFile);
//
//
//        if ($fileContent === false) {
//            return null; // Or handle the error as needed
//        }
//
//        // 6. Create a blob from the file content
//        $blob = new Blob([$fileContent], ['type' => 'image/webp']);
//
//        // 7. Generate a blob URL
//        $blobUrl = URL::createObjectURL($blob);
//
//        // 8. Return the blob URL
//        return $blobUrl;
//
//
       
//        $data["data"]->anomalies_image = $data["data"]->anomalies_image?base64_encode($data["data"]->anomalies_image):null;
//
//        return $data;
        
    }
}
