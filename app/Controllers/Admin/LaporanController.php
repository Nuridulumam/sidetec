<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class LaporanController extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['url', 'form']);
    }

    public function laporan()
    {
        $model = model(LaporanModel::class);
        $model->select('laporan.id, pasien.pasien_id, pasien.nama, pasien.usia, pasien.bradikardia_relatif, laporan.diagnosa, laporan.created_at')
              ->join('pasien', 'laporan.pasien_id = pasien.id');

        $nama = $this->request->getGet('nama');
        if ($nama !== null && trim((string)$nama) !== '') {
            $model->like('pasien.nama', trim((string)$nama));
        }

        $bradikardia = $this->request->getGet('bradikardia_relatif');
        if ($bradikardia !== null && trim((string)$bradikardia) !== '') {
            $model->where('pasien.bradikardia_relatif', (int)$bradikardia);
        }

        $diagnosa = $this->request->getGet('diagnosa');
        if ($diagnosa !== null && trim((string)$diagnosa) !== '') {
            $model->where('laporan.diagnosa', trim((string)$diagnosa));
        }

        $rows = $model->orderBy('laporan.created_at', 'DESC')
            ->paginate(10, 'default');

        return view('admin/layout', [
            'title'    => 'Laporan',
            'active'   => 'laporan',
            'mainView' => view('admin/pages/laporan', [
                'rows'  => $rows,
                'pager' => $model->pager,
                'filters' => [
                    'nama' => $nama,
                    'bradikardia_relatif' => $bradikardia,
                    'diagnosa' => $diagnosa,
                ]
            ]),
        ]);
    }

    public function laporanExport()
    {
        $model = model(LaporanModel::class);
        $model->select('laporan.created_at, laporan.diagnosa, pasien.nama, pasien.usia, pasien.demam_pagi, pasien.demam_sore, pasien.sakit_kepala, pasien.nyeri_otot, pasien.mual, pasien.muntah, pasien.nyeri_perut, pasien.diare, pasien.penurunan_kesadaran, pasien.bradikardia_relatif, pasien.lemas, pasien.tanggal_lahir, pasien.jenis_kelamin, pasien.telepon, pasien.alamat')
              ->join('pasien', 'laporan.pasien_id = pasien.id');

        $nama = $this->request->getGet('nama');
        if ($nama !== null && trim((string)$nama) !== '') {
            $model->like('pasien.nama', trim((string)$nama));
        }

        $bradikardia = $this->request->getGet('bradikardia_relatif');
        if ($bradikardia !== null && trim((string)$bradikardia) !== '') {
            $model->where('pasien.bradikardia_relatif', (int)$bradikardia);
        }

        $diagnosa = $this->request->getGet('diagnosa');
        if ($diagnosa !== null && trim((string)$diagnosa) !== '') {
            $model->where('laporan.diagnosa', trim((string)$diagnosa));
        }

        $rows = $model->orderBy('laporan.created_at', 'DESC')->findAll();

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

        // 1. Report Title (Centered across columns A to T, Font size 24, Bold)
        $sheet->mergeCells('A1:T1');
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
        $lastHeaderCol = 'T'; // Column T corresponds to index 20 (since A to T is 20 columns)

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
}
