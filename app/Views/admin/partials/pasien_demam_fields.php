<?php
/** @var array<string, mixed>|null $record */
$demamCfg = config('DemamKlasifikasi');
$inputCls = 'mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 '
    . 'text-slate-900 shadow-sm focus:border-mint focus:outline-none '
    . 'focus:ring-2 focus:ring-mint/30';

function demam_old(string $key, ?array $record): string
{
    $val = old($key);
    if ($val !== null) {
        return (string) $val;
    }
    if ($record === null) {
        return '';
    }
    return (string) ($record[$key] ?? '');
}

$demamPagiVal = demam_old('demam_pagi', $record);
$demamSoreVal = demam_old('demam_sore', $record);
?>
<div class="sm:col-span-2">
    <div id="kelompok-usia-wrap"
         class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
        <span class="font-medium text-slate-900">Kelompok usia:</span>
        <span id="kelompok-usia-label" class="text-slate-600">
            Isi usia terlebih dahulu
        </span>
    </div>
</div>

<?php foreach (['demam_pagi' => 'Demam pagi', 'demam_sore' => 'Demam sore'] as $field => $lbl) : ?>
    <?php $cur = $field === 'demam_pagi' ? $demamPagiVal : $demamSoreVal; ?>
    <div>
        <label for="<?= esc($field, 'attr') ?>" class="block text-sm font-medium text-slate-700">
            <?= esc($lbl) ?> <span class="text-red-600">*</span>
        </label>
        <select name="<?= esc($field, 'attr') ?>" id="<?= esc($field, 'attr') ?>"
                required class="<?= esc($inputCls, 'attr') ?> demam-select">
            <option value="">— Pilih kategori —</option>
            <?php foreach ($demamCfg->keys as $key) : ?>
                <?php $opt = $demamCfg->label[$key]; ?>
                <option value="<?= esc($opt, 'attr') ?>" <?= $cur === $opt ? 'selected' : '' ?>>
                    <?= esc($opt) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p id="<?= esc($field, 'attr') ?>-hint"
           class="mt-2 text-xs text-slate-500 demam-hint"></p>
    </div>
<?php endforeach; ?>

<div class="sm:col-span-2">
    <div class="rounded-2xl border border-slate-200 bg-white p-4">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Referensi suhu (sesuai kelompok usia)
        </p>
        <ul id="demam-ref-list" class="mt-3 space-y-2 text-sm text-slate-700"></ul>
    </div>
</div>

<script type="application/json" id="demam-data">
<?= json_encode([
    'label'  => $demamCfg->label,
    'anak'   => $demamCfg->anak,
    'dewasa' => $demamCfg->dewasa,
    'keys'   => $demamCfg->keys,
], JSON_UNESCAPED_UNICODE) ?>
</script>
