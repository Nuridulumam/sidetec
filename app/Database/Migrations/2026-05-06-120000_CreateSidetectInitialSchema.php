<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Skema awal Sidetect: users, pasien, rule_klasifikasi, laporan.
 *
 * Buat database MySQL terlebih dahulu:
 *   CREATE DATABASE sidetect_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
 *
 * Lalu jalankan: php spark migrate
 */
class CreateSidetectInitialSchema extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'email'            => ['type' => 'VARCHAR', 'constraint' => 191],
            'password_hash'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'full_name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'role'             => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'admin'],
            'is_active'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');

        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama'             => ['type' => 'VARCHAR', 'constraint' => 191],
            'tanggal_lahir'    => ['type' => 'DATE', 'null' => true],
            'jenis_kelamin'    => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'null' => true],
            'telepon'          => ['type' => 'VARCHAR', 'constraint' => 32, 'null' => true],
            'alamat'           => ['type' => 'TEXT', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pasien');

        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'bradikardia_relatif' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,2',
                'null'       => true,
            ],
            'demam_pagi' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => true,
            ],
            'demam_sore' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => true,
            ],
            'mual' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'penurunan_kesadaran' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'hasil' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
                'null'       => true,
            ],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rule_klasifikasi');

        $this->forge->addField([
            'id'                   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pasien_id'            => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'user_id'              => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'ringkasan'            => ['type' => 'TEXT', 'null' => true],
            'hasil_klasifikasi'    => ['type' => 'VARCHAR', 'constraint' => 191, 'null' => true],
            'detail_json'          => ['type' => 'TEXT', 'null' => true],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pasien_id', 'pasien', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('laporan');

        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insert([
            'email'           => 'admin@sidetect.local',
            'password_hash'   => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name'       => 'Administrator',
            'role'            => 'admin',
            'is_active'       => 1,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('laporan', true);
        $this->forge->dropTable('rule_klasifikasi', true);
        $this->forge->dropTable('pasien', true);
        $this->forge->dropTable('users', true);
    }
}
