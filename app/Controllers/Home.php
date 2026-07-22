<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        helper('url');

        return view('home');
    }

    public function deteksiDini()
    {
        helper(['url', 'form']);
        return view('deteksi_dini');
    }

    public function prosesDeteksiDini()
    {
        helper(['url', 'form']);

        $validationRules = [
            // Patient fields
            'nama'          => 'required|min_length[3]|max_length[191]',
            'tanggal_lahir' => 'required|valid_date[Y-m-d]',
            'nik'           => 'required|numeric|exact_length[16]',
            'usia'          => 'required|is_natural_no_zero|less_than_equal_to[150]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'telepon'       => 'permit_empty|max_length[32]',
            'alamat'        => 'permit_empty',

            // Symptom fields
            'demam_pagi'          => config('DemamKlasifikasi')->validationRule(),
            'demam_sore'          => config('DemamKlasifikasi')->validationRule(),
            'sakit_kepala'        => 'required|in_list[0,1]',
            'nyeri_otot'          => 'required|in_list[0,1]',
            'mual'                => 'required|in_list[0,1]',
            'muntah'              => 'required|in_list[0,1]',
            'nyeri_perut'         => 'required|in_list[0,1]',
            'diare'               => 'required|in_list[0,1]',
            'penurunan_kesadaran' => 'required|in_list[0,1]',
            'bradikardia_relatif' => 'required|in_list[0,1]',
            'lemas'               => 'required|in_list[0,1]',
        ];

        $validationMessages = [
            'nik' => [
                'exact_length' => 'NIK harus 16 digit.',
                'numeric' => 'NIK hanya boleh berupa angka.',
                'required' => 'NIK wajib diisi.'
            ],
            'nama' => [
                'required' => 'Nama lengkap wajib diisi.',
                'min_length' => 'Nama lengkap minimal 3 karakter.',
            ],
            'tanggal_lahir' => [
                'required' => 'Tanggal lahir wajib diisi.',
            ],
            'usia' => [
                'required' => 'Usia wajib diisi (otomatis terhitung dari tanggal lahir).',
                'is_natural_no_zero' => 'Usia harus berupa angka positif.',
            ],
            'jenis_kelamin' => [
                'required' => 'Jenis kelamin wajib diisi.',
            ],
        ];

        if (! $this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $pasienModel = new \App\Models\PasienModel();
        $gejalaModel = new \App\Models\GejalaModel();

        // Generate UUID for patient and symptoms to ensure link integrity
        if ($db->DBDriver === 'SQLite3') {
            $pasienId = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                random_int(0, 0xffff), random_int(0, 0xffff),
                random_int(0, 0xffff),
                random_int(0, 0x0fff) | 0x4000,
                random_int(0, 0x3fff) | 0x8000,
                random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
            );
            $gejalaId = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                random_int(0, 0xffff), random_int(0, 0xffff),
                random_int(0, 0xffff),
                random_int(0, 0x0fff) | 0x4000,
                random_int(0, 0x3fff) | 0x8000,
                random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
            );
        } else {
            $rowPasien = $db->query("SELECT UUID() as uuid")->getRowArray();
            $pasienId = $rowPasien['uuid'];
            $rowGejala = $db->query("SELECT UUID() as uuid")->getRowArray();
            $gejalaId = $rowGejala['uuid'];
        }

        $pasienData = [
            'id'            => $pasienId,
            'nama'          => (string) $this->request->getPost('nama'),
            'tanggal_lahir' => (string) $this->request->getPost('tanggal_lahir'),
            'nik'           => (string) $this->request->getPost('nik'),
            'usia'          => (int) $this->request->getPost('usia'),
            'jenis_kelamin' => (string) $this->request->getPost('jenis_kelamin'),
            'telepon'       => (string) $this->request->getPost('telepon'),
            'alamat'        => (string) $this->request->getPost('alamat'),
        ];

        $pasienModel->insert($pasienData);

        $gejalaData = [
            'id'                  => $gejalaId,
            'pasien_id'           => $pasienId,
            'demam_pagi'          => (string) $this->request->getPost('demam_pagi'),
            'demam_sore'          => (string) $this->request->getPost('demam_sore'),
            'sakit_kepala'        => $this->request->getPost('sakit_kepala') === '1' ? 1 : 0,
            'nyeri_otot'          => $this->request->getPost('nyeri_otot') === '1' ? 1 : 0,
            'mual'                => $this->request->getPost('mual') === '1' ? 1 : 0,
            'muntah'              => $this->request->getPost('muntah') === '1' ? 1 : 0,
            'nyeri_perut'         => $this->request->getPost('nyeri_perut') === '1' ? 1 : 0,
            'diare'               => $this->request->getPost('diare') === '1' ? 1 : 0,
            'penurunan_kesadaran' => $this->request->getPost('penurunan_kesadaran') === '1' ? 1 : 0,
            'bradikardia_relatif' => $this->request->getPost('bradikardia_relatif') === '1' ? 1 : 0,
            'lemas'               => $this->request->getPost('lemas') === '1' ? 1 : 0,
        ];

        $gejalaModel->insert($gejalaData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }

        return redirect()->to(site_url('deteksi-dini/hasil/' . $gejalaId));
    }

    public function deteksiDiniHasil(string $gejalaId)
    {
        helper(['url']);

        $gejalaModel = new \App\Models\GejalaModel();
        $pasienModel = new \App\Models\PasienModel();

        $gejala = $gejalaModel->find($gejalaId);
        if ($gejala === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data gejala tidak ditemukan.');
        }

        $pasien = $pasienModel->find($gejala['pasien_id']);
        if ($pasien === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data pasien tidak ditemukan.');
        }

        return view('deteksi_dini_hasil', [
            'gejala' => $gejala,
            'pasien' => $pasien,
        ]);
    }
}
