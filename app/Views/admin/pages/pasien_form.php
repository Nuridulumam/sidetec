<?php
/** @var array<string, mixed>|null $record */
$isEdit     = $record !== null;
$formAction = $isEdit
    ? site_url('admin/pasien/' . esc($record['id'] ?? '') . '/update')
    : site_url('admin/pasien/store');
?>
<div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <?php
        $flashErrors = session()->getFlashdata('errors') ?? [];
        $nikError = $flashErrors['nik'] ?? null;
        $otherErrors = $flashErrors;
        unset($otherErrors['nik']);

        if (is_array($otherErrors) && $otherErrors !== []) :
        ?>
            <ul class="list-inside list-disc rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-950">
                <?php foreach ($otherErrors as $msg) : ?>
                    <li><?= esc(is_array($msg) ? implode(', ', $msg) : (string) $msg) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">
                <?= $isEdit ? 'Edit Pasien (Master Data)' : 'Tambah Pasien Baru' ?>
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                <?= $isEdit ? 'Perbarui informasi master data pasien di bawah ini.' : 'Isi formulir untuk mendaftarkan pasien baru ke master data.' ?>
            </p>

            <form action="<?= esc($formAction, 'attr') ?>" method="post" class="mt-8 space-y-6">
                <?= csrf_field() ?>

                <div class="grid gap-5 sm:grid-cols-2">
                    <!-- Nomor Rekam Medis (RM) -->
                    <div>
                        <label for="nomor_rm" class="block text-sm font-medium text-slate-700">Nomor RM <span class="text-red-500">*</span></label>
                        <input type="number" name="nomor_rm" id="nomor_rm" required min="1"
                               value="<?= esc(old('nomor_rm', $isEdit ? ($record['nomor_rm'] ?? '') : '')) ?>"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                               placeholder="Contoh: 100293">
                    </div>

                    <!-- NIK (16 Digit) -->
                    <div>
                        <label for="nik" class="block text-sm font-medium text-slate-700">NIK (16 Digit) <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" id="nik" 
                               value="<?= esc(old('nik', $isEdit ? ($record['nik'] ?? '') : '')) ?>"
                               class="mt-1.5 w-full rounded-xl border <?= $nikError ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : 'border-slate-200 focus:border-mint focus:ring-mint/30' ?> px-4 py-3 text-slate-900 shadow-sm focus:outline-none focus:ring-2"
                               placeholder="16 digit angka NIK"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <p id="nik-error" class="mt-1.5 text-xs text-red-600 font-medium"><?= $nikError ? esc(is_array($nikError) ? implode(', ', $nikError) : (string) $nikError) : '' ?></p>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="sm:col-span-2">
                        <label for="nama" class="block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" required minlength="3" maxlength="191"
                               value="<?= esc(old('nama', $isEdit ? ($record['nama'] ?? '') : '')) ?>"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                               placeholder="Nama lengkap pasien">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                               value="<?= esc(old('tanggal_lahir', $isEdit ? ($record['tanggal_lahir'] ?? '') : '')) ?>"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                    </div>

                    <!-- Usia -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Usia (Tahun) <span class="text-red-500">*</span></label>
                        <input type="number" id="usia_display" disabled
                               value="<?= esc(old('usia', $isEdit ? (string) ($record['usia'] ?? '') : '')) ?>"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-500 shadow-sm cursor-not-allowed"
                               placeholder="Otomatis dari tanggal lahir">
                        <input type="hidden" name="usia" id="usia"
                               value="<?= esc(old('usia', $isEdit ? (string) ($record['usia'] ?? '') : '')) ?>">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                            <option value="">— Pilih Jenis Kelamin —</option>
                            <option value="L" <?= old('jenis_kelamin', $isEdit ? ($record['jenis_kelamin'] ?? '') : '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= old('jenis_kelamin', $isEdit ? ($record['jenis_kelamin'] ?? '') : '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-slate-700">Nomor Telepon</label>
                        <input type="text" name="telepon" id="telepon" maxlength="32"
                               value="<?= esc(old('telepon', $isEdit ? ($record['telepon'] ?? '') : '')) ?>"
                               class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                               placeholder="Contoh: 08123456789">
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-slate-700">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="3"
                                  class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                                  placeholder="Alamat tempat tinggal pasien"><?= esc(old('alamat', $isEdit ? ($record['alamat'] ?? '') : '')) ?></textarea>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-slate-100">
                    <button type="submit" class="rounded-xl bg-mint px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-mint/25 hover:bg-mint-dark">
                        <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Pasien' ?>
                    </button>
                    <a href="<?= esc(site_url('admin/pasien'), 'attr') ?>"
                       class="rounded-xl border border-slate-200 px-6 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var dobInput = document.getElementById('tanggal_lahir');
    var usiaDisplay = document.getElementById('usia_display');
    var usiaHidden = document.getElementById('usia');

    if (!dobInput || !usiaDisplay || !usiaHidden) return;

    function calculateAge() {
        var dobVal = dobInput.value;
        if (!dobVal) {
            usiaDisplay.value = '';
            usiaHidden.value = '';
            return;
        }

        var dob = new Date(dobVal);
        var today = new Date();
        
        if (isNaN(dob.getTime())) {
            usiaDisplay.value = '';
            usiaHidden.value = '';
            return;
        }

        var age = today.getFullYear() - dob.getFullYear();
        var m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        if (age < 0) age = 0;

        usiaDisplay.value = age;
        usiaHidden.value = age;
    }

    dobInput.addEventListener('change', calculateAge);
    dobInput.addEventListener('input', calculateAge);
    
    if (dobInput.value) {
        calculateAge();
    }

    // NIK validation on blur
    var nikInput = document.getElementById('nik');
    var nikErrorEl = document.getElementById('nik-error');

    if (nikInput && nikErrorEl) {
        nikInput.addEventListener('blur', function() {
            var val = nikInput.value.trim();
            var error = '';

            if (val === '') {
                error = 'NIK wajib diisi.';
            } else if (!/^\d+$/.test(val)) {
                error = 'NIK hanya boleh berupa angka.';
            } else if (val.length !== 16) {
                error = 'NIK harus 16 digit.';
            }

            if (error) {
                nikErrorEl.textContent = error;
                nikInput.classList.remove('border-slate-200', 'focus:border-mint', 'focus:ring-mint/30');
                nikInput.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-200');
            } else {
                nikErrorEl.textContent = '';
                nikInput.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-200');
                nikInput.classList.add('border-slate-200', 'focus:border-mint', 'focus:ring-mint/30');
            }
        });

        // Clear error styling on input if it becomes valid
        nikInput.addEventListener('input', function() {
            var val = nikInput.value.trim();
            if (val.length === 16 && /^\d+$/.test(val)) {
                nikErrorEl.textContent = '';
                nikInput.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-200');
                nikInput.classList.add('border-slate-200', 'focus:border-mint', 'focus:ring-mint/30');
            }
        });
    }
});
</script>
