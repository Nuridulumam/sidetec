<?php /** @var array<int, array<string, mixed>> $rows */ ?>
<div class="space-y-4">
    <?php if ($m = session()->getFlashdata('message')) : ?>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900"><?= esc($m) ?></div>
    <?php endif; ?>
    <?php if ($e = session()->getFlashdata('error')) : ?>
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"><?= esc($e) ?></div>
    <?php endif; ?>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Manage User</h2>
            <p class="text-sm text-slate-500"><?= count($rows ?? []) ?> pengguna terdaftar</p>
        </div>
        <a href="<?= esc(site_url('admin/users/create'), 'attr') ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-mint px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-mint/25 transition hover:bg-mint-dark">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah user
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Aktif</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (($rows ?? []) === []) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">Belum ada pengguna.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($rows as $r) : ?>
                            <?php $uid = (int) ($r['id'] ?? 0); ?>
                            <tr class="hover:bg-slate-50/80">
                                <td class="whitespace-nowrap px-6 py-4 font-medium"><?= esc((string) $uid) ?></td>
                                <td class="px-6 py-4"><?= esc((string) ($r['email'] ?? '')) ?></td>
                                <td class="px-6 py-4"><?= esc((string) ($r['full_name'] ?? '')) ?></td>
                                <td class="px-6 py-4"><?= esc((string) ($r['role'] ?? '')) ?></td>
                                <td class="px-6 py-4">
                                    <?php $on = ! empty($r['is_active']); ?>
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold <?= $on ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' ?>">
                                        <?= $on ? 'Ya' : 'Tidak' ?>
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        <a href="<?= esc(site_url('admin/users/' . $uid), 'attr') ?>"
                                           class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="<?= esc(site_url('admin/users/' . $uid . '/edit'), 'attr') ?>"
                                           class="rounded-lg border border-mint/40 bg-mint/10 px-3 py-1.5 text-xs font-medium text-mint-dark hover:bg-mint/20">Edit</a>
                                        <form action="<?= esc(site_url('admin/users/' . $uid . '/delete'), 'attr') ?>" method="post" class="inline"
                                              onsubmit="return confirm('Hapus pengguna ini?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">
                                                Delete
                                            </button>
                                        </form>
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
