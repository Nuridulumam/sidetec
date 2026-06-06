<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\RuleKlasifikasiModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    /** Nilai role yang diizinkan (harus selaras dengan dropdown di users_form). */
    protected string $userRoleRule = 'required|regex_match[#^(admin|operator|superadmin|petugas poli|petugas sik)$#u]';

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['url', 'form']);
    }

    public function dashboard()
    {
        $db = db_connect();

        $counts = [
            'pasien' => $db->table('pasien')->countAll(),
            'rules'  => $db->table('rule_klasifikasi')->countAll(),
            'laporan'=> $db->table('laporan')->countAll(),
            'users'  => $db->table('users')->countAll(),
        ];

        return view('admin/layout', [
            'title'    => 'Dashboard',
            'active'   => 'dashboard',
            'mainView' => view('admin/pages/dashboard', ['counts' => $counts]),
        ]);
    }

    public function pasien()
    {
        $model = model(PasienModel::class);
        $rows = $model->select('id, nama, usia, demam_pagi, demam_sore, bradikardia_relatif, diagnosa, created_at')
            ->orderBy('id', 'DESC')
            ->paginate(10, 'default');

        return view('admin/layout', [
            'title'    => 'Pasien',
            'active'   => 'pasien',
            'mainView' => view('admin/pages/pasien', [
                'rows'  => $rows,
                'pager' => $model->pager,
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
        $pid = (int) $id;
        $row = model(PasienModel::class)->find($pid);
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
        $pid  = (int) $id;
        $row = model(PasienModel::class)->find($pid);
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
        $pid = (int) $id;

        $existing = model(PasienModel::class)->find($pid);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = $this->pasienRules();
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->pasienPayloadFromRequest();
        model(PasienModel::class)->update($pid, $data);

        return redirect()->to(site_url('admin/pasien'))->with('message', 'Pasien berhasil diperbarui.');
    }

    public function pasienDelete(string $id)
    {
        $pid = (int) $id;

        $existing = model(PasienModel::class)->find($pid);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        model(PasienModel::class)->delete($pid);

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

            'penurunan_kesadaran_deskripsi' => 'required_if[penurunan_kesadaran,1]|permit_empty|max_length[2000]',
        ];
    }

    private function pasienPayloadFromRequest(): array
    {
        $penurunan = $this->request->getPost('penurunan_kesadaran') === '1' ? 1 : 0;
        $desc      = (string) ($this->request->getPost('penurunan_kesadaran_deskripsi') ?? '');
        $desc      = trim($desc);

        if ($penurunan === 0) {
            $desc = '';
        }

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
            'penurunan_kesadaran' => $penurunan,
            'penurunan_kesadaran_deskripsi' => $desc === '' ? null : $desc,
            'bradikardia_relatif' => $this->request->getPost('bradikardia_relatif') === '1' ? 1 : 0,
            'lemas'               => $this->request->getPost('lemas') === '1' ? 1 : 0,
        ];
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
            'hasil'               => 'required|min_length[1]|max_length[191]',
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

    public function laporan()
    {
        $model = model(PasienModel::class);
        $rows = $model->select('id, nama, usia, bradikardia_relatif, diagnosa, created_at')
            ->orderBy('id', 'DESC')
            ->paginate(10, 'default');

        return view('admin/layout', [
            'title'    => 'Laporan',
            'active'   => 'laporan',
            'mainView' => view('admin/pages/laporan', [
                'rows'  => $rows,
                'pager' => $model->pager,
            ]),
        ]);
    }

    public function laporanExport()
    {
        $model = model(PasienModel::class);
        $rows = $model->orderBy('id', 'DESC')->findAll();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setShowGridlines(true);

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $monthNum = (int) date('m');
        $year = date('Y');
        $monthName = $months[$monthNum] ?? date('F');

        // 1. Report Title (Centered across columns A to U, Font size 24, Bold)
        $sheet->mergeCells('A1:U1');
        $sheet->setCellValue('A1', "Laporan Deteksi Dini Typhoid - {$monthName} {$year}");
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 24,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(45);

        // Blank space row
        $sheet->getRowDimension(2)->setRowHeight(15);

        // Define Headers (all columns except ID)
        $headers = [
            'No',
            'Nama Lengkap',
            'Usia',
            'Demam Pagi',
            'Demam Sore',
            'Sakit Kepala',
            'Nyeri Otot',
            'Mual',
            'Muntah',
            'Nyeri Perut',
            'Diare',
            'Penurunan Kesadaran',
            'Deskripsi Penurunan Kesadaran',
            'Bradikardia Relatif',
            'Lemas',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Telepon',
            'Alamat',
            'Hasil Klasifikasi',
            'Tanggal Masuk'
        ];

        // 2. Write Headers at row 3 (Font size 16, Bold)
        $headerCol = 'A';
        foreach ($headers as $headerText) {
            $sheet->setCellValue($headerCol . '3', $headerText);
            $headerCol++;
        }
        $lastHeaderCol = 'U'; // Column U corresponds to index 21 (since A to U is 21 columns)

        // Header style array
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 16,
                'name' => 'Calibri',
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2E8F0'], // slate-200
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '94A3B8'], // slate-400
                ],
            ],
        ];
        $sheet->getStyle("A3:{$lastHeaderCol}3")->applyFromArray($headerStyle);
        $sheet->getRowDimension(3)->setRowHeight(34);

        // 3. Write Data starting from row 4 (Font size 14)
        $rowIdx = 4;
        $noIdx = 1;
        foreach ($rows as $r) {
            $yn = function ($val) {
                if ($val === null || $val === '') return '—';
                return (int)$val === 1 ? 'Ya' : 'Tidak';
            };

            $dateMasuk = isset($r['created_at']) ? date('d-m-Y H:i:s', strtotime($r['created_at'])) : '—';
            $tglLahir = isset($r['tanggal_lahir']) ? date('d-m-Y', strtotime($r['tanggal_lahir'])) : '—';

            $dataRow = [
                $noIdx++,
                $r['nama'] ?? '—',
                isset($r['usia']) ? $r['usia'] . ' tahun' : '—',
                $r['demam_pagi'] ?? '—',
                $r['demam_sore'] ?? '—',
                $yn($r['sakit_kepala'] ?? null),
                $yn($r['nyeri_otot'] ?? null),
                $yn($r['mual'] ?? null),
                $yn($r['muntah'] ?? null),
                $yn($r['nyeri_perut'] ?? null),
                $yn($r['diare'] ?? null),
                $yn($r['penurunan_kesadaran'] ?? null),
                $r['penurunan_kesadaran_deskripsi'] ?? '—',
                $yn($r['bradikardia_relatif'] ?? null),
                $yn($r['lemas'] ?? null),
                $tglLahir,
                $r['jenis_kelamin'] ?? '—',
                $r['telepon'] ?? '—',
                $r['alamat'] ?? '—',
                $r['diagnosa'] ?? 'Tidak terklasifikasi',
                $dateMasuk
            ];

            $colIdx = 'A';
            foreach ($dataRow as $val) {
                $sheet->setCellValue($colIdx . $rowIdx, $val);
                $colIdx++;
            }

            // General styling for data rows (Font size 14)
            $sheet->getStyle("A{$rowIdx}:{$lastHeaderCol}{$rowIdx}")->applyFromArray([
                'font' => [
                    'size' => 14,
                    'name' => 'Calibri',
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'CBD5E1'], // slate-300
                    ],
                ],
            ]);
            $sheet->getRowDimension($rowIdx)->setRowHeight(24);

            $rowIdx++;
        }

        // Auto size columns to prevent text truncation
        $colRange = range('A', $lastHeaderCol);
        foreach ($colRange as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = "Laporan Deteksi Dini Typhoid - {$monthName} {$year}.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function users()
    {
        $rows = db_connect()->table('users')
            ->select('id, email, full_name, role, is_active, created_at, updated_at')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/layout', [
            'title'    => 'Kelola Pengguna',
            'active'   => 'users',
            'mainView' => view('admin/pages/users', ['rows' => $rows]),
        ]);
    }

    public function usersCreate()
    {
        return view('admin/layout', [
            'title'    => 'Tambah Pengguna',
            'active'   => 'users',
            'mainView' => view('admin/pages/users_form', ['record' => null]),
        ]);
    }

    public function usersStore()
    {
        $rules = [
            'email'     => 'required|valid_email|max_length[191]|is_unique[users.email]',
            'password'  => 'required|min_length[8]',
            'full_name' => 'required|min_length[3]|max_length[150]',
            'role'      => $this->userRoleRule,
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(UserModel::class)->insert([
            'email'           => $this->request->getPost('email'),
            'password_hash'   => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name'       => $this->request->getPost('full_name'),
            'role'            => $this->request->getPost('role'),
            'is_active'       => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ]);

        return redirect()->to(site_url('admin/users'))->with('message', 'Pengguna berhasil ditambahkan.');
    }

    public function usersShow(string $id)
    {
        $user = db_connect()->table('users')
            ->select('id, email, full_name, role, is_active, created_at, updated_at')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/layout', [
            'title'    => 'Detail Pengguna',
            'active'   => 'users',
            'mainView' => view('admin/pages/users_detail', ['user' => $user]),
        ]);
    }

    public function usersEdit(string $id)
    {
        $user = db_connect()->table('users')
            ->select('id, email, full_name, role, is_active')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/layout', [
            'title'    => 'Edit Pengguna',
            'active'   => 'users',
            'mainView' => view('admin/pages/users_form', ['record' => $user]),
        ]);
    }

    public function usersUpdate(string $id)
    {
        $userId = (int) $id;

        $existing = model(UserModel::class)->find($userId);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'email'     => "required|valid_email|max_length[191]|is_unique[users.email,id,{$userId}]",
            'password'  => 'permit_empty|min_length[8]',
            'full_name' => 'required|min_length[3]|max_length[150]',
            'role'      => $this->userRoleRule,
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'email'     => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'role'      => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ];

        $pwd = $this->request->getPost('password');
        if ($pwd !== null && $pwd !== '') {
            $data['password_hash'] = password_hash((string) $pwd, PASSWORD_DEFAULT);
        }

        model(UserModel::class)->update($userId, $data);

        return redirect()->to(site_url('admin/users'))->with('message', 'Pengguna berhasil diperbarui.');
    }

    public function usersDelete(string $id)
    {
        $userId = (int) $id;

        if ($userId === (int) session()->get('admin_id')) {
            return redirect()->to(site_url('admin/users'))->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $existing = model(UserModel::class)->find($userId);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        model(UserModel::class)->delete($userId);

        return redirect()->to(site_url('admin/users'))->with('message', 'Pengguna berhasil dihapus.');
    }
}
