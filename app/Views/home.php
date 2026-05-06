<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindCare — Medical & Treatment Center</title>
    <meta name="description" content="MindCare — pusat medis dan pengobatan modern untuk Anda.">
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
</head>
<body class="min-h-screen bg-page font-sans text-gray-800 antialiased">

<!-- Top floating nav -->
<header class="sticky top-4 z-50 px-4 sm:px-6">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 rounded-full bg-white px-5 py-3 shadow-nav sm:px-8 sm:py-3.5">
        <a href="#" class="flex shrink-0 items-center gap-2.5">
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-mint shadow-sm ring-4 ring-mint/25">
                <span class="h-4 w-4 rounded-full bg-white/90"></span>
            </span>
            <span class="text-lg font-bold tracking-tight text-gray-900">MindCare</span>
        </a>

        <div id="nav-links" class="absolute left-4 right-4 top-full mt-2 hidden flex flex-col gap-1 rounded-3xl border border-gray-100 bg-white p-4 shadow-soft sm:static sm:mt-0 sm:flex sm:flex-row sm:items-center sm:gap-8 sm:border-0 sm:bg-transparent sm:p-0 sm:shadow-none">
            <?php
            $nav = [
                'Services' => 'services',
                'Specialists' => 'specialists',
                'Prices' => 'prices',
                'Contacts' => 'contacts',
            ];
            foreach ($nav as $label => $hash) :
            ?>
                <a href="#<?= esc($hash, 'attr') ?>" class="rounded-xl px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 sm:py-0 sm:hover:bg-transparent"><?= esc($label) ?></a>
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
            <a href="#" class="hidden items-center gap-1 text-sm font-semibold text-mint hover:text-mint-dark sm:inline-flex">
                Book online
                <span aria-hidden="true">→</span>
            </a>
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
            <!-- Decorative circles -->
            <div class="pointer-events-none absolute inset-0 overflow-hidden rounded-5xl">
                <div class="absolute -left-16 top-10 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute right-[-10%] top-1/4 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute bottom-20 left-1/3 h-48 w-48 rounded-full bg-white/5"></div>
            </div>

            <div class="relative z-10 grid gap-10 lg:grid-cols-12 lg:items-end lg:gap-6">
                <!-- Request form -->
                <div class="lg:col-span-5">
                    <div class="max-w-md">
                        <h1 class="text-2xl font-bold text-white sm:text-3xl">Request a call</h1>
                        <p class="mt-2 max-w-sm text-sm leading-relaxed text-white/85">
                            Leave your details and our coordinator will contact you shortly to schedule a convenient time.
                        </p>
                        <form class="mt-8 space-y-4" action="#" method="post">
                            <?= csrf_field() ?>
                            <input type="text" name="name" placeholder="Name" autocomplete="name"
                                class="w-full rounded-2xl border-0 bg-white px-5 py-3.5 text-gray-900 shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-white/80">
                            <input type="tel" name="phone" placeholder="Phone" autocomplete="tel"
                                class="w-full rounded-2xl border-0 bg-white px-5 py-3.5 text-gray-900 shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-white/80">
                            <button type="submit" class="w-full rounded-2xl bg-white px-6 py-3.5 text-sm font-semibold text-mint shadow-sm transition hover:bg-gray-50">
                                Send Request
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Doctor image -->
                <div class="relative lg:col-span-7 lg:min-h-[340px]">
                    <div class="relative mx-auto flex justify-center lg:absolute lg:bottom-0 lg:right-0 lg:mx-0 lg:w-[min(100%,520px)] lg:justify-end">
                        <img
                            src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=900&q=80"
                            alt="Dokter MindCare"
                            class="relative z-[15] max-h-[340px] w-auto max-w-full object-contain object-bottom drop-shadow-2xl sm:max-h-[400px] lg:max-h-[440px]"
                            width="520"
                            height="560"
                            loading="eager"
                            decoding="async"
                        >
                    </div>
                </div>
            </div>

            <!-- Bottom-left cutout panel (matches page bg + curved join to mint) -->
            <div class="absolute bottom-0 left-0 z-20 w-[min(100%,34rem)] rounded-tr-[2.5rem] bg-page px-6 pb-10 pt-10 shadow-[4px_-4px_24px_-12px_rgba(0,0,0,0.06)] sm:rounded-tr-[3rem] sm:px-10 sm:pb-12 sm:pt-12 lg:w-[min(92%,28rem)] xl:w-[min(90%,32rem)]">
                <h2 class="text-2xl font-extrabold leading-tight tracking-tight text-gray-900 sm:text-3xl lg:text-[2rem] xl:text-4xl">
                    The Best Medical and Treatment Center for You
                </h2>
            </div>

            <!-- Book online — inside mint, bottom right -->
            <a href="#" class="absolute bottom-6 right-6 z-30 inline-flex items-center gap-2 rounded-full bg-white/95 px-5 py-2.5 text-sm font-semibold text-mint shadow-soft backdrop-blur-sm transition hover:bg-white sm:bottom-10 sm:right-10">
                Book online
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>

    <!-- About -->
    <section id="about" class="mx-auto mt-20 max-w-7xl lg:mt-28">
        <div class="grid items-start gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="relative overflow-hidden rounded-5xl shadow-soft">
                <img
                    src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1000&q=80"
                    alt="Interior klinik MindCare"
                    class="aspect-[4/3] h-full w-full object-cover"
                    loading="lazy"
                >
                <div class="pointer-events-none absolute inset-0 rounded-5xl ring-1 ring-inset ring-black/5"></div>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    About Our Center <span class="text-mint">MindCare</span>
                </h2>
                <p class="mt-6 text-base leading-relaxed text-gray-500">
                    We combine evidence-based medicine with a calm, supportive environment. Our team focuses on accurate diagnostics,
                    personalized treatment plans, and long-term wellbeing — so you always feel heard and cared for.
                </p>
                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <article class="flex flex-col justify-between rounded-4xl bg-mint p-6 text-white shadow-soft min-h-[180px]">
                        <span class="text-4xl font-extrabold tracking-tight sm:text-5xl">600</span>
                        <p class="mt-4 text-sm font-medium leading-snug text-white/90">
                            Years of experience of our medical staff
                        </p>
                    </article>
                    <article class="flex flex-col justify-between rounded-4xl bg-white p-6 shadow-soft ring-1 ring-gray-100 min-h-[180px]">
                        <span class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">30</span>
                        <p class="mt-4 text-sm leading-snug text-gray-500">
                            Years our doctors have been caring for the health of the people
                        </p>
                    </article>
                    <article class="flex flex-col justify-between rounded-4xl bg-white p-6 shadow-soft ring-1 ring-gray-100 min-h-[180px]">
                        <span class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">60</span>
                        <p class="mt-4 text-sm leading-snug text-gray-500">
                            Certified specialists in psychology and psychotherapy
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Expert Specialists -->
    <section id="specialists" class="mx-auto mt-24 max-w-7xl lg:mt-32">
        <div class="text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-mint">Meet Our</p>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Expert <span class="text-mint">Specialists</span>
            </h2>
        </div>

        <div class="mt-12 grid gap-6 lg:grid-cols-12 lg:items-stretch">
            <!-- Wider first card -->
            <article class="flex min-h-0 flex-col rounded-5xl bg-white p-8 shadow-soft ring-1 ring-gray-100 lg:col-span-5">
                <div class="flex flex-1 flex-col sm:flex-row sm:gap-6">
                    <div class="mx-auto shrink-0 sm:mx-0">
                        <div class="flex h-36 w-36 items-center justify-center rounded-full bg-mint p-1 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=256&q=80" alt="" class="h-full w-full rounded-full object-cover" loading="lazy">
                        </div>
                    </div>
                    <div class="mt-6 flex flex-1 flex-col text-center sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-bold text-gray-900">Dr. Michael Anderson</h3>
                        <p class="mt-1 text-sm font-semibold text-mint">Chief Doctor</p>
                        <p class="mt-4 flex-1 text-sm leading-relaxed text-gray-500">
                            Leads clinical governance and multidisciplinary care pathways with a focus on patient safety and outcomes.
                        </p>
                    </div>
                </div>
                <a href="#" class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-mint px-6 py-3.5 text-sm font-semibold text-white shadow-soft transition hover:bg-mint-dark lg:w-auto lg:self-start">
                    See All Doctors
                    <span aria-hidden="true">→</span>
                </a>
            </article>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 lg:col-span-7 lg:grid-cols-3">
                <?php
                $doctors = [
                    ['name' => 'Dr. Sarah Mitchell', 'role' => 'Clinical Psychologist', 'img' => 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=256&q=80', 'bio' => 'Specializes in anxiety, mood disorders, and trauma-informed therapy approaches.'],
                    ['name' => 'Dr. James Chen', 'role' => 'Psychiatrist', 'img' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=256&q=80', 'bio' => 'Provides comprehensive psychiatric evaluation and medication management when appropriate.'],
                    ['name' => 'Dr. Elena Volkov', 'role' => 'Therapist', 'img' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=256&q=80', 'bio' => 'Focused on CBT and mindfulness-based interventions for sustainable behavioral change.'],
                ];
                foreach ($doctors as $doc) :
                ?>
                <article class="flex flex-col rounded-5xl bg-white p-6 shadow-soft ring-1 ring-gray-100">
                    <div class="mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-mint p-1">
                        <img src="<?= esc($doc['img']) ?>" alt="" class="h-full w-full rounded-full object-cover" loading="lazy">
                    </div>
                    <h3 class="mt-6 text-center text-base font-bold text-gray-900"><?= esc($doc['name']) ?></h3>
                    <p class="mt-1 text-center text-sm font-semibold text-mint"><?= esc($doc['role']) ?></p>
                    <p class="mt-4 flex-1 text-center text-sm leading-relaxed text-gray-500"><?= esc($doc['bio']) ?></p>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="mx-auto mt-24 max-w-7xl lg:mt-32">
        <div class="grid items-stretch gap-10 lg:grid-cols-12 lg:gap-14">
            <div class="relative overflow-hidden rounded-5xl bg-mint p-10 shadow-soft lg:col-span-5 min-h-[280px]">
                <div class="pointer-events-none absolute inset-0">
                    <div class="absolute -right-10 top-10 h-56 w-56 rounded-full bg-white/15"></div>
                    <div class="absolute bottom-8 left-8 h-40 w-40 rounded-full bg-white/10"></div>
                    <div class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/5"></div>
                </div>
                <div class="relative z-10 flex h-full flex-col justify-end">
                    <p class="text-lg font-bold text-white">Our approach</p>
                    <p class="mt-2 max-w-xs text-sm text-white/85">Structured programs delivered by certified specialists in a comfortable setting.</p>
                </div>
            </div>
            <div class="lg:col-span-7">
                <ul class="space-y-8">
                    <?php
                    $services = [
                        ['title' => 'Cognitive Behavioral Therapy', 'desc' => 'Goal-oriented sessions to reshape unhelpful thoughts and build practical coping skills.'],
                        ['title' => 'Psychiatric Consultation', 'desc' => 'Thorough assessment and evidence-based treatment planning tailored to your needs.'],
                        ['title' => 'Family & Couples Counseling', 'desc' => 'Guided conversations to improve communication and strengthen relationships.'],
                        ['title' => 'Stress & Burnout Programs', 'desc' => 'Structured recovery plans combining therapy, lifestyle guidance, and follow-up care.'],
                    ];
                    foreach ($services as $i => $svc) :
                        $n = $i + 1;
                    ?>
                    <li class="flex gap-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white text-sm font-bold text-mint shadow-soft ring-1 ring-gray-100"><?= $n ?></span>
                        <div>
                            <h3 class="text-lg font-bold text-mint"><?= esc($svc['title']) ?></h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500"><?= esc($svc['desc']) ?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- Prices / Contacts anchors -->
    <section id="prices" class="mx-auto mt-20 max-w-7xl rounded-5xl bg-white p-10 shadow-soft ring-1 ring-gray-100">
        <h2 class="text-2xl font-extrabold text-gray-900">Prices &amp; packages</h2>
        <p class="mt-3 text-gray-500">Contact us for a personalized quote — we’ll recommend the right plan after an initial consultation.</p>
        <a href="#" class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-mint px-6 py-3 text-sm font-semibold text-white hover:bg-mint-dark">Book online <span aria-hidden="true">→</span></a>
    </section>

    <section id="contacts" class="mx-auto mt-10 max-w-7xl text-center text-sm text-gray-500">
        <p>MindCare Medical Center — <?= esc(date('Y')) ?></p>
    </section>

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
})();
</script>

</body>
</html>
