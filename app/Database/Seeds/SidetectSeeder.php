<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SidetectSeeder extends Seeder
{
    public function run(): void
    {
        $now              = date('Y-m-d H:i:s');
        $passwordHash     = password_hash('admin123', PASSWORD_DEFAULT);
        $passwordHashMasy = password_hash('passMasyarakat121', PASSWORD_DEFAULT);

        $users = [
            [
                'username'      => 'achmad',
                'password_hash' => $passwordHash,
                'full_name'     => 'Achmad Fhuad, Amd.Kep',
                'role'          => 'perawat',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'username'      => 'ariyanto',
                'password_hash' => $passwordHash,
                'full_name'     => 'Ariyanto Adi kusumo, S.Tr. Kes',
                'role'          => 'petugas',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'username'      => 'syukri',
                'password_hash' => $passwordHash,
                'full_name'     => 'syukri bakhtiar, S.Tr.RMIK',
                'role'          => 'admin',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'username'      => 'masyarakat',
                'password_hash' => $passwordHashMasy,
                'full_name'     => 'Masyarakat Umum',
                'role'          => 'masyarakat',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        // Memasukkan data pengguna secara batch
        $this->db->table('users')->insertBatch($users);

        // Menjalankan seeder lainnya
        $this->call('RuleKlasifikasiSeeder');
        $this->call('PasienSeeder');
    }
}
