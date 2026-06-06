<?php /** @var array<int, array<string, mixed>> $rows */ ?>
<?php /** @var CodeIgniter\Pager\Pager $pager */ ?>
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Laporan Deteksi Dini Typhoid</h2>
            <p class="text-sm text-slate-500"><?= isset($pager) ? esc((string) $pager->getTotal()) : count($rows ?? []) ?> pasien terdaftar</p>
        </div>
        <a href="<?= esc(site_url('admin/laporan/export'), 'attr') ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export ke Excel
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Nama Lengkap</th>
                        <th class="px-6 py-3">Usia</th>
                        <th class="px-6 py-3">Bradikardia</th>
                        <th class="px-6 py-3">Hasil Klasifikasi</th>
                        <th class="px-6 py-3">Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($rows)) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">Belum ada data pasien.</td>
                        </tr>
                    <?php else : ?>
                        <?php 
                        // Calculate sequential number based on current page
                        $currentPage = isset($pager) ? $pager->getCurrentPage('default') : 1;
                        $perPage = 10;
                        $no = ($currentPage - 1) * $perPage + 1;
                        
                        foreach ($rows as $r) : 
                        ?>
                            <tr class="hover:bg-slate-50/80">
                                <td class="whitespace-nowrap px-6 py-4 font-medium"><?= esc((string) $no++) ?></td>
                                <td class="px-6 py-4 font-medium text-slate-900"><?= esc((string) ($r['nama'] ?? '')) ?></td>
                                <td class="px-6 py-4 text-slate-700"><?= esc((string) ($r['usia'] ?? '—')) ?> tahun</td>
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
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                    <?= isset($r['created_at']) ? date('d M Y H:i', strtotime($r['created_at'])) : '—' ?>
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
