<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> — SIDETECT</title>
    <link rel="icon" type="image/png" href="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>">
    <link rel="apple-touch-icon" href="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        mint: { DEFAULT: '#58C2B3', dark: '#4aa899' },
                    },
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
<body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-slate-800 bg-slate-900 text-slate-100 lg:static">
        <div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-800 px-5">
            <img
                src="<?= esc(base_url('assets/images/logo_sidetect.png'), 'attr') ?>"
                alt="SIDETECT"
                class="h-10 w-10 rounded-xl bg-white p-1 object-contain"
                loading="lazy"
            />
            <div>
                <p class="text-sm font-semibold text-white">SIDETECT</p>
                <p class="text-xs text-slate-400">Web Backoffice</p>
            </div>
        </div>

        <nav class="flex flex-1 flex-col gap-1 overflow-y-auto px-3 py-5">
            <?php
            $role = session()->get('admin_role');
            $navMain = [
                ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => site_url('admin'), 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                ['key' => 'pasien', 'label' => 'Pasien', 'href' => site_url('admin/pasien'), 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ];

            if (in_array($role, ['petugas sik', 'admin', 'superadmin'], true)) {
                $navMain[] = ['key' => 'rules', 'label' => 'Rule Klasifikasi', 'href' => site_url('admin/rule-klasifikasi'), 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'];
            }

            if (in_array($role, ['petugas poli', 'admin', 'superadmin'], true)) {
                $navMain[] = ['key' => 'laporan', 'label' => 'Laporan', 'href' => site_url('admin/laporan'), 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'];
            }

            $active = $active ?? 'dashboard';
            foreach ($navMain as $item) :
                $isActive = $active === $item['key'];
            ?>
            <a href="<?= esc($item['href'], 'attr') ?>"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?= $isActive ? 'bg-mint text-white shadow-lg shadow-mint/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>">
                <svg class="h-5 w-5 shrink-0 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="<?= esc($item['icon'], 'attr') ?>"/></svg>
                <?= esc($item['label']) ?>
            </a>
            <?php endforeach; ?>
        </nav>

        <div class="shrink-0 border-t border-slate-800 px-3 py-4">
            <?php if (in_array($role, ['admin', 'superadmin'], true)) : ?>
                <?php $usersActive = ($active === 'users'); ?>
                <a href="<?= esc(site_url('admin/users'), 'attr') ?>"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition <?= $usersActive ? 'bg-mint text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manage User
                </a>
            <?php endif; ?>
            <a href="<?= esc(site_url('admin/logout'), 'attr') ?>"
               class="mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-red-300 transition hover:bg-red-950/50 hover:text-red-200">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </a>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex min-h-screen min-w-0 flex-1 flex-col lg:ml-0 lg:pl-0 ml-64">
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/90 px-6 backdrop-blur">
            <h1 class="text-lg font-semibold text-slate-900"><?= esc($title ?? '') ?></h1>
            <div class="text-right text-sm">
                <p class="font-medium text-slate-800"><?= esc(session('admin_name') ?? '') ?></p>
                <p class="text-xs text-slate-500"><?= esc(session('admin_email') ?? '') ?></p>
            </div>
        </header>

        <main class="flex-1 p-6 lg:p-8 space-y-4">
            <?php if ($m = session()->getFlashdata('message')) : ?>
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900"><?= esc($m) ?></div>
            <?php endif; ?>
            <?php if ($e = session()->getFlashdata('error')) : ?>
                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"><?= esc($e) ?></div>
            <?php endif; ?>
            <?= $mainView ?>
        </main>
    </div>
</div>

</body>
</html>
