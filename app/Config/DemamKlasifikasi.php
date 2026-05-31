<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class DemamKlasifikasi extends BaseConfig
{
    /** @var list<string> */
    public array $keys = [
        'tidak_demam',
        'demam_ringan',
        'demam_sedang',
        'demam_tinggi',
        'hiperpireksia',
    ];

    /** @var array<string, string> */
    public array $label = [
        'tidak_demam'    => 'Tidak Demam',
        'demam_ringan'   => 'Demam Ringan',
        'demam_sedang'   => 'Demam Sedang',
        'demam_tinggi'   => 'Demam Tinggi',
        'hiperpireksia'  => 'Hiperpireksia',
    ];

    /** @var array<string, string> */
    public array $anak = [
        'tidak_demam'   => '36,5 °C - 37,5 °C',
        'demam_ringan'  => '37,6 °C - 38 °C',
        'demam_sedang'  => '38,1 °C - 39 °C',
        'demam_tinggi'  => '39,1 °C - 40 °C',
        'hiperpireksia' => '> 40 °C',
    ];

    /** @var array<string, string> */
    public array $dewasa = [
        'tidak_demam'   => '36 °C - 37,2 °C',
        'demam_ringan'  => '37,3 °C - 38 °C',
        'demam_sedang'  => '38,1 °C - 39 °C',
        'demam_tinggi'  => '39,1 °C - 40 °C',
        'hiperpireksia' => '> 40 °C',
    ];

    public function kelompokUsia(int $usia): string
    {
        return $usia <= 17 ? 'anak' : 'dewasa';
    }

    public function kelompokUsiaLabel(int $usia): string
    {
        return $this->kelompokUsia($usia) === 'anak'
            ? 'Anak-Anak (0–17 tahun)'
            : 'Dewasa (> 18 tahun)';
    }

    public function rentang(string $kategori, int $usia): string
    {
        $grup = $this->kelompokUsia($usia);
        $map  = $grup === 'anak' ? $this->anak : $this->dewasa;

        return $map[$kategori] ?? '—';
    }

    public function rentangByLabel(string $label, int $usia): string
    {
        $key = array_search($label, $this->label, true);

        return $key !== false ? $this->rentang((string) $key, $usia) : '—';
    }

    /** @return list<string> */
    public function labelValues(): array
    {
        return array_values($this->label);
    }

    public function validationRule(): string
    {
        return 'required|in_list[' . implode(',', $this->labelValues()) . ']';
    }
}
