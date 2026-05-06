<?php
/** @var array<string, mixed>|null $record */
$isEdit     = $record !== null;
$formAction = $isEdit ? site_url('admin/users/' . (int) $record['id'] . '/update') : site_url('admin/users/store');

$activeVal = old('is_active');
if ($activeVal === null) {
    $activeVal = $isEdit ? (string) ($record['is_active'] ?? '1') : '1';
}
$isActiveChecked = $activeVal === '1' || $activeVal === 1 || $activeVal === true;

$roleVal = old('role', $isEdit ? ($record['role'] ?? 'operator') : 'operator');
?>
<div class="mx-auto max-w-xl space-y-6">
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
        <h2 class="text-lg font-semibold text-slate-900"><?= $isEdit ? 'Edit pengguna' : 'Tambah pengguna' ?></h2>
        <p class="mt-1 text-sm text-slate-500"><?= $isEdit ? 'Perbarui data pengguna di bawah ini.' : 'Isi formulir untuk menambah pengguna baru.' ?></p>

        <form action="<?= esc($formAction, 'attr') ?>" method="post" class="mt-8 space-y-5">
            <?= csrf_field() ?>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" id="email" required value="<?= esc(old('email', $isEdit ? ($record['email'] ?? '') : '')) ?>"
                       class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">
                    Kata sandi <?= $isEdit ? '<span class="font-normal text-slate-400">(kosongkan jika tidak diubah)</span>' : '' ?>
                </label>
                <input type="password" name="password" id="password" autocomplete="new-password"
                       class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                       <?= $isEdit ? '' : 'required minlength="8"' ?>>
            </div>

            <div>
                <label for="full_name" class="block text-sm font-medium text-slate-700">Nama lengkap</label>
                <input type="text" name="full_name" id="full_name" required minlength="3" maxlength="150"
                       value="<?= esc(old('full_name', $isEdit ? ($record['full_name'] ?? '') : '')) ?>"
                       class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-slate-700">Role</label>
                <?php
                $roleOptions = [
                    'admin'          => 'Admin',
                    'operator'       => 'Operator',
                    'superadmin'     => 'Superadmin',
                    'petugas poli'   => 'Petugas poli',
                    'petugas sik'    => 'Petugas sik',
                ];
                ?>
                <select name="role" id="role" required
                        class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                    <?php foreach ($roleOptions as $value => $label) : ?>
                        <option value="<?= esc($value, 'attr') ?>" <?= (string) $roleVal === (string) $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 rounded border-slate-300 text-mint focus:ring-mint" <?= $isActiveChecked ? 'checked' : '' ?>>
                <label for="is_active" class="text-sm font-medium text-slate-700">Akun aktif</label>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="rounded-xl bg-mint px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-mint/25 hover:bg-mint-dark">
                    <?= $isEdit ? 'Simpan perubahan' : 'Simpan' ?>
                </button>
                <a href="<?= esc(site_url('admin/users'), 'attr') ?>" class="rounded-xl border border-slate-200 px-6 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
            </div>
        </form>
    </div>
</div>
