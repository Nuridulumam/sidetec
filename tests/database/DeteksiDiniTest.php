<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\PasienModel;
use App\Models\GejalaModel;
use App\Models\LaporanModel;
use App\Database\Seeds\SidetectSeeder;

/**
 * @internal
 */
final class DeteksiDiniTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate   = true;
    protected $namespace = 'App';
    protected $seed      = SidetectSeeder::class;

    public function testPublicDeteksiDiniFlow(): void
    {
        $pasienModel = new PasienModel();
        $gejalaModel = new GejalaModel();
        $laporanModel = new LaporanModel();

        // 1. Prepare patient and symptom data (matching Suspect Typhoid Fever)
        $pasienData = [
            'id'            => 'test-uuid-pasien-123',
            'nama'          => 'Budi Test Deteksi Dini',
            'tanggal_lahir' => '2010-05-15', // Usia 16 (anak-anak)
            'nik'           => '1234567890123456',
            'usia'          => 16,
            'jenis_kelamin' => 'L',
            'telepon'       => '081234567890',
            'alamat'        => 'Jl. Test No. 123',
        ];

        $gejalaData = [
            'id'                  => 'test-uuid-gejala-123',
            'pasien_id'           => 'test-uuid-pasien-123',
            'demam_pagi'          => 'Demam Ringan',
            'demam_sore'          => 'Demam Sedang',
            'sakit_kepala'        => 1,
            'nyeri_otot'          => 0,
            'mual'                => 1,
            'muntah'              => 1,
            'nyeri_perut'         => 0,
            'diare'               => 1,
            'penurunan_kesadaran' => 0,
            'bradikardia_relatif' => 0,
            'lemas'               => 1,
        ];

        // 2. Perform insertions
        $db = \Config\Database::connect();
        $db->transStart();
        $pasienModel->insert($pasienData);
        $gejalaModel->insert($gejalaData);
        $db->transComplete();

        $this->assertTrue($db->transStatus());

        // 3. Verify patient exists
        $insertedPasien = $pasienModel->find('test-uuid-pasien-123');
        $this->assertNotNull($insertedPasien);
        $this->assertEquals('Budi Test Deteksi Dini', $insertedPasien['nama']);
        $this->assertEquals(16, $insertedPasien['usia']);
        $this->assertNotEmpty($insertedPasien['nomor_rm']);

        // 4. Verify symptoms exist and classification is correct
        $insertedGejala = $gejalaModel->find('test-uuid-gejala-123');
        $this->assertNotNull($insertedGejala);
        $this->assertEquals('test-uuid-pasien-123', $insertedGejala['pasien_id']);
        $this->assertEquals('Suspect Typhoid Fever', $insertedGejala['diagnosa']);

        // 5. Verify sync to laporan table works without created_by (null)
        $insertedLaporan = $laporanModel->where('gejala_id', 'test-uuid-gejala-123')->first();
        $this->assertNotNull($insertedLaporan);
        $this->assertEquals('test-uuid-pasien-123', $insertedLaporan['pasien_id']);
        $this->assertEquals('Suspect Typhoid Fever', $insertedLaporan['diagnosa']);
        $this->assertNull($insertedLaporan['created_by']);
    }
}
