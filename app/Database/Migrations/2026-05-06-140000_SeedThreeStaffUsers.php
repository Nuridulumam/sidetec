<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Menambah 3 pengguna contoh: superadmin, petugas poli, petugas sik.
 * Kata sandi default (dev): admin123 — samakan dengan akun admin lainnya di migrasi awal.
 */
class SeedThreeStaffUsers extends Migration
{
    public function up(): void
    {
        $now         = date('Y-m-d H:i:s');
        $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);

        $rows = [
            [
                'email'         => 'superadmin@sidetect.local',
                'password_hash' => $passwordHash,
                'full_name'     => 'Super Admin',
                'role'          => 'superadmin',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'email'         => 'petugas.poli@sidetect.local',
                'password_hash' => $passwordHash,
                'full_name'     => 'Petugas Poli',
                'role'          => 'petugas poli',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'email'         => 'petugas.sik@sidetect.local',
                'password_hash' => $passwordHash,
                'full_name'     => 'Petugas Sik',
                'role'          => 'petugas sik',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        $this->db->table('users')->insertBatch($rows);
    }

    public function down(): void
    {
        $this->db->table('users')->whereIn('email', [
            'superadmin@sidetect.local',
            'petugas.poli@sidetect.local',
            'petugas.sik@sidetect.local',
        ])->delete();
    }
}
