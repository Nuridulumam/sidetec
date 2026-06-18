<?php
/** @var array<string, mixed> $row */
/** @var array<string, mixed>[] $history */
$demamCfg = config('DemamKlasifikasi');
$usia     = (int) ($row['usia'] ?? 0);
$kelompok = $usia > 0 ? $demamCfg->kelompokUsiaLabel($usia) : '—';

function yn_badge($v): string {
    return ! empty($v) ? 'Ya' : 'Tidak';
}
?>
<div class="mx-auto max-w-5xl space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Detail Pasien (Master Data)</h2>
            <p class="text-sm text-slate-500">ID Pasien: <?= esc((string) ($row['pasien_id'] ?? '')) ?></p>
        </div>
        <div class="flex flex-wrap gap-2">
            <?php if (in_array(session()->get('admin_role'), ['perawat', 'admin'], true)) : ?>
                <a href="<?= esc(site_url('admin/gejala/create?pasien_id=' . esc($row['id'] ?? '')), 'attr') ?>"
                   class="rounded-xl border border-emerald-500/40 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">Tambah Kasus</a>
                <a href="<?= esc(site_url('admin/pasien/' . esc($row['id'] ?? '') . '/edit'), 'attr') ?>"
                   class="rounded-xl border border-mint/40 bg-mint/10 px-4 py-2 text-sm font-semibold text-mint-dark hover:bg-mint/20">Edit Identitas</a>
            <?php endif; ?>
            <a href="<?= esc(site_url('admin/pasien'), 'attr') ?>"
               class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>

    <!-- Latest Diagnosis Status (if exists) -->
    <?php
    $latest = !empty($history) ? $history[0] : null;
    if ($latest) :
        $diag = $latest['diagnosa'] ?? 'Tidak terklasifikasi';
        if ($diag === 'Suspect Typhoid Fever') {
            $bannerCls = 'bg-rose-50 border border-rose-100 text-rose-900';
            $icon = '<svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
            $statusText = 'Suspect Typhoid Fever';
            $descriptionText = 'Pemeriksaan terbaru mendeteksi gejala yang cocok dengan klasifikasi Suspect Typhoid.';
        } elseif ($diag === 'Non Suspect Typhoid Fever') {
            $bannerCls = 'bg-emerald-50 border border-emerald-100 text-emerald-900';
            $icon = '<svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            $statusText = 'Non Suspect Typhoid Fever';
            $descriptionText = 'Pemeriksaan terbaru mendeteksi gejala yang cocok dengan klasifikasi Non Suspect Typhoid.';
        } else {
            $bannerCls = 'bg-slate-50 border border-slate-150 text-slate-900';
            $icon = '<svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            $statusText = 'Tidak Terklasifikasi';
            $descriptionText = 'Pemeriksaan terbaru tidak cocok dengan aturan klasifikasi mana pun.';
        }
    ?>
        <div class="flex items-center gap-4 p-6 rounded-3xl <?= $bannerCls ?> shadow-sm">
            <div class="rounded-xl bg-white p-2 shadow-sm">
                <?= $icon ?>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Hasil Klasifikasi Kasus Terakhir (<?= date('d M Y H:i', strtotime($latest['created_at'])) ?>)</p>
                <div class="flex items-center gap-2 mt-1">
                    <h3 class="text-lg font-bold"><?= esc($statusText) ?></h3>
                </div>
                <p class="text-sm mt-0.5 opacity-90"><?= esc($descriptionText) ?></p>
            </div>
        </div>
    <?php else : ?>
        <div class="flex items-center gap-4 p-6 rounded-3xl bg-amber-50 border border-amber-100 text-amber-900 shadow-sm">
            <div class="rounded-xl bg-white p-2 shadow-sm">
                <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Hasil Klasifikasi</p>
                <h3 class="text-lg font-bold mt-1">Belum Ada Pemeriksaan</h3>
                <p class="text-sm mt-0.5 opacity-90">Pasien ini belum memiliki riwayat pemeriksaan gejala klinis.</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Patient Master Info Card -->
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">Identitas Master Pasien</h3>
        </div>
        <div class="p-6 grid gap-6 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-150">
            <div class="space-y-4">
                <dl class="space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Nama Lengkap</dt>
                        <dd class="font-semibold text-slate-900"><?= esc((string) ($row['nama'] ?? '—')) ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Nomor RM</dt>
                        <dd class="font-semibold text-slate-900"><?= esc((string) ($row['nomor_rm'] ?? '—')) ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">NIK (16 Digit)</dt>
                        <dd class="font-semibold text-slate-900"><?= esc((string) ($row['nik'] ?? '—')) ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Tanggal Lahir</dt>
                        <dd class="text-slate-900"><?= isset($row['tanggal_lahir']) ? date('d-m-Y', strtotime($row['tanggal_lahir'])) : '—' ?></dd>
                    </div>
                </dl>
            </div>
            <div class="space-y-4 pt-4 md:pt-0 md:pl-6">
                <dl class="space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Usia</dt>
                        <dd class="text-slate-900">
                            <?= esc((string) ($row['usia'] ?? '—')) ?> tahun
                            <span class="block text-xs text-slate-500 mt-0.5">(<?= esc($kelompok) ?>)</span>
                        </dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Jenis Kelamin</dt>
                        <dd class="text-slate-900"><?= ($row['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Telepon</dt>
                        <dd class="text-slate-900"><?= esc((string) ($row['telepon'] ?? '—')) ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Alamat</dt>
                        <dd class="text-slate-900 text-right"><?= esc((string) ($row['alamat'] ?? '—')) ?></dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Symptoms History List -->
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wide">Riwayat Pemeriksaan Kasus / Gejala</h3>
            <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600"><?= count($history) ?> kasus</span>
        </div>
        <div class="p-6">
            <?php if (empty($history)) : ?>
                <div class="text-center py-8">
                    <p class="text-sm text-slate-500">Belum ada riwayat pemeriksaan gejala klinis.</p>
                    <?php if (in_array(session()->get('admin_role'), ['perawat', 'admin'], true)) : ?>
                        <a href="<?= esc(site_url('admin/gejala/create?pasien_id=' . esc($row['id'] ?? '')), 'attr') ?>"
                           class="mt-4 inline-flex items-center gap-2 rounded-xl bg-mint px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-mint-dark">
                            Tambah Pemeriksaan Pertama
                        </a>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="space-y-6">
                    <?php foreach ($history as $idx => $h) : ?>
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                            <!-- Case Header -->
                            <div class="bg-slate-50 px-5 py-4 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-700">Kasus #<?= count($history) - $idx ?></span>
                                    <span class="text-xs text-slate-500 font-medium">· <?= date('d M Y H:i', strtotime($h['created_at'])) ?></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <?php
                                    $diag = $h['diagnosa'] ?? 'Tidak terklasifikasi';
                                    if ($diag === 'Suspect Typhoid Fever') {
                                        echo '<span class="inline-flex rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-bold text-rose-800">Suspect Typhoid Fever</span>';
                                    } elseif ($diag === 'Non Suspect Typhoid Fever') {
                                        echo '<span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Non Suspect Typhoid Fever</span>';
                                    } else {
                                        echo '<span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">Tidak terklasifikasi</span>';
                                    }
                                    ?>
                                    <?php if (in_array(session()->get('admin_role'), ['perawat', 'admin'], true)) : ?>
                                        <form action="<?= esc(site_url('admin/gejala/' . esc($h['id'] ?? '') . '/delete'), 'attr') ?>" method="post" class="inline"
                                               onsubmit="return confirm('Hapus riwayat kasus/gejala ini?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="rounded-lg p-1.5 text-red-500 hover:bg-red-50 hover:text-red-700">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Case Details -->
                            <div class="p-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div class="border-r-2  border-slate-100 pr-4">
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Demam</p>
                                    <dl class="mt-2 text-xs space-y-1">
                                        <div class="flex justify-between border-b border-slate-100 pb-1">
                                            <dt class="text-slate-500">Demam Pagi</dt>
                                            <dd class="font-medium text-slate-900"><?= esc($h['demam_pagi'] ?? '—') ?></dd>
                                        </div>
                                        <div class="flex justify-between pt-1">
                                            <dt class="text-slate-500">Demam Sore</dt>
                                            <dd class="font-medium text-slate-900"><?= esc($h['demam_sore'] ?? '—') ?></dd>
                                        </div>
                                    </dl>
                                </div>
                                
                                <div class="sm:col-span-2 lg:col-span-2">
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Gejala Tambahan</p>
                                    <div class="mt-2 flex flex-wrap gap-1.5">
                                        <?php
                                        $symptomList = [
                                            'sakit_kepala'        => 'Sakit Kepala',
                                            'nyeri_otot'          => 'Nyeri Otot',
                                            'mual'                => 'Mual',
                                            'muntah'              => 'Muntah',
                                            'nyeri_perut'         => 'Nyeri Perut',
                                            'diare'               => 'Diare',
                                            'penurunan_kesadaran' => 'Penurunan Kesadaran',
                                            'bradikardia_relatif' => 'Bradikardia Relatif',
                                            'lemas'               => 'Lemas',
                                        ];
                                        foreach ($symptomList as $key => $lbl) :
                                            $yes = (int)($h[$key] ?? 0) === 1;
                                            $badgeCls = $yes ? 'bg-amber-100 text-amber-800 font-semibold border-amber-200' : 'bg-slate-50 text-slate-400 border-slate-100';
                                        ?>
                                            <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs <?= $badgeCls ?>">
                                                <?= esc($lbl) ?>: <?= $yes ? 'Ya' : 'Tidak' ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="border-t border-slate-150 bg-slate-50 px-6 py-4 text-xs text-slate-500 flex justify-between">
            <span>Daftar identitas dibuat: <?= esc((string) ($row['created_at'] ?? '—')) ?></span>
            <span>Terakhir diperbarui: <?= esc((string) ($row['updated_at'] ?? '—')) ?></span>
        </div>
    </div>
</div>
