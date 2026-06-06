<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDETECT — Sistem Deteksi Dini Penyakit Tifoid</title>
    <meta name="description" content="SIDETECT membantu identifikasi awal kemungkinan penyakit tifoid melalui sistem deteksi dini berbasis informasi.">
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
                    screens: {
                        '3xl': '1920px',
                        '4k': '2560px',
                    },
                },
            },
        };
    </script>
    <style>
        /* Responsive font-size scaling across various devices */
        html {
            font-size: 14px; /* Mobile / Small Screens */
            scroll-behavior: smooth;
        }
        @media (min-width: 768px) {
            html {
                font-size: 14.5px; /* Tablet */
            }
        }
        @media (min-width: 1024px) {
            html {
                font-size: 15px; /* Laptop Medium (lg) */
            }
        }
        @media (min-width: 1280px) {
            html {
                font-size: 16px; /* Laptop Large / Standard Desktop (xl) */
            }
        }
        @media (min-width: 1440px) {
            html {
                font-size: 16.5px; /* Larger Laptops */
            }
        }
        @media (min-width: 1920px) {
            html {
                font-size: 18px; /* Desktop Full HD / 3xl */
            }
        }
        @media (min-width: 2560px) {
            html {
                font-size: 22px; /* 4K QHD / iMac */
            }
        }
        @media (min-width: 3840px) {
            html {
                font-size: 26px; /* 4K UHD Ultra */
            }
        }
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-page font-sans text-gray-800 antialiased">

<!-- Top floating nav -->
<header class="sticky top-4 z-50 px-4 sm:px-6">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 rounded-full bg-white px-5 py-3 shadow-nav sm:px-8 sm:py-3.5">
        <a href="#" class="flex shrink-0 items-center gap-2.5">
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-mint shadow-sm ring-4 ring-mint/25">
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
            <?php
            $nav = [
                'Definisi' => 'definisi',
                'Gejala' => 'gejala',
                'Faktor risiko' => 'risiko',
            ];
            foreach ($nav as $label => $hash) :
            ?>
                <a href="#<?= esc($hash, 'attr') ?>" class="rounded-xl px-3 py-2 text-md font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 sm:py-0 sm:hover:bg-transparent"><?= esc($label) ?></a>
            <?php endforeach; ?>
        </div>

        <div class="flex items-center gap-3 sm:gap-5">
            <div class="flex items-center gap-2">
                <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-mint hover:bg-mint/15" aria-label="WhatsApp">
                    <svg class="h-[18px] w-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
                <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-mint hover:bg-mint/15" aria-label="Instagram">
                    <svg class="h-[18px] w-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>
            <button type="button" id="menu-toggle" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-700 sm:hidden" aria-expanded="false" aria-controls="nav-links">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </nav>
</header>

