<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SidetectSeeder extends Seeder
{
    public function run(): void
    {
        $now          = date('Y-m-d H:i:s');
        $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);

        $users = [
            [
                'email'         => 'admin@sidetect.local',
                'password_hash' => $passwordHash,
                'full_name'     => 'Administrator',
                'role'          => 'admin',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
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

        // Memasukkan data pengguna secara batch
        $this->db->table('users')->insertBatch($users);

        // Menjalankan seeder lainnya
        $this->call('PasienSeeder');
        $this->call('RuleKlasifikasiSeeder');
    }
}
