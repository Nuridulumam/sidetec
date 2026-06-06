<?php
/** @var array{pasien:int,rules:int,laporan:int,users:int} $counts */
$c = $counts ?? ['pasien' => 0, 'rules' => 0, 'laporan' => 0, 'users' => 0];
$role = session()->get('admin_role');

$cards = [
    ['label' => 'Pasien', 'value' => $c['pasien'], 'tone' => 'mint'],
];

if (in_array($role, ['petugas sik', 'admin', 'superadmin'], true)) {
    $cards[] = ['label' => 'Rule klasifikasi', 'value' => $c['rules'], 'tone' => 'slate'];
}

if (in_array($role, ['petugas poli', 'admin', 'superadmin'], true)) {
    $cards[] = ['label' => 'Laporan', 'value' => $c['laporan'], 'tone' => 'slate'];
}

if (in_array($role, ['admin', 'superadmin'], true)) {
    $cards[] = ['label' => 'Pengguna', 'value' => $c['users'], 'tone' => 'slate'];
}
?>
<div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
    <?php foreach ($cards as $card) :
        $mint = $card['tone'] === 'mint';
    ?>
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm <?= $mint ? 'ring-2 ring-mint/30' : '' ?>">
        <p class="text-sm font-medium text-slate-500"><?= esc($card['label']) ?></p>
        <p class="mt-2 text-4xl font-bold <?= $mint ? 'text-mint' : 'text-slate-900' ?>"><?= esc((string) $card['value']) ?></p>
    </div>
    <?php endforeach; ?>
</div>

<div class="mt-10 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
    <h2 class="text-base font-semibold text-slate-900">Ringkasan</h2>
    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-600">
        Dashboard Sidetect digunakan untuk memonitor data pasien, mengatur rule klasifikasi tifoid, serta mengakses laporan hasil deteksi dini.
        Gunakan menu di sidebar untuk mengelola masing-masing bagian.
    </p>
</div>
