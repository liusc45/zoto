<?php

namespace App\Models;

use App\Entities\Consultation;
use App\Models\Casts\DoctorCast;
use App\Models\Casts\PrescriptionCast;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ConsultationModel extends Model
{
    protected $table            = 'consultations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Consultation::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "patient",
        "sale",
        "attended_by",
        "comments",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id"=>"int",
        "patient"=>"int",
        "prescription"=>"prescriptionCast",
    ];
    protected array $castHandlers = [
        "prescriptionCast" => PrescriptionCast::class,
    ];

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
    protected $afterFind      = ['setAgo'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function setAgo($data)
    {
        foreach($data as $key => $consultations)
        {
            if(!is_array($consultations)) continue;
            foreach($consultations as $key => $consultation)
            {
                if(is_object($consultation) && isset($consultation->ago))
                {
                    $consultation->ago = Time::parse($consultation->ago)->humanize();
                }
            }

        }
        return $data;
    }
}
