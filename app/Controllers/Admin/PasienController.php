<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PasienModel;
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

        $diagnosa = $this->request->getGet('diagnosa');
        if ($diagnosa !== null && trim((string)$diagnosa) !== '') {
            $model->where('diagnosa', trim((string)$diagnosa));
        }

        $demamPagi = $this->request->getGet('demam_pagi');
        if ($demamPagi !== null && trim((string)$demamPagi) !== '') {
            $model->where('demam_pagi', trim((string)$demamPagi));
        }

        $demamSore = $this->request->getGet('demam_sore');
        if ($demamSore !== null && trim((string)$demamSore) !== '') {
            $model->where('demam_sore', trim((string)$demamSore));
        }

        $bradikardia = $this->request->getGet('bradikardia_relatif');
        if ($bradikardia !== null && trim((string)$bradikardia) !== '') {
            $model->where('bradikardia_relatif', (int)$bradikardia);
        }

        $pasienId = $this->request->getGet('pasien_id');
        if ($pasienId !== null && trim((string)$pasienId) !== '') {
            $model->where('pasien_id', trim((string)$pasienId));
        }

        $rows = $model->select('pasien_id, nama, usia, demam_pagi, demam_sore, bradikardia_relatif, diagnosa, created_at')
            ->orderBy('created_at', 'DESC')
            ->paginate(10, 'default');

        return view('admin/layout', [
            'title'    => 'Pasien',
            'active'   => 'pasien',
            'mainView' => view('admin/pages/pasien', [
                'rows'  => $rows,
                'pager' => $model->pager,
                'filters' => [
                    'pasien_id' => $pasienId,
                    'nama' => $nama,
                    'diagnosa' => $diagnosa,
                    'demam_pagi' => $demamPagi,
                    'demam_sore' => $demamSore,
                    'bradikardia_relatif' => $bradikardia,
                ]
            ]),
        ]);
    }

    public function pasienCreate()
    {
        return view('admin/layout', [
            'title'    => 'Tambah Pasien',
            'active'   => 'pasien',
            'mainView' => view('admin/pages/pasien_form', ['record' => null]),
        ]);
    }

    public function pasienStore()
    {
        $rules = $this->pasienRules();

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->pasienPayloadFromRequest();
        model(PasienModel::class)->insert($data);

        return redirect()->to(site_url('admin/pasien'))->with('message', 'Pasien berhasil ditambahkan.');
    }

    public function pasienShow(string $id)
    {
        $row = model(PasienModel::class)->find($id);
        if ($row === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/layout', [
            'title'    => 'Detail Pasien',
            'active'   => 'pasien',
            'mainView' => view('admin/pages/pasien_detail', ['row' => $row]),
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
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->pasienPayloadFromRequest();
        model(PasienModel::class)->update($id, $data);

        return redirect()->to(site_url('admin/pasien'))->with('message', 'Pasien berhasil diperbarui.');
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

    private function pasienRules(): array
    {
        $yesNoRule = 'required|in_list[0,1]';
        $demamRule = config('DemamKlasifikasi')->validationRule();

        return [
            'nama'       => 'required|min_length[3]|max_length[191]',
            'usia'       => 'required|is_natural_no_zero|less_than_equal_to[150]',
            'demam_pagi' => $demamRule,
            'demam_sore' => $demamRule,

            'sakit_kepala'        => $yesNoRule,
            'nyeri_otot'          => $yesNoRule,
            'mual'                => $yesNoRule,
            'muntah'              => $yesNoRule,
            'nyeri_perut'         => $yesNoRule,
            'diare'               => $yesNoRule,
            'penurunan_kesadaran' => $yesNoRule,
            'bradikardia_relatif' => $yesNoRule,
            'lemas'               => $yesNoRule,
        ];
    }

    private function pasienPayloadFromRequest(): array
    {
        return [
            'nama'    => (string) $this->request->getPost('nama'),
            'usia'    => (int) $this->request->getPost('usia'),
            'demam_pagi' => (string) $this->request->getPost('demam_pagi'),
            'demam_sore' => (string) $this->request->getPost('demam_sore'),

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
    }
}
