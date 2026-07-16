<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;

    protected $returnType = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id',
        'pasien_id',
        'nomor_rm',
        'nama',
        'tanggal_lahir',
        'nik',
        'usia',
        'jenis_kelamin',
        'telepon',
        'alamat',
    ];

    protected array $casts = [
        'nomor_rm'                  => 'integer',
        'usia'                      => 'integer',
    ];

    protected $beforeInsert = ['generateUuid', 'generatePasienId', 'generateNomorRm'];
    protected $beforeUpdate = [];
    protected $afterInsert  = [];
    protected $afterUpdate  = [];

    protected function generateUuid(array $data)
    {
        if (!isset($data['data'])) {
            return $data;
        }

        if (empty($data['data']['id'])) {
            $db = \Config\Database::connect();
            if ($db->DBDriver === 'SQLite3') {
                $data['data']['id'] = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    random_int(0, 0xffff), random_int(0, 0xffff),
                    random_int(0, 0xffff),
                    random_int(0, 0x0fff) | 0x4000,
                    random_int(0, 0x3fff) | 0x8000,
                    random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
                );
            } else {
                $row = $db->query("SELECT UUID() as uuid")->getRowArray();
                $data['data']['id'] = $row['uuid'];
            }
        }

        return $data;
    }

    protected function generatePasienId(array $data)
    {
        if (!isset($data['data'])) {
            return $data;
        }

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $db = \Config\Database::connect();
        
        do {
            $randomString = '';
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[random_int(0, strlen($characters) - 1)];
            }
            $pasienId = 'PST-' . $randomString;
            $exists = $db->table('pasien')->where('pasien_id', $pasienId)->countAllResults() > 0;
        } while ($exists);

        $data['data']['pasien_id'] = $pasienId;
        return $data;
    }

    protected function generateNomorRm(array $data)
    {
        if (!isset($data['data'])) {
            return $data;
        }

        if (empty($data['data']['nomor_rm'])) {
            $db = \Config\Database::connect();
            $row = $db->table('pasien')->selectMax('nomor_rm')->get()->getRowArray();
            $max = $row['nomor_rm'] ?? 0;
            $data['data']['nomor_rm'] = ($max > 0) ? $max + 1 : 100001;
        }

        return $data;
    }
}

