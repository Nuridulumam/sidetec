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
        'sakit_kepala',
        'nyeri_otot',
        'mual',
        'muntah',
        'nyeri_perut',
        'diare',
        'penurunan_kesadaran',
        'lemas',
        'hasil',
    ];

    protected array $casts = [
        'id'                  => 'integer',
        'bradikardia_relatif' => 'integer',
        'sakit_kepala'        => 'integer',
        'nyeri_otot'          => 'integer',
        'mual'                => 'integer',
        'muntah'              => 'integer',
        'nyeri_perut'         => 'integer',
        'diare'               => 'integer',
        'penurunan_kesadaran' => 'integer',
        'lemas'               => 'integer',
    ];
}
