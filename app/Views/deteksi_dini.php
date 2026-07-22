<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Dini — SIDETECT</title>
    <meta name="description" content="Deteksi dini kemungkinan penyakit typhoid fever berbasis gejala klinis secara mandiri.">
    <link rel="icon" type="image/png" href="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>">
    <link rel="apple-touch-icon" href="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        mint: {
                            DEFAULT: '#58C2B3',
                            light: '#72d4c6',
                            dark: '#4aa899',
                        },
                        page: '#F3F6F5',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        soft: '0 10px 40px -12px rgba(0, 0, 0, 0.12)',
                        nav: '0 8px 32px -8px rgba(0, 0, 0, 0.08)',
                    },
                    borderRadius: {
                        '4xl': '2rem',
                        '5xl': '2.5rem',
                        '6xl': '3rem',
                    },
                },
            },
        };
    </script>
    <style>
        html {
            font-size: 14px;
            scroll-behavior: smooth;
        }
        @media (min-width: 768px) { html { font-size: 14.5px; } }
        @media (min-width: 1024px) { html { font-size: 15px; } }
        @media (min-width: 1280px) { html { font-size: 16px; } }
    </style>
</head>
<body class="min-h-screen bg-page font-sans text-gray-800 antialiased">

<!-- Floating Top Nav -->
<header class="sticky top-4 z-50 px-4 sm:px-6">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 rounded-full bg-white px-5 py-3 shadow-nav sm:px-8 sm:py-3.5">
        <a href="<?= esc(site_url(), 'attr') ?>" class="flex shrink-0 items-center gap-2.5">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-mint shadow-sm ring-4 ring-mint/25">
                <img
                    src="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>"
                    alt="SIDETECT"
                    class="h-10 w-10 rounded-xl bg-white p-1 object-contain"
                    loading="lazy"
                >
            </span>
            <span class="text-xl font-bold tracking-tight text-gray-900">SIDETECT</span>
        </a>

        <div id="nav-links" class="absolute left-4 right-4 top-full mt-2 hidden flex flex-col gap-1 rounded-3xl border border-gray-100 bg-white p-4 shadow-soft sm:static sm:mt-0 sm:flex sm:flex-row sm:items-center sm:gap-8 sm:border-0 sm:bg-transparent sm:p-0 sm:shadow-none">
            <a href="<?= esc(site_url('#definisi'), 'attr') ?>" class="rounded-xl px-3 py-2 text-md font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 sm:py-0 sm:hover:bg-transparent">Definisi</a>
            <a href="<?= esc(site_url('#gejala'), 'attr') ?>" class="rounded-xl px-3 py-2 text-md font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 sm:py-0 sm:hover:bg-transparent">Gejala</a>
            <a href="<?= esc(site_url('#risiko'), 'attr') ?>" class="rounded-xl px-3 py-2 text-md font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 sm:py-0 sm:hover:bg-transparent">Faktor risiko</a>
        </div>

        <div class="flex items-center gap-3 sm:gap-5">
            <a href="<?= esc(site_url('deteksi-dini'), 'attr') ?>" class="inline-flex items-center justify-center rounded-full bg-mint px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-mint-dark transition ring-4 ring-mint/20">Deteksi Dini</a>
            <button type="button" id="menu-toggle" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-700 sm:hidden" aria-expanded="false" aria-controls="nav-links">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </nav>
</header>

