<?php /** @var array<string, mixed> $row */ ?>
<?php
function rule_yn_badge($val): string
{
    if ($val === null || $val === '') {
        return '<span class="text-slate-400">— Tidak diatur —</span>';
    }
    $on  = ! empty($val);
    $cls = $on ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700';
    $txt = $on ? 'Ya' : 'Tidak';

    return '<span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold '
        . $cls . '">' . esc($txt) . '</span>';
}

$rid = (int) ($row['id'] ?? 0);
?>
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Detail rule klasifikasi</h2>
            <p class="text-sm text-slate-500">ID: <?= esc((string) $rid) ?></p>
        </div>
        <div class="flex flex-wrap gap-2">
            <?php if (in_array(session()->get('admin_role'), ['petugas sik', 'superadmin'], true)) : ?>
                <a href="<?= esc(site_url('admin/rule-klasifikasi/' . $rid . '/edit'), 'attr') ?>"
                   class="rounded-xl border border-mint/40 bg-mint/10 px-4 py-2 text-sm font-semibold text-mint-dark hover:bg-mint/20">
                    Edit
                </a>
            <?php endif; ?>
            <a href="<?= esc(site_url('admin/rule-klasifikasi'), 'attr') ?>"
               class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Kembali
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="grid gap-0 divide-y divide-slate-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
            <div class="p-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Rule</p>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Usia</dt>
                        <dd class="text-slate-900 font-medium"><?= esc((string) ($row['usia'] ?? '— Semua Usia —')) ?> tahun</dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Demam pagi</dt>
                        <dd class="text-slate-900"><?= esc((string) ($row['demam_pagi'] ?? '—')) ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Demam sore</dt>
                        <dd class="text-slate-900"><?= esc((string) ($row['demam_sore'] ?? '—')) ?></dd>
                    </div>

                    <?php
                    $symptoms = [
                        'sakit_kepala'        => 'Sakit kepala',
                        'nyeri_otot'          => 'Nyeri otot',
                        'mual'                => 'Mual',
                        'muntah'              => 'Muntah',
                        'nyeri_perut'         => 'Nyeri perut',
                        'diare'               => 'Diare',
                        'penurunan_kesadaran' => 'Penurunan kesadaran',
                        'bradikardia_relatif' => 'Bradikardia relatif',
                        'lemas'               => 'Lemas',
                    ];
                    foreach ($symptoms as $k => $label) :
                    ?>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-slate-500"><?= esc($label) ?></dt>
                            <dd><?= rule_yn_badge($row[$k] ?? null) ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </div>

            <div class="p-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Hasil</p>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Hasil klasifikasi</dt>
                        <dd class="font-semibold text-slate-900"><?= esc((string) ($row['hasil'] ?? '—')) ?></dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-xs text-slate-500">
            Dibuat: <?= esc((string) ($row['created_at'] ?? '—')) ?>
            · Diperbarui: <?= esc((string) ($row['updated_at'] ?? '—')) ?>
        </div>
    </div>

    <!-- Referensi & Interpretasi Bradikardia Relatif & Kategori Demam -->
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <!-- Legend at the top -->
        <div class="mb-6 pb-6 border-b border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Interpretasi Tingkat Kerawanan (Gradien Warna)</h3>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-x-5 gap-y-2">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/20"></span>
                        <span class="text-xs text-slate-600 font-medium">Rendah / Normal</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-yellow-400 shadow-sm shadow-yellow-400/20"></span>
                        <span class="text-xs text-slate-600 font-medium">Ringan / Curiga</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-orange-400 shadow-sm shadow-orange-400/20"></span>
                        <span class="text-xs text-slate-600 font-medium">Demam Sedang</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-red-500 shadow-sm shadow-red-500/20"></span>
                        <span class="text-xs text-slate-600 font-medium">Tinggi / Bradikardia (+)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-rose-700 shadow-sm shadow-rose-700/20"></span>
                        <span class="text-xs text-slate-600 font-medium">Kritis / Hiperpireksia</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-xl px-3 py-1.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Rendah</span>
                    <div class="h-2 w-32 rounded-full bg-gradient-to-r from-emerald-500 via-yellow-400 via-orange-400 via-red-500 to-rose-700 shadow-inner"></div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Tinggi</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Referensi Bradikardia Relatif -->
            <div class="space-y-6">
                <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">Referensi Bradikardia Relatif</h3>
                
                <div class="space-y-6">
                    <!-- Referensi Anak-Anak -->
                    <div>
                        <h4 class="text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Kelompok Usia Anak-Anak (0–16 tahun)</h4>
                        <p class="text-xs text-slate-500 mb-3">Penyesuaian denyut nadi normal dasar dan peningkatan suhu tubuh.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 border border-slate-150 rounded-xl text-[11px] text-left">
                                <thead class="bg-slate-50 text-slate-500 font-semibold">
                                    <tr>
                                        <th class="px-2.5 py-1.5 border-b">Usia</th>
                                        <th class="px-2.5 py-1.5 border-b bg-emerald-50/60 text-emerald-800">Nadi Normal</th>
                                        <th class="px-2.5 py-1.5 border-b bg-yellow-50/60 text-yellow-805">38,3°C</th>
                                        <th class="px-2.5 py-1.5 border-b bg-orange-50/60 text-orange-805">38,5°C</th>
                                        <th class="px-2.5 py-1.5 border-b bg-red-50/60 text-red-805">39°C</th>
                                        <th class="px-2.5 py-1.5 border-b bg-red-100/60 text-red-905">40°C</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    <tr>
                                        <td class="px-2.5 py-1.5 font-medium">Bayi (0-1)</td>
                                        <td class="px-2.5 py-1.5 bg-emerald-50/20 text-emerald-850">100-160</td>
                                        <td class="px-2.5 py-1.5 bg-yellow-50/20 text-yellow-850">113-173</td>
                                        <td class="px-2.5 py-1.5 bg-orange-50/20 text-orange-850">115-175</td>
                                        <td class="px-2.5 py-1.5 bg-red-50/20 text-red-850">120-180</td>
                                        <td class="px-2.5 py-1.5 bg-red-100/20 text-red-900">130-190</td>
                                    </tr>
                                    <tr>
                                        <td class="px-2.5 py-1.5 font-medium">Toddler (1-3)</td>
                                        <td class="px-2.5 py-1.5 bg-emerald-50/20 text-emerald-850">90-150</td>
                                        <td class="px-2.5 py-1.5 bg-yellow-50/20 text-yellow-850">103-163</td>
                                        <td class="px-2.5 py-1.5 bg-orange-50/20 text-orange-850">105-165</td>
                                        <td class="px-2.5 py-1.5 bg-red-50/20 text-red-850">110-170</td>
                                        <td class="px-2.5 py-1.5 bg-red-100/20 text-red-900">120-180</td>
                                    </tr>
                                    <tr>
                                        <td class="px-2.5 py-1.5 font-medium">Prasekolah (4-5)</td>
                                        <td class="px-2.5 py-1.5 bg-emerald-50/20 text-emerald-850">80-140</td>
                                        <td class="px-2.5 py-1.5 bg-yellow-50/20 text-yellow-850">93-153</td>
                                        <td class="px-2.5 py-1.5 bg-orange-50/20 text-orange-850">95-155</td>
                                        <td class="px-2.5 py-1.5 bg-red-50/20 text-red-850">100-160</td>
                                        <td class="px-2.5 py-1.5 bg-red-100/20 text-red-900">110-170</td>
                                    </tr>
                                    <tr>
                                        <td class="px-2.5 py-1.5 font-medium">Sekolah (6-12)</td>
                                        <td class="px-2.5 py-1.5 bg-emerald-50/20 text-emerald-850">70-120</td>
                                        <td class="px-2.5 py-1.5 bg-yellow-50/20 text-yellow-850">83-133</td>
                                        <td class="px-2.5 py-1.5 bg-orange-50/20 text-orange-850">85-135</td>
                                        <td class="px-2.5 py-1.5 bg-red-50/20 text-red-850">90-140</td>
                                        <td class="px-2.5 py-1.5 bg-red-100/20 text-red-900">100-150</td>
                                    </tr>
                                    <tr>
                                        <td class="px-2.5 py-1.5 font-medium">Remaja (13-16)</td>
                                        <td class="px-2.5 py-1.5 bg-emerald-50/20 text-emerald-850">60-100</td>
                                        <td class="px-2.5 py-1.5 bg-yellow-50/20 text-yellow-850">73-113</td>
                                        <td class="px-2.5 py-1.5 bg-orange-50/20 text-orange-850">75-115</td>
                                        <td class="px-2.5 py-1.5 bg-red-50/20 text-red-850">80-120</td>
                                        <td class="px-2.5 py-1.5 bg-red-100/20 text-red-900">90-130</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1.5">* bpm (beat per minute). Jika nadi aktual lebih rendah dari batas bawah → Bradikardia Relatif (+)</p>
                    </div>
                    
                    <!-- Referensi Dewasa -->
                    <div>
                        <h4 class="text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Kelompok Usia Dewasa (> 16 tahun / Kriteria Cunha)</h4>
                        <p class="text-xs text-slate-500 mb-3">Korelasi denyut nadi (HR) dan suhu tubuh untuk mendeteksi disosiasi.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 border border-slate-150 rounded-xl text-[11px] text-left">
                                <thead class="bg-slate-50 text-slate-500 font-semibold">
                                    <tr>
                                        <th class="px-3 py-1.5 border-b">Suhu Tubuh</th>
                                        <th class="px-3 py-1.5 border-b">Kriteria Denyut Nadi (HR)</th>
                                        <th class="px-3 py-1.5 border-b">Interpretasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    <tr class="bg-emerald-50/20 text-emerald-850">
                                        <td class="px-3 py-1.5 font-medium">&lt; 38,3°C</td>
                                        <td class="px-3 py-1.5">Tidak termasuk evaluasi Cunha</td>
                                        <td class="px-3 py-1.5">Tidak dinilai</td>
                                    </tr>
                                    <tr class="bg-yellow-50/30 text-yellow-850">
                                        <td class="px-3 py-1.5 font-medium">38,3°C</td>
                                        <td class="px-3 py-1.5">&le; 110 bpm</td>
                                        <td class="px-3 py-1.5 font-medium">Curiga</td>
                                    </tr>
                                    <tr class="bg-red-50/20 text-red-850">
                                        <td class="px-3 py-1.5 font-medium">38,9°C</td>
                                        <td class="px-3 py-1.5">&le; 120 bpm</td>
                                        <td class="px-3 py-1.5 font-semibold">Bradikardia Relatif (+)</td>
                                    </tr>
                                    <tr class="bg-red-50/20 text-red-850">
                                        <td class="px-3 py-1.5 font-medium">39,4°C</td>
                                        <td class="px-3 py-1.5">&le; 120 bpm</td>
                                        <td class="px-3 py-1.5 font-semibold">Bradikardia Relatif (+)</td>
                                    </tr>
                                    <tr class="bg-red-100/20 text-red-900">
                                        <td class="px-3 py-1.5 font-medium">40,0°C</td>
                                        <td class="px-3 py-1.5">&le; 130 bpm</td>
                                        <td class="px-3 py-1.5 font-semibold">Bradikardia Relatif (+)</td>
                                    </tr>
                                    <tr class="bg-red-100/20 text-red-900">
                                        <td class="px-3 py-1.5 font-medium">40,6°C</td>
                                        <td class="px-3 py-1.5">&le; 140 bpm</td>
                                        <td class="px-3 py-1.5 font-semibold">Bradikardia Relatif (+)</td>
                                    </tr>
                                    <tr class="bg-rose-100/30 text-rose-950">
                                        <td class="px-3 py-1.5 font-medium">41,1°C</td>
                                        <td class="px-3 py-1.5">&le; 150 bpm</td>
                                        <td class="px-3 py-1.5 font-bold">Bradikardia Relatif (+)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referensi Kategori Demam -->
            <div class="space-y-6">
                <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">Referensi Kategori Demam</h3>
                
                <div class="space-y-6">
                    <!-- Referensi Demam Anak-Anak -->
                    <div>
                        <h4 class="text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Kelompok Usia Anak-Anak (0–17 tahun)</h4>
                        <p class="text-xs text-slate-500 mb-3">Klasifikasi tingkat keparahan demam untuk kelompok usia anak-anak.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 border border-slate-150 rounded-xl text-xs text-left">
                                <thead class="bg-slate-50 text-slate-500 font-semibold">
                                    <tr>
                                        <th class="px-4 py-2 border-b">Kategori Demam</th>
                                        <th class="px-4 py-2 border-b">Rentang Suhu (°C)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    <tr class="bg-emerald-50/20 text-emerald-850">
                                        <td class="px-4 py-2 font-medium">Tidak Demam</td>
                                        <td class="px-4 py-2">36,5 °C - 37,5 °C</td>
                                    </tr>
                                    <tr class="bg-yellow-50/30 text-yellow-850">
                                        <td class="px-4 py-2 font-medium">Demam Ringan</td>
                                        <td class="px-4 py-2">37,6 °C - 38 °C</td>
                                    </tr>
                                    <tr class="bg-orange-50/20 text-orange-850">
                                        <td class="px-4 py-2 font-medium">Demam Sedang</td>
                                        <td class="px-4 py-2">38,1 °C - 39 °C</td>
                                    </tr>
                                    <tr class="bg-red-50/20 text-red-850">
                                        <td class="px-4 py-2 font-medium">Demam Tinggi</td>
                                        <td class="px-4 py-2">39,1 °C - 40 °C</td>
                                    </tr>
                                    <tr class="bg-rose-100/30 text-rose-950">
                                        <td class="px-4 py-2 font-medium">Hiperpireksia</td>
                                        <td class="px-4 py-2 font-bold">&gt; 40 °C</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Referensi Demam Dewasa -->
                    <div>
                        <h4 class="text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Kelompok Usia Dewasa (&ge; 18 tahun)</h4>
                        <p class="text-xs text-slate-500 mb-3">Klasifikasi tingkat keparahan demam untuk kelompok usia dewasa.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 border border-slate-150 rounded-xl text-xs text-left">
                                <thead class="bg-slate-50 text-slate-500 font-semibold">
                                    <tr>
                                        <th class="px-4 py-2 border-b">Kategori Demam</th>
                                        <th class="px-4 py-2 border-b">Rentang Suhu (°C)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    <tr class="bg-emerald-50/20 text-emerald-850">
                                        <td class="px-4 py-2 font-medium">Tidak Demam</td>
                                        <td class="px-4 py-2">36 °C - 37,2 °C</td>
                                    </tr>
                                    <tr class="bg-yellow-50/30 text-yellow-850">
                                        <td class="px-4 py-2 font-medium">Demam Ringan</td>
                                        <td class="px-4 py-2">37,3 °C - 38 °C</td>
                                    </tr>
                                    <tr class="bg-orange-50/20 text-orange-850">
                                        <td class="px-4 py-2 font-medium">Demam Sedang</td>
                                        <td class="px-4 py-2">38,1 °C - 39 °C</td>
                                    </tr>
                                    <tr class="bg-red-50/20 text-red-850">
                                        <td class="px-4 py-2 font-medium">Demam Tinggi</td>
                                        <td class="px-4 py-2">39,1 °C - 40 °C</td>
                                    </tr>
                                    <tr class="bg-rose-100/30 text-rose-950">
                                        <td class="px-4 py-2 font-medium">Hiperpireksia</td>
                                        <td class="px-4 py-2 font-bold">&gt; 40 °C</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
