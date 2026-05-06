<?php /** @var array<int, array<string, mixed>> $rows */ ?>
<div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="text-sm font-semibold text-slate-900">Rule klasifikasi</h2>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600"><?= count($rows ?? []) ?> rule</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">Urutan</th>
                    <th class="px-6 py-3">Nama rule</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Aktif</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($rows)) : ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada rule. Tambahkan melalui fitur pengembangan selanjutnya.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($rows as $r) : ?>
                        <tr class="hover:bg-slate-50/80">
                            <td class="whitespace-nowrap px-6 py-4"><?= esc((string) ($r['urutan'] ?? '0')) ?></td>
                            <td class="px-6 py-4 font-medium text-slate-900"><?= esc((string) ($r['nama_rule'] ?? '')) ?></td>
                            <td class="max-w-md px-6 py-4 text-slate-600"><?= esc((string) ($r['deskripsi'] ?? '—')) ?></td>
                            <td class="px-6 py-4">
                                <?php $on = ! empty($r['aktif']); ?>
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold <?= $on ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' ?>">
                                    <?= $on ? 'Ya' : 'Tidak' ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
