<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
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
        'penurunan_kesadaran_deskripsi',
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
        'id'                        => 'integer',
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

    protected $beforeInsert = ['calculateDiagnosis'];
    protected $beforeUpdate = ['calculateDiagnosis'];

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
        $builder = $db->table('rule_klasifikasi');

        // symptoms must match exactly or be null (wildcard)
        $fieldsWithoutAge = [
            'demam_pagi', 'demam_sore', 'sakit_kepala', 'nyeri_otot',
            'mual', 'muntah', 'nyeri_perut', 'diare', 'penurunan_kesadaran',
            'bradikardia_relatif', 'lemas'
        ];

        foreach ($fieldsWithoutAge as $field) {
            $val = isset($patientData[$field]) ? $patientData[$field] : null;

            if ($val === null || $val === '') {
                $builder->where("$field IS NULL");
            } else {
                $builder->groupStart()
                    ->where("$field IS NULL")
                    ->orWhere($field, $val)
                    ->groupEnd();
            }
        }

        // Age match logic: try exact match first, then age group (Child <= 17 vs Adult >= 18), then ignore
        $pUsia = isset($patientData['usia']) ? (int) $patientData['usia'] : null;

        if ($pUsia !== null) {
            $isChild = $pUsia <= 17;

            $builder->groupStart()
                ->where('usia IS NULL')
                ->orWhere('usia', $pUsia);
            
            if ($isChild) {
                $builder->orWhere('usia <=', 17);
            } else {
                $builder->orWhere('usia >=', 18);
            }
            $builder->groupEnd();

            $ageScoreExpr = "CASE 
                WHEN usia = $pUsia THEN 3
                WHEN (" . ($isChild ? "usia <= 17" : "usia >= 18") . ") THEN 2
                ELSE 1 
            END";
        } else {
            $builder->where('usia IS NULL');
            $ageScoreExpr = "1";
        }

        // Specificity scoring based on the number of non-null symptom fields in the rule
        $symptomScoreExpr = "";
        foreach ($fieldsWithoutAge as $index => $field) {
            if ($index > 0) {
                $symptomScoreExpr .= " + ";
            }
            $symptomScoreExpr .= "(CASE WHEN $field IS NOT NULL THEN 1 ELSE 0 END)";
        }

        $builder->select("*, ($ageScoreExpr) AS age_score, ($symptomScoreExpr) AS symptom_score");
        $builder->orderBy("symptom_score", "DESC");
        $builder->orderBy("age_score", "DESC");
        $builder->orderBy("id", "ASC");
        
        $rule = $builder->get()->getRowArray();

        if ($rule) {
            return $rule['hasil'];
        }

        return 'Tidak terklasifikasi';
    }
}

