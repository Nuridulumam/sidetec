<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\GejalaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PasienController extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['url', 'form']);
    }

    public function pasien()
    {
        $model = model(PasienModel::class);

        $nama = $this->request->getGet('nama');
        if ($nama !== null && trim((string)$nama) !== '') {
            $model->like('nama', trim((string)$nama));
        }

        $nik = $this->request->getGet('nik');
        if ($nik !== null && trim((string)$nik) !== '') {
            $model->where('nik', trim((string)$nik));
        }

        $nomorRm = $this->request->getGet('nomor_rm');
        if ($nomorRm !== null && trim((string)$nomorRm) !== '') {
            $model->where('pasien.nomor_rm', (int)$nomorRm);
        }

        $rows = $model->select('pasien.id, pasien.pasien_id, pasien.nomor_rm, pasien.nama, pasien.tanggal_lahir, pasien.nik, pasien.usia, pasien.jenis_kelamin, pasien.created_at')
            ->select('(SELECT diagnosa FROM gejala WHERE gejala.pasien_id = pasien.id ORDER BY created_at DESC LIMIT 1) as diagnosa_terakhir')
            ->orderBy('created_at', 'DESC')
            ->paginate(10, 'default');

        return view('admin/layout', [
            'title'    => 'Pasien',
            'active'   => 'pasien',
            'mainView' => view('admin/pages/pasien', [
                'rows'  => $rows,
                'pager' => $model->pager,
                'filters' => [
                    'nama'     => $nama,
                    'nik'      => $nik,
                    'nomor_rm' => $nomorRm,
                ]
            ]),
        ]);
    }

    public function pasienCreate()
    {
        $db = \Config\Database::connect();
        $row = $db->table('pasien')->selectMax('nomor_rm')->get()->getRowArray();
        $max = $row['nomor_rm'] ?? 0;
        $nextNomorRm = ($max > 0) ? $max + 1 : 100001;

        return view('admin/layout', [
            'title'    => 'Tambah Pasien',
            'active'   => 'pasien',
            'mainView' => view('admin/pages/pasien_form', [
                'record' => null,
                'nextNomorRm' => $nextNomorRm,
            ]),
        ]);
    }

    public function pasienStore()
    {
        $rules = $this->pasienRules();

        if (! $this->validate($rules, [
            'nik' => [
                'exact_length' => 'NIK harus 16 digit.',
                'numeric' => 'NIK hanya boleh berupa angka.',
                'required' => 'NIK wajib diisi.'
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->pasienPayloadFromRequest();
        model(PasienModel::class)->insert($data);

        return redirect()->to(site_url('admin/pasien'))->with('message', 'Pasien master berhasil ditambahkan.');
    }

    public function pasienShow(string $id)
    {
        $row = model(PasienModel::class)->find($id);
        if ($row === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Fetch symptom history
        $history = model(GejalaModel::class)
            ->where('pasien_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $isLaporan = strpos(current_url(), 'admin/laporan/pasien') !== false;

        return view('admin/layout', [
            'title'    => 'Detail Pasien',
            'active'   => $isLaporan ? 'laporan' : 'pasien',
            'mainView' => view('admin/pages/pasien_detail', [
                'row'     => $row,
                'history' => $history,
                'backUrl' => $isLaporan ? site_url('admin/laporan') : site_url('admin/pasien'),
            ]),
        ]);
    }

    public function pasienEdit(string $id)
    {
        $row = model(PasienModel::class)->find($id);
        if ($row === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/layout', [
            'title'    => 'Edit Pasien',
            'active'   => 'pasien',
            'mainView' => view('admin/pages/pasien_form', ['record' => $row]),
        ]);
    }

    public function pasienUpdate(string $id)
    {
        $existing = model(PasienModel::class)->find($id);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = $this->pasienRules();
        if (! $this->validate($rules, [
            'nik' => [
                'exact_length' => 'NIK harus 16 digit.',
                'numeric' => 'NIK hanya boleh berupa angka.',
                'required' => 'NIK wajib diisi.'
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->pasienPayloadFromRequest();
        model(PasienModel::class)->update($id, $data);

        return redirect()->to(site_url('admin/pasien'))->with('message', 'Pasien master berhasil diperbarui.');
    }

    public function pasienDelete(string $id)
    {
        $existing = model(PasienModel::class)->find($id);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        model(PasienModel::class)->delete($id);

        return redirect()->to(site_url('admin/pasien'))->with('message', 'Pasien berhasil dihapus.');
    }

    // --- Kasus / Gejala Management ---

    public function gejalaCreate()
    {
        $pasienId = $this->request->getGet('pasien_id');
        $patients = model(PasienModel::class)->orderBy('nama', 'ASC')->findAll();

        return view('admin/layout', [
            'title'    => 'Tambah Kasus / Gejala',
            'active'   => 'pasien',
            'mainView' => view('admin/pages/gejala_form', [
                'patients'       => $patients,
                'selectedPasien' => $pasienId,
                'record'         => null
            ]),
        ]);
    }

    public function gejalaStore()
    {
        $rules = [
            'pasien_id'           => 'required',
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

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'pasien_id'           => (string) $this->request->getPost('pasien_id'),
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

        model(GejalaModel::class)->insert($data);

        return redirect()->to(site_url('admin/pasien/' . $data['pasien_id']))->with('message', 'Gejala/Kasus berhasil ditambahkan.');
    }

    public function gejalaDelete(string $id)
    {
        $gejalaModel = model(GejalaModel::class);
        $existing = $gejalaModel->find($id);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $gejalaModel->delete($id);

        return redirect()->back()->with('message', 'Data kasus/gejala berhasil dihapus.');
    }

    // --- Private Helper Methods ---

    private function pasienRules(): array
    {
        return [
            'nama'          => 'required|min_length[3]|max_length[191]',
            'tanggal_lahir' => 'required|valid_date[Y-m-d]',
            'nik'           => 'required|numeric|exact_length[16]',
            'usia'          => 'required|is_natural_no_zero|less_than_equal_to[150]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'telepon'       => 'permit_empty|max_length[32]',
            'alamat'        => 'permit_empty',
        ];
    }

    private function pasienPayloadFromRequest(): array
    {
        return [
            'nama'          => (string) $this->request->getPost('nama'),
            'tanggal_lahir' => (string) $this->request->getPost('tanggal_lahir'),
            'nik'           => (string) $this->request->getPost('nik'),
            'usia'          => (int) $this->request->getPost('usia'),
            'jenis_kelamin' => (string) $this->request->getPost('jenis_kelamin'),
            'telepon'       => (string) $this->request->getPost('telepon'),
            'alamat'        => (string) $this->request->getPost('alamat'),
        ];
    }
}
