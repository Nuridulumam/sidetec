<?php /** @var array<int, array<string, mixed>> $rows */ ?>
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Daftar pasien</h2>
            <p class="text-sm text-slate-500"><?= count($rows ?? []) ?> entri</p>
        </div>
        <?php if (in_array(session()->get('admin_role'), ['petugas poli', 'superadmin'], true)) : ?>
            <a href="<?= esc(site_url('admin/pasien/create'), 'attr') ?>"
               class="inline-flex items-center gap-2 rounded-xl bg-mint px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-mint/25 transition hover:bg-mint-dark">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah pasien
            </a>
        <?php endif; ?>
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
                        <th class="px-6 py-3">Dibuat</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (($rows ?? []) === []) : ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">Belum ada data pasien.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($rows as $r) : ?>
                            <?php $pid = (int) ($r['id'] ?? 0); ?>
                            <tr class="hover:bg-slate-50/80">
                                <td class="whitespace-nowrap px-6 py-4 font-medium"><?= esc((string) $pid) ?></td>
                                <td class="px-6 py-4"><?= esc((string) ($r['nama'] ?? '')) ?></td>
                                <td class="px-6 py-4 text-slate-700"><?= esc((string) ($r['usia'] ?? '—')) ?></td>
                                <td class="px-6 py-4 text-slate-700"><?= esc((string) ($r['demam_pagi'] ?? '—')) ?></td>
                                <td class="px-6 py-4 text-slate-700"><?= esc((string) ($r['demam_sore'] ?? '—')) ?></td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-600"><?= esc((string) ($r['created_at'] ?? '—')) ?></td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        <a href="<?= esc(site_url('admin/pasien/' . $pid), 'attr') ?>"
                                           class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">Detail</a>
                                        <?php if (in_array(session()->get('admin_role'), ['petugas poli', 'superadmin'], true)) : ?>
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
    </div>
</div>
