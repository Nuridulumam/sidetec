<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin — Sidetec</title>
    <link rel="icon" type="image/png" href="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>">
    <link rel="apple-touch-icon" href="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { mint: { DEFAULT: '#58C2B3', dark: '#4aa899' } },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
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
    </style>
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-900 px-4 font-sans antialiased">

<div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl shadow-black/30 ring-1 ring-slate-200">
    <div class="flex items-center gap-3">
        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-mint text-base font-bold text-white">SD</span>
        <div>
            <p class="text-lg font-bold text-slate-900">Sidetec Admin</p>
            <p class="text-xs text-slate-500">Sistem Deteksi Dini Penyakit Tifoid</p>
        </div>
    </div>

    <?php if ($msg = session()->getFlashdata('message')) : ?>
        <div class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800"><?= esc($msg) ?></div>
    <?php endif; ?>

    <?php if ($err = session()->getFlashdata('error')) : ?>
        <div class="mt-6 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700"><?= esc($err) ?></div>
    <?php endif; ?>

    <?php
    $flashErrors = session()->getFlashdata('errors');
    if (is_array($flashErrors) && $flashErrors !== []) :
    ?>
        <ul class="mt-6 list-inside list-disc rounded-xl bg-amber-50 px-4 py-3 text-sm text-amber-900">
            <?php foreach ($flashErrors as $e) : ?>
                <li><?= esc(is_array($e) ? implode(', ', $e) : (string) $e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= esc(site_url('admin/login'), 'attr') ?>" method="post" class="mt-8 space-y-5">
        <?= csrf_field() ?>
        <div>
            <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
            <input type="text" name="username" id="username" value="<?= esc(old('username')) ?>"
                   class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                   autocomplete="username" required>
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Kata sandi</label>
            <input type="password" name="password" id="password"
                   class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 shadow-sm focus:border-mint focus:outline-none focus:ring-2 focus:ring-mint/30"
                   autocomplete="current-password" required minlength="8">
        </div>
        <button type="submit" class="w-full rounded-xl bg-mint py-3 text-sm font-semibold text-white shadow-lg shadow-mint/25 transition hover:bg-mint-dark">
            Masuk
        </button>
    </form>

     <p class="mt-8 text-center text-xs text-slate-400">
         Default dev: <code class="rounded bg-slate-100 px-1">syukri</code> /
         <code class="rounded bg-slate-100 px-1">admin123</code>
     </p>
</div>

</body>
</html>
