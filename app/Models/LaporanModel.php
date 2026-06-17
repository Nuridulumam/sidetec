<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table            = 'laporan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id',
        'pasien_id',
        'diagnosa',
        'created_by',
    ];

    protected $beforeInsert = ['generateUuid'];

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
}
