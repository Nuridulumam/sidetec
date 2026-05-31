<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'nama',
        'usia',
        'demam_pagi',
        'demam_sore',
        'sakit_kepala',
        'nyeri_otot',
        'mual',
        'muntah',
        'nyeri_perut',
        'diare',
        'penurunan_kesadaran',
        'penurunan_kesadaran_deskripsi',
        'bradikardia_relatif',
        'lemas',

        // legacy fields (tetap dibiarkan jika tabel masih memuatnya)
        'tanggal_lahir',
        'jenis_kelamin',
        'telepon',
        'alamat',
    ];

    protected array $casts = [
        'id'                        => 'integer',
        'usia'                      => 'integer',
        'sakit_kepala'              => 'integer',
        'nyeri_otot'                => 'integer',
        'mual'                      => 'integer',
        'muntah'                    => 'integer',
        'nyeri_perut'               => 'integer',
        'diare'                     => 'integer',
        'penurunan_kesadaran'       => 'integer',
        'bradikardia_relatif'       => 'integer',
        'lemas'                     => 'integer',
    ];
}