<main class="px-4 pb-24 pt-6 sm:px-6">

    <!-- Hero -->
    <section class="relative mx-auto max-w-7xl">
        <div class="relative overflow-hidden rounded-5xl bg-mint px-5 pb-44 pt-10 shadow-soft sm:px-10 sm:pb-48 sm:pt-14 lg:px-14 lg:pb-36 lg:pt-16">
            <div class="pointer-events-none absolute inset-0 overflow-hidden rounded-5xl">
                <div class="absolute -left-16 top-10 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute right-[-10%] top-1/4 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute bottom-20 left-1/3 h-48 w-48 rounded-full bg-white/5"></div>
            </div>

            <div class="relative z-10 grid gap-10 lg:grid-cols-12 lg:items-end lg:gap-6">
                <div class="lg:col-span-5">
                    <div class="max-w-lg">
                        <p class="text-xs font-semibold uppercase tracking-widest text-white/80">Sistem Informasi Kesehatan</p>
                        <h2 class="mt-2 text-2xl font-medium text-white/75">
                            <span class="font-bold text-white">S</span>istem <span class="font-bold text-white">De</span>teksi <span class="font-bold text-white">Di</span>ni Penyakit <span class="font-bold text-white">Ti</span>foid
                        </p>
                        <p class="mt-6 text-sm text-justify leading-relaxed text-white/90 sm:text-base">
                        SIDETECT merupakan sistem <b>deteksi dini</b> penyakit <b>Typhoid Fever</b> yang bertujuan untuk membantu proses identifikasi awal kemungkinan terjadinya penyakit typhoid pada pasien berdasarkan gejala yang dialami. Sistem ini dirancang untuk memberikan hasil deteksi secara cepat, akurat, dan mudah digunakan oleh masyarakat umum dan tenaga kesehatan. Dengan adanya SIDETECT, diharapkan proses deteksi dini dapat dilakukan lebih cepat sehingga dapat membantu tenaga medis dalam pengambilan keputusan awal serta meminimalisir keterlambatan penanganan. Selain itu, SIDETECT juga dapat menjadi alat bantu dalam meningkatkan kualitas pelayanan kesehatan, khususnya dalam penanganan penyakit infeksi seperti typhoid fever.
                        </p>
                        <p class="mt-4 text-xs leading-relaxed text-white/75 sm:text-sm">
                            Hasil dari SIDETECT bersifat informatif dan tidak menggantikan pemeriksaan klinis, diagnosis, maupun resep dokter.
                        </p>
                    </div>
                </div>

                <div class="relative lg:col-span-7 lg:min-h-[340px]">
                    <div class="relative mx-auto flex justify-center lg:absolute lg:bottom-0 lg:right-0 lg:mx-0 lg:w-[min(100%,520px)] lg:justify-end">
                        <img
                            src="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>"
                            alt="SIDETECT"
                            class="relative z-[15] max-h-[300px] w-auto max-w-full rounded-3xl object-cover object-center shadow-2xl ring-4 ring-white/20 sm:max-h-[360px] lg:max-h-[400px]"
                            width="520"
                            height="400"
                            loading="eager"
                            decoding="async"
                        >
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 z-20 rounded-tr-[2.5rem] bg-page px-4 py-6 shadow-[4px_-4px_24px_-12px_rgba(0,0,0,0.06)] sm:rounded-tr-[3rem] sm:px-6 sm:py-8">
                <h2 class="text-2xl font-extrabold leading-tight tracking-tight text-gray-900 sm:text-3xl lg:text-[2rem] xl:text-4xl">
                    SIDETECT
                </h2>
            </div>
        </div>
    </section>

    <!-- Definisi penyakit tifoid -->
    <section id="definisi" class="mx-auto mt-20 max-w-7xl scroll-mt-28 lg:mt-28">
        <div class="grid items-start gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="relative overflow-hidden rounded-5xl shadow-soft">
                <img
                    src="https://imgv2-2-f.scribdassets.com/img/document/646685708/original/2dbdd0f48b/1?v=1"
                    alt="Lingkungan layanan kesehatan"
                    class="aspect-[4/3] h-full w-full p-4 object-contain"
                    loading="lazy"
                >
                <div class="pointer-events-none absolute inset-0 rounded-5xl ring-1 ring-inset ring-black/5"></div>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-mint">Memahami penyakit</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Definisi penyakit <span class="text-mint">tifoid</span>
                </h2>
                <div class="mt-6 space-y-4 text-base text-justify leading-relaxed text-gray-600">
                    <p>
                        <strong class="text-gray-900">Tifoid (tifus abdominalis)</strong> adalah infeksi sistemik akut yang umumnya disebabkan bakteri
                        <em>Salmonella Typhi</em>. Bakteri ini banyak ditularkan melalui makanan atau minuman yang terkontaminasi tinja manusia,
                        sering terkait dengan sanitasi air dan kebersihan makanan yang kurang memadai.
                    </p>
                    <p>
                        Penyakit ini dapat menyerupai banyak keluhan umum di awal gejalanya, sehingga penting untuk tidak mengabaikan tanda-tanda yang persisten
                        terutama setelah paparan risiko atau berada di wilayah endemis.
                    </p>
                    <p class="rounded-3xl bg-white p-5 text-sm text-gray-600 shadow-soft ring-1 ring-gray-100">
                        Penegakan diagnosis definitif dilakukan oleh dokter melalui anamnesis, pemeriksaan fisik, serta pemeriksaan penunjang
                        (misalnya kultur darah atau tes serologi) sesuai indikasi klinis.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gejala -->
    <section id="gejala" class="mx-auto mt-24 max-w-7xl scroll-mt-28 lg:mt-32">
        <div class="text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-mint">Kenali tanda-tanda</p>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Gejala yang <span class="text-mint">sering muncul</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-sm text-gray-500 sm:text-base">
                Gejala bervariasi antar individu dan stadium penyakit. Daftar berikut merangkum keluhan yang umum dilaporkan;
                kehadiran salah satu gejala belum tentu berarti Anda menderita tifoid.
            </p>
        </div>

        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            $gejala = [
                ['judul' => 'Demam persisten', 'desc' => 'Demam yang cenderung naik secara bertahap dan dapat berlangsung beberapa hari hingga minggu.'],
                ['judul' => 'Sakit kepala & lemas', 'desc' => 'Keluhan umum infeksi seperti sakit kepala, pegal-pegal, dan rasa tidak bertenaga.'],
                ['judul' => 'Nyeri perut', 'desc' => 'Ketidaknyamanan atau nyeri di area perut, terkadang disertai kembung atau gangguan BAB.'],
                ['judul' => 'Mual atau muntah', 'desc' => 'Gangguan pencernaan ringan hingga sedang pada fase awal.'],
                ['judul' => 'Berkeringat malam', 'desc' => 'Keringat berlebihan pada malam hari tanpa aktivitas berat.'],
                ['judul' => 'Nyeri otot', 'desc' => 'Rasa sakit pada tubuh atau sendi yang menyertai demam.'],
                ['judul' => 'Diare atau sembelit', 'desc' => 'Pola BAB dapat berubah; beberapa pasien mengalami diare, lainnya lebih sembelit.'],
                ['judul' => 'Ruam kulit (rose spots)', 'desc' => 'Pada beberapa kasus muncul bintik merah muda di kulit; tidak selalu terlihat.'],
                ['judul' => 'Penurunan nafsu makan', 'desc' => 'Rasa tidak ingin makan atau cepat kenyang saat demam.'],
            ];
            foreach ($gejala as $g) :
            ?>
            <article class="rounded-4xl bg-white p-6 shadow-soft ring-1 ring-gray-100">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-mint/15 text-mint">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-gray-900"><?= esc($g['judul']) ?></h3>
                <p class="mt-2 text-sm leading-relaxed text-gray-500"><?= esc($g['desc']) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Faktor risiko -->
    <section id="risiko" class="mx-auto mt-24 max-w-7xl scroll-mt-28 lg:mt-32">
        <div class="grid items-stretch gap-10 lg:grid-cols-12 lg:gap-14">
            <div class="relative overflow-hidden rounded-5xl bg-mint p-10 shadow-soft lg:col-span-5 min-h-[260px]">
                <div class="pointer-events-none absolute inset-0">
                    <div class="absolute -right-10 top-10 h-56 w-56 rounded-full bg-white/15"></div>
                    <div class="absolute bottom-8 left-8 h-40 w-40 rounded-full bg-white/10"></div>
                    <div class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/5"></div>
                </div>
                <div class="relative z-10 flex h-full flex-col justify-end">
                    <p class="text-lg font-bold text-white">Proteksi dimulai dari pencegahan</p>
                    <p class="mt-2 max-w-sm text-sm leading-relaxed text-white/90">
                        Memahami faktor risiko membantu Anda menghindari paparan dan mendeteksi kebutuhan konsultasi medis lebih cepat.
                    </p>
                </div>
            </div>
            <div class="lg:col-span-7">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Faktor <span class="text-mint">risiko</span>
                </h2>
                <p class="mt-4 text-sm leading-relaxed text-gray-500 sm:text-base">
                    Beberapa kondisi atau perilaku meningkatkan peluang tertular infeksi <em>Salmonella Typhi</em>. Risiko bersifat kumulatif: semakin banyak faktor yang relevan,
                    semakin penting untuk waspada dan mempertimbangkan pemeriksaan ke tenaga kesehatan.
                </p>
                <ul class="mt-10 space-y-5">
                    <?php
                    $risiko = [
                        ['judul' => 'Sanitasi air dan makanan buruk', 'desc' => 'Mengonsumsi air tidak matang, es tidak steril, atau makanan dari tempat dengan hygiene meragukan.'],
                        ['judul' => 'Riwayat kontak dengan penderita', 'desc' => 'Tinggal serumah atau kontak dekat dengan orang yang didiagnosis atau dicurigai tifoid.'],
                        ['judul' => 'Perjalanan ke daerah endemis', 'desc' => 'Kunjungan ke wilayah dengan insiden tifoid lebih tinggi tanpa vaksinasi atau perilaku hati-hati.'],
                        ['judul' => 'Vaksinasi belum lengkap', 'desc' => 'Belum pernah atau tidak lengkap mendapat imunisasi tifoid sesuai anjuran untuk kelompok risiko.'],
                        ['judul' => 'Sistem imun menurun', 'desc' => 'Kondisi tertentu atau pengobatan yang melemahkan respons imun dapat memperberat infeksi.'],
                        ['judul' => 'Pekerjaan terkait layanan makanan', 'desc' => 'Penanganan makanan tanpa protokol kebersihan ketat meningkatkan risiko penyebaran dan paparan.'],
                    ];
                    foreach ($risiko as $i => $r) :
                        $n = $i + 1;
                    ?>
                    <li class="flex gap-5 rounded-3xl bg-white p-5 shadow-soft ring-1 ring-gray-100">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-mint text-sm font-bold text-white"><?= $n ?></span>
                        <div>
                            <h3 class="font-bold text-gray-900"><?= esc($r['judul']) ?></h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500"><?= esc($r['desc']) ?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <section class="mx-auto mt-20 max-w-7xl rounded-5xl bg-white p-8 shadow-soft ring-1 ring-gray-100 sm:p-10">
        <h2 class="text-xl font-extrabold text-gray-900 sm:text-2xl">Catatan penting</h2>
        <p class="mt-4 text-sm leading-relaxed text-gray-600 sm:text-base">
            SIDETECT menyediakan kerangka informasi untuk mendukung kesadaran dan deteksi dini secara edukatif.
            Jika Anda mengalami gejala yang mengganggu, demam berkelanjutan, atau memiliki faktor risiko yang relevan,
            segera hubungi fasilitas kesehatan atau dokter untuk pemeriksaan lanjutan.
        </p>
    </section>

    <footer class="mx-auto mt-12 max-w-7xl border-t border-gray-200 pt-10 text-center text-sm text-gray-500">
        <p class="font-semibold text-gray-700">&copy; Copyright SIDETECT <?= esc(date('Y')) ?></p>
        <p class="mt-1">Sistem Deteksi Dini Penyakit Tifoid</p>
    </footer>

</main>

<script>
(function () {
    var btn = document.getElementById('menu-toggle');
    var panel = document.getElementById('nav-links');
    if (!btn || !panel) return;
    btn.addEventListener('click', function () {
        var open = panel.classList.toggle('hidden') === false;
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    panel.addEventListener('click', function (e) {
        var target = e.target;
        if (!target || target.tagName !== 'A') return;
        var href = target.getAttribute('href') || '';
        if (href.charAt(0) !== '#') return;
        if (window.matchMedia && window.matchMedia('(min-width: 640px)').matches) return; // sm+
        panel.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
    });
})();
</script>

</body>
</html>
