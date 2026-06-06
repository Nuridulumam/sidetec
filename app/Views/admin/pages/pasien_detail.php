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
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Detail pasien</h2>
            <p class="text-sm text-slate-500">ID: <?= esc((string) ($row['id'] ?? '')) ?></p>
        </div>
        <div class="flex flex-wrap gap-2">
            <?php if (in_array(session()->get('admin_role'), ['petugas poli', 'superadmin'], true)) : ?>
                <a href="<?= esc(site_url('admin/pasien/' . (int) ($row['id'] ?? 0) . '/edit'), 'attr') ?>"
                   class="rounded-xl border border-mint/40 bg-mint/10 px-4 py-2 text-sm font-semibold text-mint-dark hover:bg-mint/20">Edit</a>
            <?php endif; ?>
            <a href="<?= esc(site_url('admin/pasien'), 'attr') ?>"
               class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
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
                        <?php if ($k === 'penurunan_kesadaran' && ! empty($row['penurunan_kesadaran'])) : ?>
                            <?php $desc = (string) ($row['penurunan_kesadaran_deskripsi'] ?? ''); ?>
                            <?php if (trim($desc) !== '') : ?>
                                <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Deskripsi</p>
                                    <p class="mt-2 whitespace-pre-wrap"><?= esc($desc) ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </dl>
            </div>
        </div>

        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-xs text-slate-500">
            Dibuat: <?= esc((string) ($row['created_at'] ?? '—')) ?> · Diperbarui: <?= esc((string) ($row['updated_at'] ?? '—')) ?>
        </div>
    </div>
</div>

