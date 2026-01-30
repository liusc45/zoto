<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Promotion extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at', 'starts_at', 'ends_at'];
    protected $casts   = [
        'id' => 'integer',
        'active' => 'boolean',
        'priority' => 'integer',
        'combinable' => 'boolean',
        'audience' => 'json',
        'constraints_json' => 'json',
        'rule_json' => 'json',
    ];

    /**
     * Check if the promotion is currently active based on date range and active flag
     */
    public function isActive(): bool
    {
        if (!$this->active) {
            return false;
        }
        $now = new \DateTimeImmutable('now');
        $startsAt = new \DateTimeImmutable($this->starts_at);
        if ($now < $startsAt) {
            return false;
        }
        if (!empty($this->ends_at)) {
            $endsAt = new \DateTimeImmutable($this->ends_at);
            if ($now > $endsAt) {
                return false;
            }
        }
        return true;
    }
}