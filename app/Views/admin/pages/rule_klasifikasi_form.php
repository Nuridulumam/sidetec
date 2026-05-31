<?php
/** @var array<string, mixed>|null $record */
$isEdit     = $record !== null;
$formAction = $isEdit
    ? site_url('admin/rule-klasifikasi/' . (int) $record['id'] . '/update')
    : site_url('admin/rule-klasifikasi/store');

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
            Atur kondisi rule dan hasil klasifikasi.
        </p>

        <form action="<?= esc($formAction, 'attr') ?>" method="post" class="mt-8 space-y-8">
            <?= csrf_field() ?>

            <div>
                <h3 class="text-sm font-semibold text-slate-900">Rule</h3>
                <p class="mt-1 text-sm text-slate-500">Kondisi yang harus dipenuhi.</p>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="bradikardia_relatif" class="block text-sm font-medium text-slate-700">
                            Bradikardia relatif <span class="text-red-600">*</span>
                        </label>
                        <input type="number" name="bradikardia_relatif" id="bradikardia_relatif"
                               required step="0.01"
                               value="<?= esc(rule_opt_old('bradikardia_relatif', $record)) ?>"
                               class="<?= esc($inputClass, 'attr') ?>">
                    </div>

                    <div>
                        <label for="demam_pagi" class="block text-sm font-medium text-slate-700">
                            Demam pagi
                        </label>
                        <input type="text" name="demam_pagi" id="demam_pagi" maxlength="191"
                               value="<?= esc(rule_opt_old('demam_pagi', $record)) ?>"
                               class="<?= esc($inputClass, 'attr') ?>"
                               placeholder="Opsional">
                    </div>

                    <div>
                        <label for="demam_sore" class="block text-sm font-medium text-slate-700">
                            Demam sore
                        </label>
                        <input type="text" name="demam_sore" id="demam_sore" maxlength="191"
                               value="<?= esc(rule_opt_old('demam_sore', $record)) ?>"
                               class="<?= esc($inputClass, 'attr') ?>"
                               placeholder="Opsional">
                    </div>

                    <?php
                    $enums = [
                        'mual'                => 'Mual',
                        'penurunan_kesadaran' => 'Penurunan kesadaran',
                    ];
                    foreach ($enums as $key => $label) :
                        $sel = rule_opt_old($key, $record);
                    ?>
                        <div>
                            <label for="<?= esc($key, 'attr') ?>" class="block text-sm font-medium text-slate-700">
                                <?= esc($label) ?>
                            </label>
                            <select name="<?= esc($key, 'attr') ?>" id="<?= esc($key, 'attr') ?>"
                                    class="<?= esc($inputClass, 'attr') ?>">
                                <option value="" <?= $sel === '' ? 'selected' : '' ?>>— Tidak diatur —</option>
                                <option value="1" <?= $sel === '1' ? 'selected' : '' ?>>Ya</option>
                                <option value="0" <?= $sel === '0' ? 'selected' : '' ?>>Tidak</option>
                            </select>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-900">Hasil</h3>
                <p class="mt-1 text-sm text-slate-500">Output klasifikasi jika rule cocok.</p>

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
