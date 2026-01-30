<?php

namespace App\Models;

use App\Entities\Frame;
use CodeIgniter\Model;

class FrameModel extends Model
{
    protected $table            = 'frames';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Frame::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        "item",
        "model",
        "solar",
        "key_color",
        "color",
        "size",
        "style",
        "gender",
        "frame_material",
        "rod_material",
        "frame_color",
        "rod_color",
        "shape",
        "published",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id" => "integer",
        "item"=>"integer",
        "solar"=>"integer",
        "size"=>"?json",
        "frame_material"=>"?integer",
        "rod_material"=>"?integer",
        "frame_color"=>"?integer",
        "rod_color"=>"?integer",
        "published"=>"?boolean",
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
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
