<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSidetectTables extends Migration
{
    public function up(): void
    {
        // 1. Tabel users
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'username'         => ['type' => 'VARCHAR', 'constraint' => 191],
            'password_hash'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'full_name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'role'             => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'admin'],
            'is_active'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users');

        // 2. Tabel pasien (gabungan skema awal dan field screening terbaru)
        $this->forge->addField([
            'id'                            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama'                          => ['type' => 'VARCHAR', 'constraint' => 191],
            'usia'                          => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'null' => true],
            'demam_pagi'                    => ['type' => 'VARCHAR', 'constraint' => 191, 'null' => true],
            'demam_sore'                    => ['type' => 'VARCHAR', 'constraint' => 191, 'null' => true],
            'sakit_kepala'                  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'nyeri_otot'                    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'mual'                          => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'muntah'                        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'nyeri_perut'                   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'diare'                         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'penurunan_kesadaran'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'bradikardia_relatif'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'diagnosa'                      => ['type' => 'VARCHAR', 'constraint' => 191, 'null' => true],
            'lemas'                         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'tanggal_lahir'                 => ['type' => 'DATE', 'null' => true],
            'jenis_kelamin'                 => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'null' => true],
            'telepon'                       => ['type' => 'VARCHAR', 'constraint' => 32, 'null' => true],
            'alamat'                        => ['type' => 'TEXT', 'null' => true],
            'created_at'                    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pasien');

        // 3. Tabel rule_klasifikasi
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'usia'                => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'null'       => true,
            ],
            'demam_pagi'          => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => true,
            ],
            'demam_sore'          => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => true,
            ],
            'sakit_kepala'        => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'nyeri_otot'          => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'mual'                => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'muntah'              => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'nyeri_perut'         => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'diare'               => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'penurunan_kesadaran' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'bradikardia_relatif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'lemas'               => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'hasil'               => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => true,
            ],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rule_klasifikasi');

        // 4. Tabel laporan
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pasien_id'         => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'user_id'           => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'ringkasan'         => ['type' => 'TEXT', 'null' => true],
            'hasil_klasifikasi' => ['type' => 'VARCHAR', 'constraint' => 191, 'null' => true],
            'detail_json'       => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pasien_id', 'pasien', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('laporan');
    }

    public function down(): void
    {
        $this->forge->dropTable('laporan', true);
        $this->forge->dropTable('rule_klasifikasi', true);
        $this->forge->dropTable('pasien', true);
        $this->forge->dropTable('users', true);
    }
}
