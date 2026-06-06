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
</div>
