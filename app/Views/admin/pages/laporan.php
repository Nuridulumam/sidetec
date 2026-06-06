<?php /** @var array<int, array<string, mixed>> $rows */ ?>
<?php /** @var CodeIgniter\Pager\Pager $pager */ ?>
<div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="text-sm font-semibold text-slate-900">Laporan deteksi</h2>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600"><?= isset($pager) ? esc((string) $pager->getTotal()) : count($rows ?? []) ?> entri</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Pasien</th>
                    <th class="px-6 py-3">Oleh</th>
                    <th class="px-6 py-3">Hasil klasifikasi</th>
                    <th class="px-6 py-3">Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($rows)) : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada laporan.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($rows as $r) : ?>
                        <tr class="hover:bg-slate-50/80">
                            <td class="whitespace-nowrap px-6 py-4 font-medium"><?= esc((string) ($r['id'] ?? '')) ?></td>
                            <td class="px-6 py-4"><?= esc((string) ($r['pasien_nama'] ?? '—')) ?></td>
                            <td class="px-6 py-4 text-slate-600"><?= esc((string) ($r['user_email'] ?? '—')) ?></td>
                            <td class="px-6 py-4"><?= esc((string) ($r['hasil_klasifikasi'] ?? '—')) ?></td>
                            <td class="whitespace-nowrap px-6 py-4 text-slate-600"><?= esc((string) ($r['created_at'] ?? '—')) ?></td>
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
