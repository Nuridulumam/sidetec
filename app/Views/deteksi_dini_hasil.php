<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Deteksi Dini — SIDETECT</title>
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
            <a href="<?= esc(site_url('deteksi-dini'), 'attr') ?>" class="inline-flex items-center justify-center rounded-full bg-mint px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-mint-dark transition">Deteksi Dini</a>
            <button type="button" id="menu-toggle" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-700 sm:hidden" aria-expanded="false" aria-controls="nav-links">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </nav>
</header>

<main class="px-4 pb-24 pt-8 sm:px-6">
    <div class="mx-auto max-w-4xl space-y-8">
        
        <!-- Header Title -->
        <div class="text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Hasil Analisis Deteksi Dini</h1>
            <p class="mt-2 text-sm text-gray-500">Terima kasih telah menggunakan SIDETECT. Berikut adalah hasil pemeriksaan gejala Anda.</p>
        </div>

        <!-- Banner Diagnosa -->
        <?php
        $diag = $gejala['diagnosa'] ?? '—';
        if ($diag === 'Suspect Typhoid Fever') {
            $bannerBg = 'bg-rose-50 border border-rose-100 text-rose-950';
            $iconBg = 'bg-white text-rose-600';
            $icon = '<svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
            $statusText = 'Suspect Typhoid Fever (Dicurigai Tifoid)';
            $descriptionText = 'Berdasarkan analisis algoritma klasifikasi terhadap gejala klinis yang Anda masukkan, Anda masuk dalam kategori <strong>Suspect Typhoid Fever</strong>. Kami sangat menyarankan Anda untuk segera berkonsultasi dengan dokter atau mengunjungi fasilitas kesehatan terdekat (puskesmas/klinik/rumah sakit) untuk melakukan pemeriksaan laboratorium (seperti tes darah) guna mendapatkan diagnosa medis yang akurat dan penanganan yang tepat.';
        } else {
            $bannerBg = 'bg-emerald-50 border border-emerald-100 text-emerald-950';
            $iconBg = 'bg-white text-emerald-600';
            $icon = '<svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            $statusText = 'Non Suspect Typhoid Fever (Tidak Dicurigai Tifoid)';
            $descriptionText = 'Berdasarkan analisis algoritma klasifikasi terhadap gejala klinis yang Anda masukkan, Anda masuk dalam kategori <strong>Non Suspect Typhoid Fever</strong>. Meskipun demikian, jika gejala yang Anda alami dirasa semakin mengganggu atau demam tidak kunjung turun dalam beberapa hari, Anda tetap disarankan untuk berkonsultasi dengan tenaga medis demi keselamatan kesehatan Anda.';
        }
        ?>
        <div class="flex flex-col sm:flex-row items-start gap-4 p-6 sm:p-8 rounded-3xl <?= $bannerBg ?> shadow-sm">
            <div class="rounded-2xl p-3 shadow-sm shrink-0 <?= $iconBg ?>">
                <?= $icon ?>
            </div>
            <div class="space-y-2">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Hasil Klasifikasi Sistem</p>
                <h2 class="text-xl font-extrabold sm:text-2xl"><?= esc($statusText) ?></h2>
                <p class="text-sm leading-relaxed opacity-95"><?= $descriptionText ?></p>
            </div>
        </div>

        <!-- Detail Identitas Pasien -->
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-soft">
            <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-mint/15 text-mint">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </span>
                <h3 class="text-md font-bold text-gray-900">Identitas Pasien</h3>
            </div>
            <div class="p-6 grid gap-6 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="space-y-4">
                    <dl class="space-y-3.5 text-sm">
                        <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                            <dt class="text-gray-500">Nama Lengkap</dt>
                            <dd class="font-semibold text-gray-900"><?= esc($pasien['nama']) ?></dd>
                        </div>
                        <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                            <dt class="text-gray-500">Nomor RM (Rekam Medis)</dt>
                            <dd class="font-bold text-mint-dark"><?= esc((string)$pasien['nomor_rm']) ?></dd>
                        </div>
                        <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                            <dt class="text-gray-500">NIK</dt>
                            <dd class="font-medium text-gray-900"><?= esc($pasien['nik']) ?></dd>
                        </div>
                        <div class="flex justify-between gap-4 pb-1">
                            <dt class="text-gray-500">Tanggal Lahir</dt>
                            <dd class="text-gray-900"><?= date('d-m-Y', strtotime($pasien['tanggal_lahir'])) ?></dd>
                        </div>
                    </dl>
                </div>
                <div class="space-y-4 pt-4 md:pt-0 md:pl-6">
                    <dl class="space-y-3.5 text-sm">
                        <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                            <dt class="text-gray-500">Usia</dt>
                            <dd class="text-gray-900 font-semibold"><?= esc((string)$pasien['usia']) ?> Tahun</dd>
                        </div>
                        <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                            <dt class="text-gray-500">Jenis Kelamin</dt>
                            <dd class="text-gray-900"><?= $pasien['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></dd>
                        </div>
                        <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                            <dt class="text-gray-500">Nomor Telepon</dt>
                            <dd class="text-gray-900"><?= esc($pasien['telepon'] ?: '—') ?></dd>
                        </div>
                        <div class="flex justify-between gap-4 pb-1">
                            <dt class="text-gray-500">Alamat</dt>
                            <dd class="text-gray-900 text-right max-w-[200px] truncate-2-lines"><?= esc($pasien['alamat'] ?: '—') ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Detail Gejala yang Dimasukkan -->
        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-soft">
            <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-mint/15 text-mint">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <h3 class="text-md font-bold text-gray-900">Gejala & Kondisi Klinis</h3>
            </div>
            
            <div class="p-6">
                <!-- Suhu Demam Card -->
                <div class="grid gap-4 sm:grid-cols-2 mb-6 pb-6 border-b border-gray-100">
                    <div class="rounded-2xl border border-gray-200 bg-gray-50/50 p-4">
                        <span class="text-xs text-gray-500 font-semibold uppercase">Demam Pagi Hari</span>
                        <p class="text-base font-bold text-gray-900 mt-1"><?= esc($gejala['demam_pagi']) ?></p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-gray-50/50 p-4">
                        <span class="text-xs text-gray-500 font-semibold uppercase">Demam Sore/Malam Hari</span>
                        <p class="text-base font-bold text-gray-900 mt-1"><?= esc($gejala['demam_sore']) ?></p>
                    </div>
                </div>

                <!-- Tambahan Gejala Lainnya -->
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Daftar Gejala Tambahan</h4>
                
                <?php
                $symptomLabels = [
                    'sakit_kepala'        => 'Sakit kepala',
                    'nyeri_otot'          => 'Nyeri otot',
                    'mual'                => 'Mual',
                    'muntah'              => 'Muntah',
                    'nyeri_perut'         => 'Nyeri perut',
                    'diare'               => 'Diare',
                    'penurunan_kesadaran' => 'Penurunan kesadaran',
                    'bradikardia_relatif' => 'Bradikardia relatif',
                    'lemas'               => 'Lemas',
                ];
                ?>
                <div class="grid gap-3 sm:grid-cols-2">
                    <?php foreach ($symptomLabels as $key => $label) : ?>
                        <?php $val = (int) ($gejala[$key] ?? 0) === 1; ?>
                        <div class="flex items-center justify-between p-3.5 rounded-2xl border border-gray-150 hover:bg-gray-50/40 transition">
                            <span class="text-sm font-medium text-gray-700"><?= esc($label) ?></span>
                            <?php if ($val) : ?>
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-50 border border-red-200 px-3 py-1 text-xs font-bold text-red-700">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    Ya
                                </span>
                            <?php else : ?>
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-50 border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-500">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Tidak
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-center pt-4">
            <a href="<?= esc(site_url('deteksi-dini'), 'attr') ?>" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-mint px-6 py-4 text-sm font-bold text-white shadow-lg shadow-mint/25 hover:bg-mint-dark transform active:scale-95 transition">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 6H16"/></svg>
                Deteksi Ulang / Deteksi Baru
            </a>
            <a href="<?= esc(site_url(), 'attr') ?>" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-6 py-4 text-sm font-bold text-gray-700 hover:bg-gray-50 transform active:scale-95 transition">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Disclaimer -->
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-soft text-xs text-gray-500 leading-relaxed space-y-2">
            <h4 class="font-bold text-gray-700">Pernyataan Penolakan Tanggung Jawab (Disclaimer):</h4>
            <p>
                Hasil analisis ini semata-mata didasarkan pada kecocokan pola gejala klinis menggunakan kecerdasan buatan berbasis algoritma pohon keputusan C4.5 dari data latih aturan. Hasil ini bersifat informatif, ditujukan sebagai alat skrining awal/deteksi dini edukatif, dan <strong>SAMA SEKALI TIDAK MENGGANTIKAN</strong> pemeriksaan langsung oleh dokter, diagnosis klinis profesional, atau pemeriksaan laboratorium (seperti tes kultur darah/Widal/Tubex). Segera periksakan diri ke dokter atau fasilitas pelayanan kesehatan untuk penegakan diagnosis yang sah.
            </p>
        </div>

        <!-- Footer -->
        <footer class="text-center text-xs text-gray-400 pt-6">
            <p>&copy; Copyright SIDETECT <?= esc(date('Y')) ?> · RS Wijaya Kusuma</p>
        </footer>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    var btn = document.getElementById('menu-toggle');
    var panel = document.getElementById('nav-links');
    if (btn && panel) {
        btn.addEventListener('click', function () {
            var open = panel.classList.toggle('hidden') === false;
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }
});
</script>

</body>
</html>
