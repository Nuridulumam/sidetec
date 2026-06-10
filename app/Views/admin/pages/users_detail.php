<?php /** @var array<string, mixed> $user */ ?>
<div class="mx-auto max-w-xl space-y-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Detail pengguna</h2>
                <p class="mt-1 text-sm text-slate-500">ID #<?= esc((string) ($user['id'] ?? '')) ?></p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="<?= esc(site_url('admin/users/' . (int) ($user['id'] ?? 0) . '/edit'), 'attr') ?>"
                   class="rounded-xl bg-mint px-4 py-2 text-sm font-semibold text-white hover:bg-mint-dark">Edit</a>
                <a href="<?= esc(site_url('admin/users'), 'attr') ?>"
                   class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
            </div>
        </div>

        <dl class="mt-8 space-y-4 border-t border-slate-100 pt-8">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Username</dt>
                <dd class="mt-1 text-sm text-slate-900"><?= esc((string) ($user['username'] ?? '')) ?></dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama lengkap</dt>
                <dd class="mt-1 text-sm text-slate-900"><?= esc((string) ($user['full_name'] ?? '')) ?></dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Role</dt>
                <dd class="mt-1 text-sm text-slate-900"><?= esc((string) ($user['role'] ?? '')) ?></dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Status</dt>
                <dd class="mt-1">
                    <?php $on = ! empty($user['is_active']); ?>
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold <?= $on ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' ?>">
                        <?= $on ? 'Aktif' : 'Nonaktif' ?>
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Dibuat</dt>
                <dd class="mt-1 text-sm text-slate-600"><?= esc((string) ($user['created_at'] ?? '—')) ?></dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Diperbarui</dt>
                <dd class="mt-1 text-sm text-slate-600"><?= esc((string) ($user['updated_at'] ?? '—')) ?></dd>
            </div>
        </dl>
    </div>
</div>
