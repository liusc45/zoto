<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ItemPrice extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at', 'starts_at', 'ends_at'];


    /**
     * Verifica si el precio está activo en la fecha actual
     */
    public function isActive(): bool
    {
        $now = new \DateTime();
        $startsAt = $this->starts_at ? new \DateTime($this->starts_at) : null;
        $endsAt = $this->ends_at ? new \DateTime($this->ends_at) : null;

        return (!$startsAt || $startsAt <= $now) && (!$endsAt || $endsAt >= $now);
    }
}