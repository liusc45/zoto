<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'invoices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'sale',
        'person_tax',
        'series',
        'folio',
        'subtotal',
        'discount',
        'tax_rate',
        'tax_amount',
        'total',
        'currency',
        'status',
        'uuid',
        'xml_path',
        'pdf_path',
        'issued_at',
        'canceled_at',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
