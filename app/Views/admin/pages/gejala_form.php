<?php
/** @var array<string, mixed>[] $patients */
/** @var string|null $selectedPasien */
$formAction = site_url('admin/gejala/store');

function yn_old(string $key, ?array $record): string
{
    $val = old($key);
    if ($val === null) {
        if ($record === null || ! array_key_exists($key, $record)) {
            return '';
        }
        $raw = $record[$key];
        return $raw === null ? '' : (string) $raw;
    }
    return (string) $val;
}
?>
<div class="mx-auto max-w-[96rem] px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-6 items-start">
        
        <!-- Left Side: Bradikardia Relatif Info -->
        <div class="xl:col-span-4 md:col-span-1 order-2 xl:order-1 space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <!-- Referensi Bradikardia Relatif -->
                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">Referensi Bradikardia Relatif</h3>
                    
                    <!-- Info Box -->
                    <div class="flex items-start gap-3 rounded-2xl bg-gradient-to-r from-blue-50/60 to-indigo-50/60 border border-blue-100/80 p-3.5 text-xs text-slate-650 shadow-sm">
                        <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-blue-500/10 text-blue-600 shrink-0 mt-0.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="leading-relaxed pt-0.5 text-slate-700">Lakukan dengan cara menekan denyut nadi sendiri, hitung jumlah denyutan selama 1 menit.</p>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Referensi Anak-Anak -->
                        <div>
                            <h4 class="text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Kelompok Usia Anak-Anak (0–16 tahun)</h4>
                            <p class="text-xs text-slate-500 mb-3">Penyesuaian denyut nadi normal dasar dan peningkatan suhu tubuh.</p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200 border border-slate-150 rounded-xl text-[11px] text-left">
                                    <thead class="bg-slate-50 text-slate-500 font-semibold">
                                        <tr>
                                            <th class="px-2 py-1.5 border-b">Usia</th>
                                            <th class="px-2 py-1.5 border-b bg-emerald-50/60 text-emerald-800">Nadi Normal</th>
                                            <th class="px-2 py-1.5 border-b bg-yellow-50/60 text-yellow-805">38,3°C</th>
                                            <th class="px-2 py-1.5 border-b bg-orange-50/60 text-orange-805">38,5°C</th>
                                            <th class="px-2 py-1.5 border-b bg-red-50/60 text-red-805">39°C</th>
                                            <th class="px-2 py-1.5 border-b bg-red-100/60 text-red-905">40°C</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-700">
                                        <tr>
                                            <td class="px-2 py-1.5 font-medium">Bayi (0-1)</td>
                                            <td class="px-2 py-1.5 bg-emerald-50/20 text-emerald-850">100-160</td>
                                            <td class="px-2 py-1.5 bg-yellow-50/20 text-yellow-850">113-173</td>
                                            <td class="px-2 py-1.5 bg-orange-50/20 text-orange-850">115-175</td>
                                            <td class="px-2 py-1.5 bg-red-50/20 text-red-850">120-180</td>
                                            <td class="px-2 py-1.5 bg-red-100/20 text-red-900">130-190</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1.5 font-medium">Toddler (1-3)</td>
                                            <td class="px-2 py-1.5 bg-emerald-50/20 text-emerald-850">90-150</td>
                                            <td class="px-2 py-1.5 bg-yellow-50/20 text-yellow-850">103-163</td>
                                            <td class="px-2 py-1.5 bg-orange-50/20 text-orange-850">105-165</td>
                                            <td class="px-2 py-1.5 bg-red-50/20 text-red-850">110-170</td>
                                            <td class="px-2 py-1.5 bg-red-100/20 text-red-900">120-180</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1.5 font-medium">Prasekolah (4-5)</td>
                                            <td class="px-2 py-1.5 bg-emerald-50/20 text-emerald-850">80-140</td>
                                            <td class="px-2 py-1.5 bg-yellow-50/20 text-yellow-850">93-153</td>
                                            <td class="px-2 py-1.5 bg-orange-50/20 text-orange-850">95-155</td>
                                            <td class="px-2 py-1.5 bg-red-50/20 text-red-850">100-160</td>
                                            <td class="px-2 py-1.5 bg-red-100/20 text-red-900">110-170</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1.5 font-medium">Sekolah (6-12)</td>
                                            <td class="px-2 py-1.5 bg-emerald-50/20 text-emerald-850">70-120</td>
                                            <td class="px-2 py-1.5 bg-yellow-50/20 text-yellow-850">83-133</td>
                                            <td class="px-2 py-1.5 bg-orange-50/20 text-orange-850">85-135</td>
                                            <td class="px-2 py-1.5 bg-red-50/20 text-red-850">90-140</td>
                                            <td class="px-2 py-1.5 bg-red-100/20 text-red-900">100-150</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-1.5 font-medium">Remaja (13-16)</td>
                                            <td class="px-2 py-1.5 bg-emerald-50/20 text-emerald-850">60-100</td>
                                            <td class="px-2 py-1.5 bg-yellow-50/20 text-yellow-850">73-113</td>
                                            <td class="px-2 py-1.5 bg-orange-50/20 text-orange-850">75-115</td>
                                            <td class="px-2 py-1.5 bg-red-50/20 text-red-850">80-120</td>
                                            <td class="px-2 py-1.5 bg-red-100/20 text-red-900">90-130</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1.5">* bpm (beat per minute). Jika nadi aktual lebih rendah dari batas bawah → Bradikardia Relatif (+)</p>
                        </div>
                        
                        <!-- Referensi Dewasa -->
                        <div>
                            <h4 class="text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Kelompok Usia Dewasa (&gt; 16 tahun / Kriteria Cunha)</h4>
                            <p class="text-xs text-slate-500 mb-3">Korelasi denyut nadi (HR) dan suhu tubuh untuk mendeteksi disosiasi.</p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200 border border-slate-150 rounded-xl text-[11px] text-left">
                                    <thead class="bg-slate-50 text-slate-500 font-semibold">
                                        <tr>
                                            <th class="px-3 py-1.5 border-b">Suhu Tubuh</th>
                                            <th class="px-3 py-1.5 border-b">Denyut Nadi (HR)</th>
                                            <th class="px-3 py-1.5 border-b">Interpretasi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-slate-700">
                                        <tr class="bg-emerald-50/20 text-emerald-850">
                                            <td class="px-3 py-1.5 font-medium">&lt; 38,3°C</td>
                                            <td class="px-3 py-1.5">Tidak dinilai</td>
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
                                            <td class="px-3 py-1.5 font-semibold">Bradikardia (+)</td>
                                        </tr>
                                        <tr class="bg-red-50/20 text-red-850">
                                            <td class="px-3 py-1.5 font-medium">39,4°C</td>
                                            <td class="px-3 py-1.5">&le; 120 bpm</td>
                                            <td class="px-3 py-1.5 font-semibold">Bradikardia (+)</td>
                                        </tr>
                                        <tr class="bg-red-100/20 text-red-900">
                                            <td class="px-3 py-1.5 font-medium">40,0°C</td>
                                            <td class="px-3 py-1.5">&le; 130 bpm</td>
                                            <td class="px-3 py-1.5 font-semibold">Bradikardia (+)</td>
                                        </tr>
                                        <tr class="bg-red-100/20 text-red-900">
                                            <td class="px-3 py-1.5 font-medium">40,6°C</td>
                                            <td class="px-3 py-1.5">&le; 140 bpm</td>
                                            <td class="px-3 py-1.5 font-semibold">Bradikardia (+)</td>
                                        </tr>
                                        <tr class="bg-rose-100/30 text-rose-950">
                                            <td class="px-3 py-1.5 font-medium">41,1°C</td>
                                            <td class="px-3 py-1.5">&le; 150 bpm</td>
                                            <td class="px-3 py-1.5 font-bold">Bradikardia (+)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle: Gejala Form -->
        <div class="xl:col-span-5 md:col-span-2 order-1 xl:order-2 space-y-6">
            <?php
            $flashErrors = session()->getFlashdata('errors');
            if (is_array($flashErrors) && $flashErrors !== []) :
            ?>
                <ul class="list-inside list-disc rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-950">
                    <?php foreach ($flashErrors as $msg) : ?>
                        <li><?= esc(is_array($msg) ? implode(', ', $msg) : (string) $msg) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Tambah Kasus / Gejala</h2>
                <p class="mt-1 text-sm text-slate-500">Pilih pasien dan inputkan gejala klinis yang dialami.</p>

                <form action="<?= esc($formAction, 'attr') ?>" method="post" class="mt-8 space-y-8">
                    <?= csrf_field() ?>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <!-- Patient Selector -->
                        <div class="sm:col-span-2">
                            <label for="pasien_id" class="block text-sm font-medium text-slate-700">Pilih Pasien <span class="text-red-500">*</span></label>
                            <select name="pasien_id" id="pasien_id" required
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                                <option value="" data-usia="0">— Pilih Pasien —</option>
                                <?php foreach ($patients as $p) : ?>
                                    <option value="<?= esc($p['id'], 'attr') ?>" data-usia="<?= esc($p['usia'], 'attr') ?>" <?= $selectedPasien === $p['id'] ? 'selected' : '' ?>>
                                        <?= esc($p['nama']) ?> (<?= esc($p['usia']) ?> tahun)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Hidden Usia field needed by demam view partial/script -->
                        <input type="hidden" id="usia" name="usia_dummy" value="0">

                        <!-- Demam Fields Partial -->
                        <?= view('admin/partials/pasien_demam_fields', ['record' => null]) ?>
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
                    $radioClass = 'h-4 w-4 rounded-full border-slate-300 text-mint focus:ring-mint';
                    ?>

                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Gejala & tanda</h3>
                        <p class="mt-1 text-sm text-slate-500">Pilih Ya/Tidak untuk setiap poin.</p>

                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            <?php foreach ($symptoms as $key => $label) : ?>
                                <?php $val = yn_old($key, null); ?>
                                <fieldset class="rounded-2xl border border-slate-200 p-4">
                                    <legend class="px-1 text-sm font-medium text-slate-800"><?= esc($label) ?></legend>
                                    <div class="mt-2 flex items-center gap-6">
                                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                            <input type="radio" name="<?= esc($key, 'attr') ?>" value="1"
                                                   class="<?= esc($radioClass, 'attr') ?>"
                                                   <?= $val === '1' ? 'checked' : '' ?> required>
                                            Ya
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                            <input type="radio" name="<?= esc($key, 'attr') ?>" value="0"
                                                   class="<?= esc($radioClass, 'attr') ?>"
                                                   <?= $val === '0' ? 'checked' : '' ?> required>
                                            Tidak
                                        </label>
                                    </div>
                                </fieldset>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit" class="rounded-xl bg-mint px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-mint/25 hover:bg-mint-dark">
                            Simpan Kasus
                        </button>
                        <a href="<?= esc(site_url('admin/pasien'), 'attr') ?>"
                           class="rounded-xl border border-slate-200 px-6 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: Kategori Demam Info -->
        <div class="xl:col-span-3 md:col-span-1 order-3 xl:order-3 space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <!-- Referensi Kategori Demam -->
                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">Referensi Kategori Demam</h3>
                    
                    <!-- Info Box -->
                    <div class="flex items-center gap-3 rounded-2xl bg-gradient-to-r from-blue-50/60 to-indigo-50/60 border border-blue-100/80 p-3.5 text-xs text-slate-650 shadow-sm">
                        <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-blue-500/10 text-blue-600 shrink-0 mt-0.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="leading-relaxed pt-0.5 text-slate-700">Gunakan termometer agar hasil akurat</p>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Referensi Demam Anak-Anak -->
                        <div>
                            <h4 class="text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Kelompok Usia Anak-Anak (0–17 tahun)</h4>
                            <p class="text-xs text-slate-500 mb-3">Klasifikasi tingkat keparahan demam untuk kelompok usia anak-anak.</p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200 border border-slate-150 rounded-xl text-xs text-left">
                                    <thead class="bg-slate-50 text-slate-500 font-semibold">
                                        <tr>
                                            <th class="px-4 py-2 border-b">Kategori</th>
                                            <th class="px-4 py-2 border-b">Suhu (°C)</th>
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
                                            <th class="px-4 py-2 border-b">Kategori</th>
                                            <th class="px-4 py-2 border-b">Suhu (°C)</th>
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
</div>

<?= view('admin/partials/pasien_demam_script') ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var patientSelect = document.getElementById('pasien_id');
    var usiaInput = document.getElementById('usia');

    function updateUsiaValue() {
        if (!patientSelect || !usiaInput) return;
        var selectedOption = patientSelect.options[patientSelect.selectedIndex];
        var usia = selectedOption ? (selectedOption.getAttribute('data-usia') || 0) : 0;
        usiaInput.value = usia;
        usiaInput.dispatchEvent(new Event('input'));
    }

    if (patientSelect) {
        patientSelect.addEventListener('change', updateUsiaValue);
        // Run once initially
        updateUsiaValue();
    }
});
</script>
