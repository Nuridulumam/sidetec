<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPasienDemamToString extends Migration
{
    public function up(): void
    {
        $this->forge->modifyColumn('pasien', [
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
        ]);
    }

    public function down(): void
    {
        $this->forge->modifyColumn('pasien', [
            'demam_pagi' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,1',
                'null'       => true,
            ],
            'demam_sore' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,1',
                'null'       => true,
            ],
        ]);
    }
}
