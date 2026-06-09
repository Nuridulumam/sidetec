<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\PasienModel;
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
        $model = new PasienModel();

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
        $this->assertEquals('Typhoid Fever', $diagnosis);
    }

    public function testDetermineDiagnosisAdult(): void
    {
        $model = new PasienModel();

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
        $this->assertEquals('Non Typhoid Fever', $diagnosis);
    }
}
