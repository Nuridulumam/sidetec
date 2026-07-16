<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\GejalaModel;
use App\Database\Seeds\SidetectSeeder;

/**
 * @internal
 */
final class PasienModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate   = true;
    protected $namespace = 'App';
    protected $seed      = SidetectSeeder::class;

    public function testDetermineDiagnosisChild(): void
    {
        $model = new GejalaModel();

        // Data matching patient Siti Aminah (usia 12)
        $childData = [
            'usia'                => 12,
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

        $diagnosis = $model->determineDiagnosis($childData);
        $this->assertEquals('Suspect Typhoid Fever', $diagnosis);
    }

    public function testDetermineDiagnosisAdult(): void
    {
        $model = new GejalaModel();

        // Data matching patient Budi Santoso (usia 25)
        $adultData = [
            'usia'                => 25,
            'demam_pagi'          => 'Demam Ringan',
            'demam_sore'          => 'Demam Ringan',
            'sakit_kepala'        => 0,
            'nyeri_otot'          => 0,
            'mual'                => 0,
            'muntah'              => 0,
            'nyeri_perut'         => 0,
            'diare'               => 0,
            'penurunan_kesadaran' => 0,
            'bradikardia_relatif' => 0,
            'lemas'               => 0,
        ];

        $diagnosis = $model->determineDiagnosis($adultData);
        $this->assertEquals('Non Suspect Typhoid Fever', $diagnosis);
    }

    public function testAutoIncrementNomorRm(): void
    {
        $model = new \App\Models\PasienModel();

        // 1. Get the current maximum nomor_rm
        $db = \Config\Database::connect();
        $row = $db->table('pasien')->selectMax('nomor_rm')->get()->getRowArray();
        $initialMax = $row['nomor_rm'] ?? 0;

        // 2. Insert a new patient without providing nomor_rm
        $newPatientData = [
            'nama'          => 'Test Patient Auto Increment',
            'tanggal_lahir' => '1995-05-15',
            'nik'           => '9999999999999999',
            'usia'          => 30,
            'jenis_kelamin' => 'L',
        ];
        
        $insertedId = $model->insert($newPatientData);
        $this->assertNotEmpty($insertedId);

        // 3. Verify the inserted patient has the correct auto-incremented nomor_rm
        $insertedPatient = $model->find($insertedId);
        $expectedRm = ($initialMax > 0) ? $initialMax + 1 : 100001;
        $this->assertEquals($expectedRm, $insertedPatient['nomor_rm']);
    }
}
