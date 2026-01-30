<?php

namespace App\Models;

use CodeIgniter\Model;

class RangeIntervalModel extends Model
{
    protected $table            = 'range_intervals';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'range',
        'min_value',
        'max_value',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'range' => 'required|is_natural_no_zero',
        'min_value' => 'required|decimal',
        'max_value' => 'required|decimal',
    ];

    protected $beforeInsert = ['validateMaxIntervals', 'validateMinMax'];
    protected $beforeUpdate = ['validateMinMax'];

    protected function validateMinMax(array $data)
    {
        $min = (float)($data['data']['min_value'] ?? 0);
        $max = (float)($data['data']['max_value'] ?? 0);
        if ($min > $max) {
            $this->errors['min_value'] = 'El mínimo no puede ser mayor al máximo';
            $this->skipValidation = false;
            throw new \RuntimeException('El mínimo no puede ser mayor al máximo');
        }
        return $data;
    }

    protected function validateMaxIntervals(array $data)
    {
        $rangeId = $data['data']['range'] ?? null;
        if (!$rangeId) {
            return $data;
        }
        $count = $this->where('range', $rangeId)->countAllResults();
        if ($count >= 2) {
            $this->errors['range'] = 'Un rango puede tener máximo 2 intervalos';
            throw new \RuntimeException('Un rango puede tener máximo 2 intervalos');
        }
        return $data;
    }
}
