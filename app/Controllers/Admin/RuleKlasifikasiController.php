<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RuleKlasifikasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class RuleKlasifikasiController extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['url', 'form']);
    }

    public function ruleKlasifikasi()
    {
        $model = model(RuleKlasifikasiModel::class);
        $rows = $model->orderBy('id', 'ASC')
            ->paginate(10, 'default');

        return view('admin/layout', [
            'title'    => 'Rule Klasifikasi',
            'active'   => 'rules',
            'mainView' => view('admin/pages/rule_klasifikasi', [
                'rows'  => $rows,
                'pager' => $model->pager,
            ]),
        ]);
    }

    public function ruleKlasifikasiCreate()
    {
        return view('admin/layout', [
            'title'    => 'Tambah Rule Klasifikasi',
            'active'   => 'rules',
            'mainView' => view('admin/pages/rule_klasifikasi_form', ['record' => null]),
        ]);
    }

    public function ruleKlasifikasiStore()
    {
        if (! $this->validate($this->ruleKlasifikasiRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(RuleKlasifikasiModel::class)->insert($this->ruleKlasifikasiPayloadFromRequest());

        return redirect()->to(site_url('admin/rule-klasifikasi'))
            ->with('message', 'Rule klasifikasi berhasil ditambahkan.');
    }

    public function ruleKlasifikasiShow(string $id)
    {
        $row = model(RuleKlasifikasiModel::class)->find((int) $id);
        if ($row === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/layout', [
            'title'    => 'Detail Rule Klasifikasi',
            'active'   => 'rules',
            'mainView' => view('admin/pages/rule_klasifikasi_detail', ['row' => $row]),
        ]);
    }

    public function ruleKlasifikasiEdit(string $id)
    {
        $row = model(RuleKlasifikasiModel::class)->find((int) $id);
        if ($row === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/layout', [
            'title'    => 'Edit Rule Klasifikasi',
            'active'   => 'rules',
            'mainView' => view('admin/pages/rule_klasifikasi_form', ['record' => $row]),
        ]);
    }

    public function ruleKlasifikasiUpdate(string $id)
    {
        $rid = (int) $id;

        if (model(RuleKlasifikasiModel::class)->find($rid) === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (! $this->validate($this->ruleKlasifikasiRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(RuleKlasifikasiModel::class)->update($rid, $this->ruleKlasifikasiPayloadFromRequest());

        return redirect()->to(site_url('admin/rule-klasifikasi'))
            ->with('message', 'Rule klasifikasi berhasil diperbarui.');
    }

    public function ruleKlasifikasiDelete(string $id)
    {
        $rid = (int) $id;

        if (model(RuleKlasifikasiModel::class)->find($rid) === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        model(RuleKlasifikasiModel::class)->delete($rid);

        return redirect()->to(site_url('admin/rule-klasifikasi'))
            ->with('message', 'Rule klasifikasi berhasil dihapus.');
    }

    private function ruleKlasifikasiRules(): array
    {
        return [
            'usia'                => 'permit_empty|is_natural_no_zero|less_than_equal_to[150]',
            'demam_pagi'          => 'permit_empty|max_length[191]',
            'demam_sore'          => 'permit_empty|max_length[191]',
            'sakit_kepala'        => 'permit_empty|in_list[0,1]',
            'nyeri_otot'          => 'permit_empty|in_list[0,1]',
            'mual'                => 'permit_empty|in_list[0,1]',
            'muntah'              => 'permit_empty|in_list[0,1]',
            'nyeri_perut'         => 'permit_empty|in_list[0,1]',
            'diare'               => 'permit_empty|in_list[0,1]',
            'penurunan_kesadaran' => 'permit_empty|in_list[0,1]',
            'bradikardia_relatif' => 'permit_empty|in_list[0,1]',
            'lemas'               => 'permit_empty|in_list[0,1]',
            'hasil'               => 'required|in_list[Suspect Typhoid Fever,Non Suspect Typhoid Fever]',
        ];
    }

    private function ruleKlasifikasiPayloadFromRequest(): array
    {
        $usia      = $this->request->getPost('usia');
        $demamPagi = trim((string) ($this->request->getPost('demam_pagi') ?? ''));
        $demamSore = trim((string) ($this->request->getPost('demam_sore') ?? ''));
        $hasil     = trim((string) ($this->request->getPost('hasil') ?? ''));

        return [
            'usia'                => ($usia === null || $usia === '') ? null : (int) $usia,
            'demam_pagi'          => $demamPagi === '' ? null : $demamPagi,
            'demam_sore'          => $demamSore === '' ? null : $demamSore,
            'sakit_kepala'        => $this->ruleOptionalEnum('sakit_kepala'),
            'nyeri_otot'          => $this->ruleOptionalEnum('nyeri_otot'),
            'mual'                => $this->ruleOptionalEnum('mual'),
            'muntah'              => $this->ruleOptionalEnum('muntah'),
            'nyeri_perut'         => $this->ruleOptionalEnum('nyeri_perut'),
            'diare'               => $this->ruleOptionalEnum('diare'),
            'penurunan_kesadaran' => $this->ruleOptionalEnum('penurunan_kesadaran'),
            'bradikardia_relatif' => $this->ruleOptionalEnum('bradikardia_relatif'),
            'lemas'               => $this->ruleOptionalEnum('lemas'),
            'hasil'               => $hasil,
        ];
    }

    private function ruleOptionalEnum(string $field): ?int
    {
        $raw = $this->request->getPost($field);
        if ($raw === null || $raw === '') {
            return null;
        }

        return $raw === '1' ? 1 : 0;
    }
}
