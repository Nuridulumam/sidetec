<?php

namespace App\Models;

use CodeIgniter\Model;

class RuleKlasifikasiModel extends Model
{
    protected $table            = 'rule_klasifikasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'bradikardia_relatif',
        'demam_pagi',
        'demam_sore',
        'mual',
        'penurunan_kesadaran',
        'hasil',
    ];

    protected array $casts = [
        'id'                  => 'integer',
        'bradikardia_relatif' => 'float',
        'mual'                => 'integer',
        'penurunan_kesadaran' => 'integer',
    ];
}
