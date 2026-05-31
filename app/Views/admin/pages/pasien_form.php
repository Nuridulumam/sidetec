<?php
/** @var array<string, mixed>|null $record */
$isEdit     = $record !== null;
$formAction = $isEdit
    ? site_url('admin/pasien/' . (int) $record['id'] . '/update')
    : site_url('admin/pasien/store');

function yn_old(string $key, ?array $record): string
{
    $val = old($key);
    if ($val === null) {
        $val = $record !== null ? (string) ($record[$key] ?? '0') : '0';
    }
    return ((string) $val === '1') ? '1' : '0';
}
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
            <?= $isEdit ? 'Edit pasien' : 'Tambah pasien' ?>
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            <?= $isEdit ? 'Perbarui data pasien di bawah ini.' : 'Isi formulir untuk menambah pasien baru.' ?>
        </p>

        <form action="<?= esc($formAction, 'attr') ?>" method="post" class="mt-8 space-y-8">
            <?= csrf_field() ?>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm font-medium text-slate-700">Nama lengkap</label>
                    <input type="text" name="nama" id="nama" required minlength="3" maxlength="191"
                           value="<?= esc(old('nama', $isEdit ? ($record['nama'] ?? '') : '')) ?>"
                           class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                </div>

                <div>
                    <label for="usia" class="block text-sm font-medium text-slate-700">Usia</label>
                    <input type="number" name="usia" id="usia" required min="1" max="150"
                           value="<?= esc(old('usia', $isEdit ? (string) ($record['usia'] ?? '') : '')) ?>"
                           class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                </div>

                <?= view('admin/partials/pasien_demam_fields', ['record' => $record]) ?>
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
                        <?php $val = yn_old($key, $record); ?>
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

                <div id="pk-desc-wrap" class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <label for="penurunan_kesadaran_deskripsi" class="block text-sm font-medium text-slate-700">
                        Deskripsi penurunan kesadaran
                        <span class="font-normal text-slate-500">(muncul jika pilih “Ya”)</span>
                    </label>
                    <textarea name="penurunan_kesadaran_deskripsi" id="penurunan_kesadaran_deskripsi" rows="3"
                              class="mt-1.5 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                              placeholder="Contoh: mengantuk berat, sulit dibangunkan, bingung..."><?= esc(old('penurunan_kesadaran_deskripsi', $isEdit ? (string) ($record['penurunan_kesadaran_deskripsi'] ?? '') : '')) ?></textarea>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="rounded-xl bg-mint px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-mint/25 hover:bg-mint-dark">
                    <?= $isEdit ? 'Simpan perubahan' : 'Simpan' ?>
                </button>
                <a href="<?= esc(site_url('admin/pasien'), 'attr') ?>"
                   class="rounded-xl border border-slate-200 px-6 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= view('admin/partials/pasien_demam_script') ?>
<?= view('admin/partials/pasien_pk_desc_script') ?>
