<?php /** @var array<int, array<string, mixed>> $rows */ ?>
<?php /** @var CodeIgniter\Pager\Pager $pager */ ?>
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Rule klasifikasi</h2>
            <p class="text-sm text-slate-500"><?= isset($pager) ? esc((string) $pager->getTotal()) : count($rows ?? []) ?> rule</p>
        </div>
        <?php if (in_array(session()->get('admin_role'), ['petugas sik', 'admin'], true)) : ?>
            <a href="<?= esc(site_url('admin/rule-klasifikasi/create'), 'attr') ?>"
               class="inline-flex items-center gap-2 rounded-xl bg-mint px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-mint/25 transition hover:bg-mint-dark">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah rule
            </a>
        <?php endif; ?>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Usia</th>
                        <th class="px-6 py-3">Demam</th>
                        <th class="px-6 py-3">Kehilangan Kesadaran</th>
                        <th class="px-6 py-3">Bradikardia</th>
                        <th class="px-6 py-3">Hasil</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (($rows ?? []) === []) : ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                Belum ada rule. Klik "Tambah rule" untuk membuat.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php
                        $currentPage = isset($pager) ? $pager->getCurrentPage('default') : 1;
                        $perPage = 10;
                        $no = ($currentPage - 1) * $perPage + 1;
                        foreach ($rows as $r) :
                        ?>
                            <?php $rid = $r['id'] ?? ''; ?>
                            <tr class="hover:bg-slate-50/80">
                                <td class="whitespace-nowrap px-6 py-4 font-medium"><?= esc((string) $no++) ?></td>
                                <td class="px-6 py-4 text-slate-700">
                                    <?= esc((string) ($r['usia'] ?? '—')) ?> tahun
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-700 leading-relaxed">
                                    <?php
                                    $dp = $r['demam_pagi'];
                                    $ds = $r['demam_sore'];
                                    if (empty($dp) && empty($ds)) {
                                        echo '<span class="text-slate-400">—</span>';
                                    } else {
                                        echo 'Pagi: ' . esc($dp ?? '—') . '<br>Sore: ' . esc($ds ?? '—');
                                    }
                                    ?>
                                </td>
                                <td class="px-6 py-4 text-slate-700">
                                    <?php
                                    $pkVal = $r['penurunan_kesadaran'];
                                    if ($pkVal === null || $pkVal === '') {
                                        echo '<span class="text-slate-400">—</span>';
                                    } else {
                                        echo (int) $pkVal === 1 ? 'Ya' : 'Tidak';
                                    }
                                    ?>
                                </td>
                                <td class="px-6 py-4 text-slate-700">
                                    <?php
                                    $brVal = $r['bradikardia_relatif'];
                                    if ($brVal === null || $brVal === '') {
                                        echo '<span class="text-slate-400">—</span>';
                                    } else {
                                        echo (int) $brVal === 1 ? 'Ya' : 'Tidak';
                                    }
                                    ?>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900"><?= esc((string) ($r['hasil'] ?? '—')) ?></td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        <a href="<?= esc(site_url('admin/rule-klasifikasi/' . $rid), 'attr') ?>"
                                           class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">Detail</a>
                                        <?php if (in_array(session()->get('admin_role'), ['petugas sik', 'admin'], true)) : ?>
                                            <a href="<?= esc(site_url('admin/rule-klasifikasi/' . $rid . '/edit'), 'attr') ?>"
                                               class="rounded-lg border border-mint/40 bg-mint/10 px-3 py-1.5 text-xs font-medium text-mint-dark hover:bg-mint/20">Edit</a>
                                            <form action="<?= esc(site_url('admin/rule-klasifikasi/' . $rid . '/delete'), 'attr') ?>" method="post" class="inline"
                                                  onsubmit="return confirm('Hapus rule ini?');">
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
