<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;

    protected $returnType = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id',
        'pasien_id',
        'nama',
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
        'bradikardia_relatif',
        'diagnosa',
        'lemas',

        // legacy fields (tetap dibiarkan jika tabel masih memuatnya)
        'tanggal_lahir',
        'jenis_kelamin',
        'telepon',
        'alamat',
    ];

    protected array $casts = [
        'usia'                      => 'integer',
        'sakit_kepala'              => 'integer',
        'nyeri_otot'                => 'integer',
        'mual'                      => 'integer',
        'muntah'                    => 'integer',
        'nyeri_perut'               => 'integer',
        'diare'                     => 'integer',
        'penurunan_kesadaran'       => 'integer',
        'bradikardia_relatif'       => 'integer',
        'lemas'                     => 'integer',
    ];

    protected $beforeInsert = ['generateUuid', 'generatePasienId', 'calculateDiagnosis'];
    protected $beforeUpdate = ['calculateDiagnosis'];
    protected $afterInsert  = ['syncLaporanInsert'];
    protected $afterUpdate  = ['syncLaporanUpdate'];

    protected function generateUuid(array $data)
    {
        if (!isset($data['data'])) {
            return $data;
        }

        if (empty($data['data']['id'])) {
            $db = \Config\Database::connect();
            if ($db->DBDriver === 'SQLite3') {
                $data['data']['id'] = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    random_int(0, 0xffff), random_int(0, 0xffff),
                    random_int(0, 0xffff),
                    random_int(0, 0x0fff) | 0x4000,
                    random_int(0, 0x3fff) | 0x8000,
                    random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
                );
            } else {
                $row = $db->query("SELECT UUID() as uuid")->getRowArray();
                $data['data']['id'] = $row['uuid'];
            }
        }

        return $data;
    }

    protected function generatePasienId(array $data)
    {
        if (!isset($data['data'])) {
            return $data;
        }

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $db = \Config\Database::connect();
        
        do {
            $randomString = '';
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[random_int(0, strlen($characters) - 1)];
            }
            $pasienId = 'PST-' . $randomString;
            $exists = $db->table('pasien')->where('pasien_id', $pasienId)->countAllResults() > 0;
        } while ($exists);

        $data['data']['pasien_id'] = $pasienId;
        return $data;
    }

    protected function syncLaporanInsert(array $data)
    {
        $pasienId = $data['id'];
        $diagnosa = $data['data']['diagnosa'] ?? 'Tidak terklasifikasi';

        $laporanModel = new \App\Models\LaporanModel();
        $laporanModel->insert([
            'pasien_id'  => $pasienId,
            'diagnosa'   => $diagnosa,
            'created_by' => session()->get('admin_id') ?? null,
        ]);

        return $data;
    }

    protected function syncLaporanUpdate(array $data)
    {
        if (empty($data['id'])) {
            return $data;
        }

        $ids = is_array($data['id']) ? $data['id'] : [$data['id']];
        $laporanModel = new \App\Models\LaporanModel();

        foreach ($ids as $pasienId) {
            $pasien = $this->find($pasienId);
            if ($pasien) {
                $laporanModel->where('pasien_id', $pasienId)
                             ->set(['diagnosa' => $pasien['diagnosa']])
                             ->update();
            }
        }

        return $data;
    }

    protected function calculateDiagnosis(array $data)
    {
        if (!isset($data['data'])) {
            return $data;
        }

        $symptomsData = $data['data'];

        // If it's an update, merge with existing data to ensure all fields are present for classification
        if (isset($data['id'])) {
            $id = is_array($data['id']) ? ($data['id'][0] ?? null) : $data['id'];
            if ($id) {
                $existing = $this->find($id);
                if ($existing) {
                    $symptomsData = array_merge($existing, $data['data']);
                }
            }
        }

        $data['data']['diagnosa'] = $this->determineDiagnosis($symptomsData);
        return $data;
    }

    public function determineDiagnosis(array $patientData): string
    {
        $db = \Config\Database::connect();
        $rawRules = $db->table('rule_klasifikasi')->get()->getResultArray();

        // Preprocess training dataset: map usia to usia_grup
        $dataset = [];
        foreach ($rawRules as $row) {
            $row['usia_grup'] = ((int)$row['usia'] <= 17) ? 'anak' : 'dewasa';
            $dataset[] = $row;
        }

        $features = [
            'usia_grup', 'demam_pagi', 'demam_sore', 'sakit_kepala', 'nyeri_otot',
            'mual', 'muntah', 'nyeri_perut', 'diare', 'penurunan_kesadaran',
            'bradikardia_relatif', 'lemas'
        ];

        // Build C4.5 Decision Tree
        $tree = $this->buildC45Tree($dataset, $features);

        // Preprocess patient data for classification
        $processedPatient = [
            'usia_grup'           => (isset($patientData['usia']) && (int)$patientData['usia'] <= 17) ? 'anak' : 'dewasa',
            'demam_pagi'          => $patientData['demam_pagi'] ?? '',
            'demam_sore'          => $patientData['demam_sore'] ?? '',
            'sakit_kepala'        => (int)($patientData['sakit_kepala'] ?? 0),
            'nyeri_otot'          => (int)($patientData['nyeri_otot'] ?? 0),
            'mual'                => (int)($patientData['mual'] ?? 0),
            'muntah'              => (int)($patientData['muntah'] ?? 0),
            'nyeri_perut'         => (int)($patientData['nyeri_perut'] ?? 0),
            'diare'               => (int)($patientData['diare'] ?? 0),
            'penurunan_kesadaran' => (int)($patientData['penurunan_kesadaran'] ?? 0),
            'bradikardia_relatif' => (int)($patientData['bradikardia_relatif'] ?? 0),
            'lemas'               => (int)($patientData['lemas'] ?? 0),
        ];

        return $this->classifyC45Node($tree, $processedPatient);
    }

    private function getEntropy(array $dataset): float
    {
        $total = count($dataset);
        if ($total === 0) {
            return 0.0;
        }

        $counts = [];
        foreach ($dataset as $row) {
            $class = $row['hasil'];
            $counts[$class] = ($counts[$class] ?? 0) + 1;
        }

        $entropy = 0.0;
        foreach ($counts as $class => $count) {
            $p = $count / $total;
            $entropy -= $p * log($p, 2);
        }

        return $entropy;
    }

    private function getMajorityClass(array $dataset): string
    {
        $counts = [];
        foreach ($dataset as $row) {
            $class = $row['hasil'];
            $counts[$class] = ($counts[$class] ?? 0) + 1;
        }
        arsort($counts);
        return count($counts) > 0 ? (string)key($counts) : 'Tidak terklasifikasi';
    }

    private function buildC45Tree(array $dataset, array $features)
    {
        if (count($dataset) === 0) {
            return 'Tidak terklasifikasi';
        }

        // Rule 1: If all instances belong to the same class
        $classes = array_unique(array_column($dataset, 'hasil'));
        if (count($classes) === 1) {
            return $classes[0];
        }

        // Rule 2: If features list is empty
        if (count($features) === 0) {
            return $this->getMajorityClass($dataset);
        }

        $totalEntropy = $this->getEntropy($dataset);
        $totalCount = count($dataset);

        $bestFeature = null;
        $bestGainRatio = -1.0;
        $bestSubsets = [];

        foreach ($features as $feature) {
            // Split dataset by feature values
            $subsets = [];
            foreach ($dataset as $row) {
                $val = $row[$feature] ?? 'NULL';
                $subsets[$val][] = $row;
            }

            // Calculate entropy of split
            $splitEntropy = 0.0;
            $splitInfo = 0.0;
            foreach ($subsets as $val => $subset) {
                $p = count($subset) / $totalCount;
                $splitEntropy += $p * $this->getEntropy($subset);
                $splitInfo -= $p * log($p, 2);
            }

            $gain = $totalEntropy - $splitEntropy;
            $gainRatio = ($splitInfo > 0.0) ? ($gain / $splitInfo) : 0.0;

            if ($gainRatio > $bestGainRatio) {
                $bestGainRatio = $gainRatio;
                $bestFeature = $feature;
                $bestSubsets = $subsets;
            }
        }

        if ($bestFeature === null || $bestGainRatio <= 0.0) {
            return $this->getMajorityClass($dataset);
        }

        // Build subtree
        $node = [
            'feature' => $bestFeature,
            'branches' => [],
            'default' => $this->getMajorityClass($dataset)
        ];

        $remainingFeatures = array_diff($features, [$bestFeature]);

        foreach ($bestSubsets as $val => $subset) {
            $node['branches'][$val] = $this->buildC45Tree($subset, $remainingFeatures);
        }

        return $node;
    }

    private function classifyC45Node($node, array $patientData): string
    {
        if (!is_array($node)) {
            return $node;
        }

        $feature = $node['feature'];
        $val = $patientData[$feature] ?? 'NULL';

        if (isset($node['branches'][$val])) {
            return $this->classifyC45Node($node['branches'][$val], $patientData);
        }

        return $node['default'];
    }
}