<main class="px-4 pb-24 pt-8 sm:px-6">
    <div class="mx-auto max-w-7xl">
        <!-- Title Header -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Deteksi Dini Mandiri</h1>
            <p class="mt-3 text-sm text-gray-500 max-w-2xl mx-auto sm:text-base">
                Silakan lengkapi data diri Anda serta gejala klinis yang sedang dialami untuk melihat hasil analisis risiko kemungkinan Typhoid Fever.
            </p>
        </div>

        <!-- Alert Error Section -->
        <?php
        $flashErrors = session()->getFlashdata('errors') ?? [];
        if (is_array($flashErrors) && $flashErrors !== []) :
        ?>
            <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-950 shadow-sm max-w-7xl mx-auto">
                <div class="flex items-center gap-2.5 font-bold mb-3">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Terdapat beberapa kesalahan pengisian form:</span>
                </div>
                <ul class="list-inside list-disc space-y-1 ml-1 text-red-800">
                    <?php foreach ($flashErrors as $msg) : ?>
                        <li><?= esc(is_array($msg) ? implode(', ', $msg) : (string) $msg) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($e = session()->getFlashdata('error')) : ?>
            <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-950 shadow-sm max-w-7xl mx-auto">
                <p><?= esc($e) ?></p>
            </div>
        <?php endif; ?>

        <!-- Combined Form and Informational Cards Container -->
        <form action="<?= esc(site_url('deteksi-dini'), 'attr') ?>" method="post">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Patient Form and Symptom Form Cards (Col span 8) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Card 1: Form Identitas Pasien -->
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 sm:p-8 shadow-soft">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-mint/15 text-mint">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">1. Identitas Pasien</h2>
                                <p class="text-xs text-gray-500">Lengkapi data diri pasien untuk keperluan validasi rekam medis.</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <!-- NIK (16 Digit) -->
                            <div>
                                <label for="nik" class="block text-sm font-semibold text-gray-700">NIK (16 Digit) <span class="text-red-500">*</span></label>
                                <input type="text" name="nik" id="nik" required
                                       value="<?= esc(old('nik', '')) ?>"
                                       class="mt-1.5 w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                                       placeholder="16 digit nomor NIK"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <p id="nik-error" class="mt-1.5 text-xs text-red-600 font-medium"></p>
                            </div>

                            <!-- Nama Lengkap -->
                            <div>
                                <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" id="nama" required minlength="3" maxlength="191"
                                       value="<?= esc(old('nama', '')) ?>"
                                       class="mt-1.5 w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                                       placeholder="Nama lengkap pasien">
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                                       value="<?= esc(old('tanggal_lahir', '')) ?>"
                                       class="mt-1.5 w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                            </div>

                            <!-- Usia (Terhitung Otomatis) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Usia (Tahun)</label>
                                <input type="number" id="usia_display" disabled
                                       value="<?= esc(old('usia', '')) ?>"
                                       class="mt-1.5 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-500 shadow-sm cursor-not-allowed"
                                       placeholder="Terhitung otomatis">
                                <input type="hidden" name="usia" id="usia" value="<?= esc(old('usia', '')) ?>">
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin" required
                                        class="mt-1.5 w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30">
                                    <option value="">— Pilih Jenis Kelamin —</option>
                                    <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>

                            <!-- Telepon -->
                            <div>
                                <label for="telepon" class="block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                                <input type="text" name="telepon" id="telepon" maxlength="32"
                                       value="<?= esc(old('telepon', '')) ?>"
                                       class="mt-1.5 w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                                       placeholder="Contoh: 08123456789">
                            </div>

                            <!-- Alamat -->
                            <div class="sm:col-span-2">
                                <label for="alamat" class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="3"
                                          class="mt-1.5 w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                                          placeholder="Alamat tempat tinggal saat ini"><?= esc(old('alamat', '')) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Form Gejala Klinis -->
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 sm:p-8 shadow-soft">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-mint/15 text-mint">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">2. Gejala Klinis</h2>
                                <p class="text-xs text-gray-500">Pilih gejala yang dirasakan saat ini dengan jujur untuk keakuratan klasifikasi.</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2 mb-6">
                            <!-- Render Demam Fields from Admin Partials -->
                            <?= view('admin/partials/pasien_demam_fields', ['record' => null]) ?>
                        </div>

                        <?php
                        $symptoms = [
                            'sakit_kepala'        => 'Sakit kepala',
                            'nyeri_otot'          => 'Nyeri otot',
                            'mual'                => 'Mual',
                            'muntah'              => 'Muntah',
                            'nyeri_perut'         => 'Nyeri perut',
                            'diare'               => 'Diare',
                            'penurunan_kesadaran' => 'Penurunan kesadaran (mengantuk berat, bingung)',
                            'bradikardia_relatif' => 'Bradikardia relatif (denyut jantung relatif lambat saat demam)',
                            'lemas'               => 'Lemas atau kelelahan ekstrim',
                        ];
                        $radioClass = 'h-4 w-4 rounded-full border-gray-300 text-mint focus:ring-mint';
                        ?>

                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-sm font-semibold text-gray-950">Gejala & Tanda Klinis Lainnya</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Pilih Ya jika penderita mengalami gejala tersebut dalam 3-7 hari terakhir.</p>

                            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                <?php foreach ($symptoms as $key => $label) : ?>
                                    <fieldset class="rounded-2xl border border-gray-200 p-4 hover:border-gray-300 transition duration-150">
                                        <legend class="px-1 text-sm font-semibold text-gray-800"><?= esc($label) ?></legend>
                                        <div class="mt-2.5 flex items-center gap-6">
                                            <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                                <input type="radio" name="<?= esc($key, 'attr') ?>" value="1"
                                                       class="<?= esc($radioClass, 'attr') ?>"
                                                       <?= old($key) === '1' ? 'checked' : '' ?> required>
                                                Ya
                                            </label>
                                            <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                                <input type="radio" name="<?= esc($key, 'attr') ?>" value="0"
                                                       class="<?= esc($radioClass, 'attr') ?>"
                                                       <?= old($key) === '0' ? 'checked' : '' ?> required>
                                                Tidak
                                            </label>
                                        </div>
                                    </fieldset>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Submit Button inside Card 2 Footer area -->
                        <div class="flex gap-4 pt-8 border-t border-gray-100 mt-8">
                            <button type="submit" class="rounded-xl bg-mint px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-mint/25 hover:bg-mint-dark transform active:scale-95 transition duration-150">
                                Mulai Analisis & Deteksi Dini
                            </button>
                            <a href="<?= esc(site_url(), 'attr') ?>"
                               class="rounded-xl border border-gray-200 px-6 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition duration-150">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Card Informasi (Col span 4) -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Kategori Demam Reference Card -->
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-soft">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Referensi Kategori Demam</h3>
                        <div class="space-y-5">
                            <div>
                                <h4 class="text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Kelompok Usia Anak-Anak (0–17 tahun)</h4>
                                <div class="overflow-hidden border border-gray-150 rounded-2xl">
                                    <table class="min-w-full divide-y divide-gray-200 text-xs text-left">
                                        <thead class="bg-gray-50 text-gray-500 font-semibold">
                                            <tr>
                                                <th class="px-3 py-2">Kategori</th>
                                                <th class="px-3 py-2">Suhu (°C)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700 bg-white">
                                            <tr><td class="px-3 py-2 font-medium">Tidak Demam</td><td class="px-3 py-2">36,5 - 37,5</td></tr>
                                            <tr><td class="px-3 py-2 font-medium">Demam Ringan</td><td class="px-3 py-2">37,6 - 38,0</td></tr>
                                            <tr><td class="px-3 py-2 font-medium">Demam Sedang</td><td class="px-3 py-2">38,1 - 39,0</td></tr>
                                            <tr><td class="px-3 py-2 font-medium">Demam Tinggi</td><td class="px-3 py-2">39,1 - 40,0</td></tr>
                                            <tr class="bg-rose-50 text-rose-800"><td class="px-3 py-2 font-bold">Hiperpireksia</td><td class="px-3 py-2 font-bold">&gt; 40,0</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Kelompok Usia Dewasa (&ge; 18 tahun)</h4>
                                <div class="overflow-hidden border border-gray-150 rounded-2xl">
                                    <table class="min-w-full divide-y divide-gray-200 text-xs text-left">
                                        <thead class="bg-gray-50 text-gray-500 font-semibold">
                                            <tr>
                                                <th class="px-3 py-2">Kategori</th>
                                                <th class="px-3 py-2">Suhu (°C)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-gray-700 bg-white">
                                            <tr><td class="px-3 py-2 font-medium">Tidak Demam</td><td class="px-3 py-2">36,0 - 37,2</td></tr>
                                            <tr><td class="px-3 py-2 font-medium">Demam Ringan</td><td class="px-3 py-2">37,3 - 38,0</td></tr>
                                            <tr><td class="px-3 py-2 font-medium">Demam Sedang</td><td class="px-3 py-2">38,1 - 39,0</td></tr>
                                            <tr><td class="px-3 py-2 font-medium">Demam Tinggi</td><td class="px-3 py-2">39,1 - 40,0</td></tr>
                                            <tr class="bg-rose-50 text-rose-800"><td class="px-3 py-2 font-bold">Hiperpireksia</td><td class="px-3 py-2 font-bold">&gt; 40,0</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bradikardia Relatif Reference Card -->
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-soft">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Referensi Bradikardia Relatif</h3>
                        <div class="space-y-4 text-xs text-gray-500">
                            <p class="leading-relaxed">
                                Bradikardia relatif terjadi ketika kenaikan suhu tubuh tidak diikuti dengan peningkatan denyut jantung (nadi) yang setara secara fisiologis (disosiasi suhu-nadi).
                            </p>
                            <p class="leading-relaxed">
                                <strong>Kriteria Dewasa (Cunha):</strong><br>
                                Pada suhu &ge; 38,9°C, denyut nadi tetap &le; 120 bpm (atau suhu &ge; 38,3°C dengan nadi &le; 110 bpm).
                            </p>
                            <p class="leading-relaxed">
                                <strong>Kriteria Anak-Anak:</strong><br>
                                Nadi aktual di bawah batas rentang normal yang disesuaikan dengan derajat peningkatan suhu demam.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </form>

        <!-- Footer block -->
        <footer class="mx-auto mt-20 border-t border-gray-200 pt-10 text-center text-sm text-gray-500">
            <p class="font-semibold text-gray-700">&copy; Copyright SIDETECT <?= esc(date('Y')) ?></p>
            <p class="mt-1">Sistem Deteksi Dini Typhoid Fever</p>
            <div class="mt-4">
                <a href="<?= esc(site_url('admin/login'), 'attr') ?>" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 hover:text-gray-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Masuk Admin
                </a>
            </div>
        </footer>
    </div>
