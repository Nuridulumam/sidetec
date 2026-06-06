<?php
/** @var array<string, mixed>|null $record */
$isEdit     = $record !== null;
$formAction = $isEdit
    ? site_url('admin/rule-klasifikasi/' . (int) $record['id'] . '/update')
    : site_url('admin/rule-klasifikasi/store');

$demamCfg = config('DemamKlasifikasi');

function rule_opt_old(string $key, ?array $record): string
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

$inputClass = 'mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 '
    . 'text-slate-900 shadow-sm focus:border-mint focus:outline-none '
    . 'focus:ring-2 focus:ring-mint/30';
?>
<div class="mx-auto max-w-3xl space-y-6">
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
        <h2 class="text-lg font-semibold text-slate-900">
            <?= $isEdit ? 'Edit rule klasifikasi' : 'Tambah rule klasifikasi' ?>
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Atur kondisi rule dan hasil klasifikasi di bawah ini.
        </p>

        <form action="<?= esc($formAction, 'attr') ?>" method="post" class="mt-8 space-y-8">
            <?= csrf_field() ?>

            <div>
                <h3 class="text-sm font-semibold text-slate-900">Kondisi Usia</h3>
                <p class="mt-1 text-sm text-slate-500">Tentukan syarat usia untuk rule ini (opsional).</p>
                <div class="mt-5 max-w-xs">
                    <label for="usia" class="block text-sm font-medium text-slate-700">Usia (tahun)</label>
                    <input type="number" name="usia" id="usia" min="1" max="150"
                           value="<?= esc(old('usia', $isEdit && isset($record['usia']) ? (string)$record['usia'] : '')) ?>"
                           class="<?= esc($inputClass, 'attr') ?>"
                           placeholder="Semua Usia">
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-900">Kondisi Demam</h3>
                <p class="mt-1 text-sm text-slate-500">Pilih kategori demam pagi dan sore yang harus dipenuhi (opsional).</p>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <?php foreach (['demam_pagi' => 'Demam pagi', 'demam_sore' => 'Demam sore'] as $field => $lbl) : ?>
                        <?php $cur = rule_opt_old($field, $record); ?>
                        <div>
                            <label for="<?= esc($field, 'attr') ?>" class="block text-sm font-medium text-slate-700">
                                <?= esc($lbl) ?>
                            </label>
                            <select name="<?= esc($field, 'attr') ?>" id="<?= esc($field, 'attr') ?>"
                                    class="<?= esc($inputClass, 'attr') ?>">
                                <option value="" <?= $cur === '' ? 'selected' : '' ?>>— Tidak diatur —</option>
                                <?php foreach ($demamCfg->keys as $key) : ?>
                                    <?php $opt = $demamCfg->label[$key]; ?>
                                    <option value="<?= esc($opt, 'attr') ?>" <?= $cur === $opt ? 'selected' : '' ?>>
                                        <?= esc($opt) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-900">Gejala & tanda</h3>
                <p class="mt-1 text-sm text-slate-500">Pilih kondisi gejala yang harus dipenuhi (Ya / Tidak / Tidak diatur).</p>

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

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <?php foreach ($symptoms as $key => $label) : ?>
                        <?php $val = rule_opt_old($key, $record); ?>
                        <fieldset class="rounded-2xl border border-slate-200 p-4">
                            <legend class="px-1 text-sm font-medium text-slate-800"><?= esc($label) ?></legend>
                            <div class="mt-2 flex flex-wrap items-center gap-4">
                                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="<?= esc($key, 'attr') ?>" value=""
                                           class="<?= esc($radioClass, 'attr') ?>"
                                           <?= $val === '' ? 'checked' : '' ?> required>
                                    Tidak diatur
                                </label>
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

            <div>
                <h3 class="text-sm font-semibold text-slate-900">Hasil</h3>
                <p class="mt-1 text-sm text-slate-500">Output hasil klasifikasi.</p>

                <div class="mt-5">
                    <label for="hasil" class="block text-sm font-medium text-slate-700">
                        Hasil <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="hasil" id="hasil" required maxlength="191"
                           value="<?= esc(rule_opt_old('hasil', $record)) ?>"
                           class="<?= esc($inputClass, 'attr') ?>"
                           placeholder="Contoh: Tifoid, Bukan tifoid">
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit"
                        class="rounded-xl bg-mint px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-mint/25 hover:bg-mint-dark">
                    <?= $isEdit ? 'Simpan perubahan' : 'Simpan' ?>
                </button>
                <a href="<?= esc(site_url('admin/rule-klasifikasi'), 'attr') ?>"
                   class="rounded-xl border border-slate-200 px-6 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
