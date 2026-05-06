<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasienScreeningFields extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('pasien', [
            'usia' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'nama',
            ],
            'demam_pagi' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,1',
                'null'       => true,
                'after'      => 'usia',
            ],
            'demam_sore' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,1',
                'null'       => true,
                'after'      => 'demam_pagi',
            ],
            'sakit_kepala' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'demam_sore',
            ],
            'nyeri_otot' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'sakit_kepala',
            ],
            'mual' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'nyeri_otot',
            ],
            'muntah' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'mual',
            ],
            'nyeri_perut' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'muntah',
            ],
            'diare' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'nyeri_perut',
            ],
            'penurunan_kesadaran' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'diare',
            ],
            'penurunan_kesadaran_deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'penurunan_kesadaran',
            ],
            'bradikardia_relatif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'penurunan_kesadaran_deskripsi',
            ],
            'lemas' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'bradikardia_relatif',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('pasien', [
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
        ]);
    }
}

