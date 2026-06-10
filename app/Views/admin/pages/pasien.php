<?php
$activeFiltersCount = 0;
foreach ($filters ?? [] as $k => $v) {
    if ($v !== null && trim((string)$v) !== '') {
        $activeFiltersCount++;
    }
}
$demamCfg = config('DemamKlasifikasi');
?>
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Daftar pasien</h2>
            <p class="text-sm text-slate-500"><?= isset($pager) ? esc((string) $pager->getTotal()) : count($rows ?? []) ?> entri</p>
        </div>
        <form method="get" action="<?= current_url() ?>" class="flex flex-wrap items-center gap-2">
            <!-- Search Nama (Outside, Left of Filter Button) -->
            <div class="relative">
                <input type="text" name="nama" value="<?= esc($filters['nama'] ?? '') ?>" placeholder="Cari nama..."
                       class="w-48 sm:w-64 rounded-xl border border-slate-200 pl-10 pr-4 py-2.5 text-sm text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Filter Button -->
            <button type="button" id="btn-filter"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                <svg class="h-5 w-5 text-slate-505" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
                <?php if ($activeFiltersCount > 0) : ?>
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-mint text-xs font-bold text-white"><?= $activeFiltersCount ?></span>
                <?php endif; ?>
            </button>

            <?php if (in_array(session()->get('admin_role'), ['perawat'], true)) : ?>
                <a href="<?= esc(site_url('admin/pasien/create'), 'attr') ?>"
                   class="inline-flex items-center gap-2 rounded-xl bg-mint px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-mint/25 transition hover:bg-mint-dark">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah pasien
                </a>
            <?php endif; ?>

            <!-- Modal Filter (Inside the Form) -->
            <div id="filter-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm bg-slate-900/40 transition-opacity duration-300 opacity-0 pointer-events-none">
                <div class="relative w-full max-w-md transform rounded-3xl bg-white p-6 shadow-2xl border border-slate-100 transition-all duration-300 scale-95 opacity-0">
                    <!-- Close button -->
                    <button type="button" id="close-filter" class="absolute right-5 top-5 rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <h3 class="text-lg font-bold text-slate-900">Filter Pasien</h3>
                    <p class="text-sm text-slate-500 mt-1">Saring data pasien berdasarkan beberapa kriteria.</p>

                    <div class="mt-6 space-y-4 text-left">
                        <!-- Hasil Diagnosa -->
                        <div>
                            <label for="filter-diagnosa" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide">Hasil Diagnosa</label>
                            <select name="diagnosa" id="filter-diagnosa"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                                <option value="">— Semua Hasil —</option>
                                <option value="Typhoid Fever" <?= ($filters['diagnosa'] ?? '') === 'Typhoid Fever' ? 'selected' : '' ?>>Typhoid Fever</option>
                                <option value="Non Typhoid Fever" <?= ($filters['diagnosa'] ?? '') === 'Non Typhoid Fever' ? 'selected' : '' ?>>Non Typhoid Fever</option>
                                <option value="Tidak terklasifikasi" <?= ($filters['diagnosa'] ?? '') === 'Tidak terklasifikasi' ? 'selected' : '' ?>>Tidak terklasifikasi</option>
                            </select>
                        </div>

                        <!-- Demam Pagi -->
                        <div>
                            <label for="filter-demam-pagi" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide">Demam Pagi</label>
                            <select name="demam_pagi" id="filter-demam-pagi"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                                <option value="">— Semua Kategori —</option>
                                <?php foreach ($demamCfg->keys as $key) : ?>
                                    <?php $opt = $demamCfg->label[$key]; ?>
                                    <option value="<?= esc($opt, 'attr') ?>" <?= ($filters['demam_pagi'] ?? '') === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Demam Sore -->
                        <div>
                            <label for="filter-demam-sore" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide">Demam Sore</label>
                            <select name="demam_sore" id="filter-demam-sore"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                                <option value="">— Semua Kategori —</option>
                                <?php foreach ($demamCfg->keys as $key) : ?>
                                    <?php $opt = $demamCfg->label[$key]; ?>
                                    <option value="<?= esc($opt, 'attr') ?>" <?= ($filters['demam_sore'] ?? '') === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Bradikardia Relatif -->
                        <div>
                            <label for="filter-bradikardia" class="block text-xs font-semibold text-slate-500 uppercase tracking-wide">Bradikardia Relatif</label>
                            <select name="bradikardia_relatif" id="filter-bradikardia"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                                <option value="">— Semua —</option>
                                <option value="1" <?= ($filters['bradikardia_relatif'] ?? '') === '1' ? 'selected' : '' ?>>Ya</option>
                                <option value="0" <?= ($filters['bradikardia_relatif'] ?? '') === '0' ? 'selected' : '' ?>>Tidak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-slate-100 mt-6">
                        <button type="submit" class="flex-1 rounded-xl bg-mint px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-mint/25 hover:bg-mint-dark">
                            Terapkan Filter
                        </button>
                        <a href="<?= esc(site_url('admin/pasien'), 'attr') ?>" class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 text-center hover:bg-slate-50">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Nama lengkap</th>
                        <th class="px-6 py-3">Usia</th>
                        <th class="px-6 py-3">Demam pagi</th>
                        <th class="px-6 py-3">Demam sore</th>
                        <th class="px-6 py-3">Bradikardia relatif</th>
                        <th class="px-6 py-3">Diagnosa</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (($rows ?? []) === []) : ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500">Belum ada data pasien.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($rows as $r) : ?>
                            <?php $pid = (int) ($r['id'] ?? 0); ?>
                            <tr class="hover:bg-slate-50/80">
                               <td class="whitespace-nowrap px-6 py-4 font-medium"><?= esc((string) $pid) ?></td>
                                <td class="px-6 py-4 font-medium text-slate-900"><?= esc((string) ($r['nama'] ?? '')) ?></td>
                                <td class="px-6 py-4 text-slate-700"><?= esc((string) ($r['usia'] ?? '—')) ?> tahun</td>
                                <td class="px-6 py-4 text-slate-700"><?= esc((string) ($r['demam_pagi'] ?? '—')) ?></td>
                                <td class="px-6 py-4 text-slate-700"><?= esc((string) ($r['demam_sore'] ?? '—')) ?></td>
                                <td class="px-6 py-4">
                                    <?php
                                    $brVal = $r['bradikardia_relatif'] ?? null;
                                    if ($brVal === null || $brVal === '') {
                                        echo '<span class="text-slate-400">—</span>';
                                    } else {
                                        $on = (int) $brVal === 1;
                                        $cls = $on ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700';
                                        $txt = $on ? 'Ya' : 'Tidak';
                                        echo '<span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ' . $cls . '">' . $txt . '</span>';
                                    }
                                    ?>
                                </td>
                                <td class="px-6 py-4 font-semibold">
                                    <?php
                                    $diag = $r['diagnosa'] ?? 'Tidak terklasifikasi';
                                    if ($diag === 'Typhoid Fever') {
                                        echo '<span class="inline-flex rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-bold text-rose-800">Typhoid Fever</span>';
                                    } elseif ($diag === 'Non Typhoid Fever') {
                                        echo '<span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Non Typhoid Fever</span>';
                                    } else {
                                        echo '<span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">Tidak terklasifikasi</span>';
                                    }
                                    ?>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        <a href="<?= esc(site_url('admin/pasien/' . $pid), 'attr') ?>"
                                            class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">Detail</a>
                                        <?php if (in_array(session()->get('admin_role'), ['perawat'], true)) : ?>
                                            <a href="<?= esc(site_url('admin/pasien/' . $pid . '/edit'), 'attr') ?>"
                                               class="rounded-lg border border-mint/40 bg-mint/10 px-3 py-1.5 text-xs font-medium text-mint-dark hover:bg-mint/20">Edit</a>
                                            <form action="<?= esc(site_url('admin/pasien/' . $pid . '/delete'), 'attr') ?>" method="post" class="inline"
                                                   onsubmit="return confirm('Hapus pasien ini?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">
                                                    Delete
                                                 </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($pager)) : ?>
            <?= $pager->links('default', 'admin_tailwind') ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnFilter = document.getElementById('btn-filter');
    var modal = document.getElementById('filter-modal');
    var closeFilter = document.getElementById('close-filter');
    var modalContent = modal ? modal.querySelector('.transform') : null;

    if (!btnFilter || !modal || !closeFilter || !modalContent) return;

    function openModal() {
        modal.classList.remove('pointer-events-none');
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        modalContent.classList.remove('scale-95');
        modalContent.classList.remove('opacity-0');
        modalContent.classList.add('scale-100');
        modalContent.classList.add('opacity-100');
    }

    function closeModal() {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        modal.classList.add('pointer-events-none');
        modalContent.classList.remove('scale-100');
        modalContent.classList.remove('opacity-100');
        modalContent.classList.add('scale-95');
        modalContent.classList.add('opacity-0');
    }

    btnFilter.addEventListener('click', openModal);
    closeFilter.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
});
</script>