</main>

<!-- JS Scripts -->
<?= view('admin/partials/pasien_demam_script') ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Mobile Menu Toggle
    var btn = document.getElementById('menu-toggle');
    var panel = document.getElementById('nav-links');
    if (btn && panel) {
        btn.addEventListener('click', function () {
            var open = panel.classList.toggle('hidden') === false;
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    // 2. Date of Birth to Age Calculator
    var dobInput = document.getElementById('tanggal_lahir');
    var usiaDisplay = document.getElementById('usia_display');
    var usiaHidden = document.getElementById('usia');

    if (dobInput && usiaDisplay && usiaHidden) {
        function calculateAge() {
            var dobVal = dobInput.value;
            if (!dobVal) {
                usiaDisplay.value = '';
                usiaHidden.value = '';
                usiaHidden.dispatchEvent(new Event('input')); // trigger demam script refresh
                return;
            }

            var dob = new Date(dobVal);
            var today = new Date();
            
            if (isNaN(dob.getTime())) {
                usiaDisplay.value = '';
                usiaHidden.value = '';
                usiaHidden.dispatchEvent(new Event('input'));
                return;
            }

            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            if (age < 0) age = 0;

            usiaDisplay.value = age;
            usiaHidden.value = age;
            usiaHidden.dispatchEvent(new Event('input')); // notify the demam script to update reference fields
        }

        dobInput.addEventListener('change', calculateAge);
        dobInput.addEventListener('input', calculateAge);
        
        if (dobInput.value) {
            calculateAge();
        }
    }

    // 3. NIK 16-digit validation
    var nikInput = document.getElementById('nik');
    var nikErrorEl = document.getElementById('nik-error');

    if (nikInput && nikErrorEl) {
        nikInput.addEventListener('blur', function() {
            var val = nikInput.value.trim();
            var error = '';

            if (val === '') {
                error = 'NIK wajib diisi.';
            } else if (!/^\d+$/.test(val)) {
                error = 'NIK hanya boleh berupa angka.';
            } else if (val.length !== 16) {
                error = 'NIK harus 16 digit.';
            }

            if (error) {
                nikErrorEl.textContent = error;
                nikInput.classList.remove('border-gray-200', 'focus:border-mint', 'focus:ring-mint/30');
                nikInput.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-200');
            } else {
                nikErrorEl.textContent = '';
                nikInput.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-200');
                nikInput.classList.add('border-gray-200', 'focus:border-mint', 'focus:ring-mint/30');
            }
        });

        nikInput.addEventListener('input', function() {
            var val = nikInput.value.trim();
            if (val.length === 16 && /^\d+$/.test(val)) {
                nikErrorEl.textContent = '';
                nikInput.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-200');
                nikInput.classList.add('border-gray-200', 'focus:border-mint', 'focus:ring-mint/30');
            }
        });
    }
});
</script>

</body>
</html>
