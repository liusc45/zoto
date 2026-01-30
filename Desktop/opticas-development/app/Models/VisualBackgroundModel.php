<?php

namespace App\Models;

use App\Entities\VisualBackground;
use CodeIgniter\Model;

class VisualBackgroundModel extends Model
{
    protected $table            = 'consultation_visual_background';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = VisualBackground::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "consultation",

        "glasses",
        "last_check_date",
        "fatigue",
        "burning",
        "itching",
        "photophobia",
        "redness",
        "blurry",
        "headache",
        "secretion",
        "other_conditions",
        "comments",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [

        "consultation"    => "int",
        "glasses"    => "?bool",
        "fatigue" => "?bool",
        "burning" => "?bool" ,
        "itching" => "?bool",
        "photophobia" => "?bool",
        "redness" => "?bool",
        "blurry" => "?csv",
        "headache" => "?csv",
        
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
    protected $beforeInsert   = ['transformBooleanFields'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function transformBooleanFields(array $data):array
    {
        $fields = ["fatigue", "burning", "itching", "photophobia", "redness"];
        foreach ($fields as $key => $field)
        {
            $data["data"][$field] = isset($data["data"][$field]);

        }
        return $data;
    }

}
