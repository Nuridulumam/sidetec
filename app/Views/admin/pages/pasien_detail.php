<?php /** @var array<string, mixed> $row */ ?>
<?php
$demamCfg = config('DemamKlasifikasi');
$usia     = (int) ($row['usia'] ?? 0);
$kelompok = $usia > 0 ? $demamCfg->kelompokUsiaLabel($usia) : '—';

function demam_detail(string $label, int $usia, $demamCfg): string
{
    if ($label === '' || $usia <= 0) {
        return '—';
    }
    $rentang = $demamCfg->rentangByLabel($label, $usia);

    return esc($label) . ' <span class="text-slate-500">(' . esc($rentang) . ')</span>';
}
?>
<div class="mx-auto max-w-3xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Detail pasien</h2>
            <p class="text-sm text-slate-500">ID: <?= esc((string) ($row['id'] ?? '')) ?></p>
        </div>
        <div class="flex flex-wrap gap-2">
            <?php if (in_array(session()->get('admin_role'), ['perawat'], true)) : ?>
                <a href="<?= esc(site_url('admin/pasien/' . (int) ($row['id'] ?? 0) . '/edit'), 'attr') ?>"
                   class="rounded-xl border border-mint/40 bg-mint/10 px-4 py-2 text-sm font-semibold text-mint-dark hover:bg-mint/20">Edit</a>
            <?php endif; ?>
            <a href="<?= esc(site_url('admin/pasien'), 'attr') ?>"
               class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <!-- Diagnosis Banner -->
        <?php
        $diag = $row['diagnosa'] ?? 'Tidak terklasifikasi';
        if ($diag === 'Suspect Typhoid Fever') {
            $bannerCls = 'bg-rose-50 border-b border-rose-100 text-rose-900';
            $badgeCls = 'bg-rose-600 text-white';
            $icon = '<svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
            $statusText = 'Suspect Typhoid Fever';
            $descriptionText = 'Gejala pasien cocok dengan klasifikasi Suspect Typhoid Fever.';
        } elseif ($diag === 'Non Suspect Typhoid Fever') {
            $bannerCls = 'bg-emerald-50 border-b border-emerald-100 text-emerald-900';
            $badgeCls = 'bg-emerald-600 text-white';
            $icon = '<svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            $statusText = 'Non Suspect Typhoid Fever';
            $descriptionText = 'Gejala pasien cocok dengan klasifikasi Non Suspect Typhoid Fever.';
        } else {
            $bannerCls = 'bg-slate-50 border-b border-slate-100 text-slate-900';
            $badgeCls = 'bg-slate-600 text-white';
            $icon = '<svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            $statusText = 'Tidak Terklasifikasi';
            $descriptionText = 'Gejala pasien tidak cocok dengan aturan klasifikasi mana pun.';
        }
        ?>
        <div class="flex items-center gap-4 p-6 <?= $bannerCls ?>">
            <div class="rounded-xl bg-white p-2 shadow-sm">
                <?= $icon ?>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Hasil Diagnosa Otomatis</p>
                <div class="flex items-center gap-2 mt-1">
                    <h3 class="text-lg font-bold"><?= esc($statusText) ?></h3>
                </div>
                <p class="text-sm mt-0.5 opacity-90"><?= esc($descriptionText) ?></p>
            </div>
        </div>

        <div class="grid gap-0 divide-y divide-slate-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
            <div class="p-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Identitas</p>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Nama lengkap</dt>
                        <dd class="font-semibold text-slate-900"><?= esc((string) ($row['nama'] ?? '')) ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Usia</dt>
                        <dd class="text-slate-900">
                            <?= esc((string) ($row['usia'] ?? '—')) ?> tahun
                            <?php if ($usia > 0) : ?>
                                <span class="mt-1 block text-xs text-slate-500"><?= esc($kelompok) ?></span>
                            <?php endif; ?>
                        </dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Demam pagi</dt>
                        <dd class="text-slate-900"><?= demam_detail((string) ($row['demam_pagi'] ?? ''), $usia, $demamCfg) ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <dt class="text-slate-500">Demam sore</dt>
                        <dd class="text-slate-900"><?= demam_detail((string) ($row['demam_sore'] ?? ''), $usia, $demamCfg) ?></dd>
                    </div>
                </dl>
            </div>

            <div class="p-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Gejala & tanda</p>
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
                function yn_badge($v): string {
                    $on = ! empty($v);
                    $cls = $on ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700';
                    $txt = $on ? 'Ya' : 'Tidak';
                    return '<span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ' . $cls . '">' . $txt . '</span>';
                }
                ?>
                <dl class="mt-4 space-y-3 text-sm">
                    <?php foreach ($symptoms as $k => $label) : ?>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-slate-500"><?= esc($label) ?></dt>
                            <dd class="text-slate-900"><?= yn_badge($row[$k] ?? 0) ?></dd>
                        </div>

                    <?php endforeach; ?>
                </dl>
            </div>
        </div>

        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-xs text-slate-500">
            Dibuat: <?= esc((string) ($row['created_at'] ?? '—')) ?> · Diperbarui: <?= esc((string) ($row['updated_at'] ?? '—')) ?>
        </div>
    </div>
</div>

