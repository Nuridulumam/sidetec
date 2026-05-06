<?php /** @var array<int, array<string, mixed>> $rows */ ?>
<div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="text-sm font-semibold text-slate-900">Daftar pasien</h2>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600"><?= count($rows ?? []) ?> entri</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Tgl lahir</th>
                    <th class="px-6 py-3">JK</th>
                    <th class="px-6 py-3">Telepon</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($rows)) : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada data pasien.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($rows as $r) : ?>
                        <tr class="hover:bg-slate-50/80">
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900"><?= esc((string) ($r['id'] ?? '')) ?></td>
                            <td class="px-6 py-4 text-slate-800"><?= esc((string) ($r['nama'] ?? '')) ?></td>
                            <td class="whitespace-nowrap px-6 py-4 text-slate-600"><?= esc((string) ($r['tanggal_lahir'] ?? '—')) ?></td>
                            <td class="px-6 py-4 text-slate-600"><?= esc((string) ($r['jenis_kelamin'] ?? '—')) ?></td>
                            <td class="px-6 py-4 text-slate-600"><?= esc((string) ($r['telepon'] ?? '—')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
