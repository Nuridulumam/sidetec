<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'nomor_rm'                      => 100001,
                'nik'                           => '1234567890123456',
                'nama'                          => 'Budi Santoso',
                'usia'                          => 25,
                'demam_pagi'                    => 'Demam Ringan',
                'demam_sore'                    => 'Demam Ringan',
                'sakit_kepala'                  => 0,
                'nyeri_otot'                    => 0,
                'mual'                          => 0,
                'muntah'                        => 0,
                'nyeri_perut'                   => 0,
                'diare'                         => 0,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 0,
                'lemas'                         => 0,
                'tanggal_lahir'                 => '2001-04-12',
                'jenis_kelamin'                 => 'L',
                'telepon'                       => '081234567890',
                'alamat'                        => 'Jl. Merdeka No. 10, Jakarta',
            ],
            [
                'nomor_rm'                      => 100002,
                'nik'                           => '2345678901234567',
                'nama'                          => 'Siti Aminah',
                'usia'                          => 12,
                'demam_pagi'                    => 'Demam Ringan',
                'demam_sore'                    => 'Demam Sedang',
                'sakit_kepala'                  => 1,
                'nyeri_otot'                    => 0,
                'mual'                          => 1,
                'muntah'                        => 1,
                'nyeri_perut'                   => 0,
                'diare'                         => 1,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 0,
                'lemas'                         => 1,
                'tanggal_lahir'                 => '2014-08-22',
                'jenis_kelamin'                 => 'P',
                'telepon'                       => '082345678901',
                'alamat'                        => 'Jl. Mawar No. 4, Surabaya',
            ],
            [
                'nomor_rm'                      => 100003,
                'nik'                           => '3456789012345678',
                'nama'                          => 'Andi Wijaya',
                'usia'                          => 34,
                'demam_pagi'                    => 'Tidak Demam',
                'demam_sore'                    => 'Demam Ringan',
                'sakit_kepala'                  => 0,
                'nyeri_otot'                    => 1,
                'mual'                          => 0,
                'muntah'                        => 0,
                'nyeri_perut'                   => 0,
                'diare'                         => 0,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 0,
                'lemas'                         => 0,
                'tanggal_lahir'                 => '1992-11-05',
                'jenis_kelamin'                 => 'L',
                'telepon'                       => '083456789012',
                'alamat'                        => 'Jl. Melati No. 15, Bandung',
            ],
            [
                'nomor_rm'                      => 100004,
                'nik'                           => '4567890123456789',
                'nama'                          => 'Dewi Lestari',
                'usia'                          => 18,
                'demam_pagi'                    => 'Demam Sedang',
                'demam_sore'                    => 'Demam Sedang',
                'sakit_kepala'                  => 1,
                'nyeri_otot'                    => 1,
                'mual'                          => 0,
                'muntah'                        => 0,
                'nyeri_perut'                   => 0,
                'diare'                         => 1,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 1,
                'lemas'                         => 1,
                'tanggal_lahir'                 => '2008-02-14',
                'jenis_kelamin'                 => 'P',
                'telepon'                       => '084567890123',
                'alamat'                        => 'Jl. Kenanga No. 8, Yogyakarta',
            ],
            [
                'nomor_rm'                      => 100005,
                'nik'                           => '5678901234567890',
                'nama'                          => 'Eko Prasetyo',
                'usia'                          => 45,
                'demam_pagi'                    => 'Demam Ringan',
                'demam_sore'                    => 'Demam Tinggi',
                'sakit_kepala'                  => 0,
                'nyeri_otot'                    => 1,
                'mual'                          => 1,
                'muntah'                        => 0,
                'nyeri_perut'                   => 1,
                'diare'                         => 0,
                'penurunan_kesadaran'           => 1,
                'bradikardia_relatif'           => 1,
                'lemas'                         => 0,
                'tanggal_lahir'                 => '1981-06-30',
                'jenis_kelamin'                 => 'L',
                'telepon'                       => '085678901234',
                'alamat'                        => 'Jl. Dahlia No. 22, Semarang',
            ],
            [
                'nomor_rm'                      => 100006,
                'nik'                           => '6789012345678901',
                'nama'                          => 'Farida Utami',
                'usia'                          => 9,
                'demam_pagi'                    => 'Demam Sedang',
                'demam_sore'                    => 'Demam Sedang',
                'sakit_kepala'                  => 1,
                'nyeri_otot'                    => 0,
                'mual'                          => 0,
                'muntah'                        => 1,
                'nyeri_perut'                   => 1,
                'diare'                         => 1,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 0,
                'lemas'                         => 1,
                'tanggal_lahir'                 => '2017-09-15',
                'jenis_kelamin'                 => 'P',
                'telepon'                       => '086789012345',
                'alamat'                        => 'Jl. Kamboja No. 3, Malang',
            ],
            [
                'nomor_rm'                      => 100007,
                'nik'                           => '7890123456789012',
                'nama'                          => 'Guntur Wibowo',
                'usia'                          => 50,
                'demam_pagi'                    => 'Tidak Demam',
                'demam_sore'                    => 'Tidak Demam',
                'sakit_kepala'                  => 0,
                'nyeri_otot'                    => 0,
                'mual'                          => 0,
                'muntah'                        => 0,
                'nyeri_perut'                   => 0,
                'diare'                         => 0,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 0,
                'lemas'                         => 0,
                'tanggal_lahir'                 => '1976-03-10',
                'jenis_kelamin'                 => 'L',
                'telepon'                       => '087890123456',
                'alamat'                        => 'Jl. Anggrek No. 12, Solo',
            ],
            [
                'nomor_rm'                      => 100008,
                'nik'                           => '8901234567890123',
                'nama'                          => 'Hani Handayani',
                'usia'                          => 28,
                'demam_pagi'                    => 'Demam Sedang',
                'demam_sore'                    => 'Demam Tinggi',
                'sakit_kepala'                  => 1,
                'nyeri_otot'                    => 1,
                'mual'                          => 1,
                'muntah'                        => 0,
                'nyeri_perut'                   => 1,
                'diare'                         => 0,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 0,
                'lemas'                         => 1,
                'tanggal_lahir'                 => '1998-07-19',
                'jenis_kelamin'                 => 'P',
                'telepon'                       => '088901234567',
                'alamat'                        => 'Jl. Flamboyan No. 7, Denpasar',
            ],
            [
                'nomor_rm'                      => 100009,
                'nik'                           => '9012345678901234',
                'nama'                          => 'Irfan Hakim',
                'usia'                          => 16,
                'demam_pagi'                    => 'Demam Tinggi',
                'demam_sore'                    => 'Demam Tinggi',
                'sakit_kepala'                  => 1,
                'nyeri_otot'                    => 1,
                'mual'                          => 1,
                'muntah'                        => 1,
                'nyeri_perut'                   => 0,
                'diare'                         => 1,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 1,
                'lemas'                         => 1,
                'tanggal_lahir'                 => '2010-10-01',
                'jenis_kelamin'                 => 'L',
                'telepon'                       => '089012345678',
                'alamat'                        => 'Jl. Sakura No. 19, Medan',
            ],
            [
                'nomor_rm'                      => 100010,
                'nik'                           => '0123456789012345',
                'nama'                          => 'Julia Perez',
                'usia'                          => 22,
                'demam_pagi'                    => 'Demam Ringan',
                'demam_sore'                    => 'Demam Sedang',
                'sakit_kepala'                  => 1,
                'nyeri_otot'                    => 0,
                'mual'                          => 1,
                'muntah'                        => 0,
                'nyeri_perut'                   => 1,
                'diare'                         => 0,
                'penurunan_kesadaran'           => 0,
                'bradikardia_relatif'           => 0,
                'lemas'                         => 1,
                'tanggal_lahir'                 => '2004-05-12',
                'jenis_kelamin'                 => 'P',
                'telepon'                       => '090123456789',
                'alamat'                        => 'Jl. Tulip No. 11, Palembang',
            ],
            [
                'nomor_rm'                      => 100011,
                'nik'                           => '0987654321098765',
                'nama'                          => 'Kurniawan Dwi',
                'usia'                          => 60,
                'demam_pagi'                    => 'Demam Sedang',
                'demam_sore'                    => 'Demam Tinggi',
                'sakit_kepala'                  => 1,
                'nyeri_otot'                    => 1,
                'mual'                          => 0,
                'muntah'                        => 1,
                'nyeri_perut'                   => 1,
                'diare'                         => 1,
                'penurunan_kesadaran'           => 1,
                'bradikardia_relatif'           => 0,
                'lemas'                         => 1,
                'tanggal_lahir'                 => '1966-12-25',
                'jenis_kelamin'                 => 'L',
                'telepon'                       => '091234567890',
                'alamat'                        => 'Jl. Teratai No. 14, Makassar',
            ],
        ];

        $pasienModel = new \App\Models\PasienModel();
        $gejalaModel = new \App\Models\GejalaModel();

        $start = strtotime('-3 months');
        $end = strtotime('-1 month');
        $numPatients = count($data);
        $step = ($numPatients > 1) ? ($end - $start) / ($numPatients - 1) : 0;

        foreach ($data as $idx => $row) {
            $time = $start + ($idx * $step);
            $timeStr = date('Y-m-d H:i:s', $time);

            // 1. Insert patient master data
            $pasienData = [
                'nomor_rm'      => $row['nomor_rm'],
                'nik'           => $row['nik'],
                'nama'          => $row['nama'],
                'usia'          => $row['usia'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'telepon'       => $row['telepon'],
                'alamat'        => $row['alamat'],
                'created_at'    => $timeStr,
                'updated_at'    => $timeStr,
            ];
            
            // This generates id and pasien_id through beforeInsert hooks
            $pasienId = $pasienModel->insert($pasienData);
            
            if ($pasienId) {
                // Instantly update patient timestamps to the past date
                $db = \Config\Database::connect();
                $db->table('pasien')->where('id', $pasienId)->update([
                    'created_at' => $timeStr,
                    'updated_at' => $timeStr,
                ]);

                // 2. Insert symptoms data linked to patient
                $gejalaData = [
                    'pasien_id'           => $pasienId,
                    'demam_pagi'          => $row['demam_pagi'],
                    'demam_sore'          => $row['demam_sore'],
                    'sakit_kepala'        => $row['sakit_kepala'],
                    'nyeri_otot'          => $row['nyeri_otot'],
                    'mual'                => $row['mual'],
                    'muntah'              => $row['muntah'],
                    'nyeri_perut'         => $row['nyeri_perut'],
                    'diare'               => $row['diare'],
                    'penurunan_kesadaran' => $row['penurunan_kesadaran'],
                    'bradikardia_relatif' => $row['bradikardia_relatif'],
                    'lemas'               => $row['lemas'],
                ];
                
                // This triggers calculation and report sync automatically
                $gejalaId = $gejalaModel->insert($gejalaData);
                if ($gejalaId) {
                    // Instantly update gejala and laporan timestamps to the past date
                    $db->table('gejala')->where('id', $gejalaId)->update([
                        'created_at' => $timeStr,
                        'updated_at' => $timeStr,
                    ]);
                    $db->table('laporan')->where('gejala_id', $gejalaId)->update([
                        'created_at' => $timeStr,
                        'updated_at' => $timeStr,
                    ]);
                }
            }
        }
    }
}
