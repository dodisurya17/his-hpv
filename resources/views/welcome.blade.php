<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HIS-HPV — Hadirkan Informasi Seputar Human Papilloma Virus</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon-180.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ============ TOKEN WARNA — diambil langsung dari logo HIS-HPV ============
         Navy dari perisai/tulisan "HIS HPV", merah dari dasi & pita anak-anak di logo.
         Ditulis sebagai CSS variable + hex arbitrary Tailwind (bg-[var(--x)]) supaya
         TIDAK perlu mengubah tailwind.config kamu. Token font (font-display,
         font-body, font-700/800, brand-navy) tetap dipakai dari config lama. --}}
    <style>
        :root {
            --paper: #F5F7FC;
            --navy-900: #0F1B3C;
            --navy-800: #16244F;
            --navy-700: #1E3D7B;
            --navy-600: #2C4E96;
            --navy-100: #E8EDF9;
            --red-600: #D5473E;
            --red-700: #B93A32;
            --red-100: #FCEAE8;
            --gold: #F0B429;
        }

        /* satu-satunya motion di halaman: dua lencana kecil di hero mengambang pelan */
        .float-badge {
            animation: float-y 5s ease-in-out infinite;
        }

        .float-badge.delay {
            animation-delay: 1.2s;
        }

        @keyframes float-y {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .float-badge {
                animation: none;
            }
        }

        .icon-chip svg {
            width: 22px;
            height: 22px;
        }

        [x-cloak] {
            display: none !important;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-white text-slate-600 font-body antialiased">

    {{-- ============ NAVBAR ============ --}}
    <header
        x-data="{
            open: false,
            active: 'beranda',
            initScrollSpy() {
                const ids = ['beranda', 'profil', 'informasi', 'media', 'diskusi', 'kontak'];
                const sections = ids.map(id => document.getElementById(id)).filter(Boolean);
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) this.active = entry.target.id;
                    });
                }, { rootMargin: '-45% 0px -50% 0px', threshold: 0 });
                sections.forEach(el => observer.observe(el));
            }
        }"
        x-init="initScrollSpy()"
        class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200">
        <div class="mx-auto max-w-6xl px-5">
            <div class="flex h-16 items-center justify-between">

                <a href="#beranda" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo HIS-HPV" class="h-9 w-9 rounded-full object-cover ring-2 ring-[var(--navy-700)]/15 ring-offset-2">
                    <span class="font-display font-700 text-lg text-brand-navy tracking-tight">HIS-HPV</span>
                </a>

                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    @foreach ([
                    ['id' => 'beranda', 'label' => 'Beranda'],
                    ['id' => 'profil', 'label' => 'Profil'],
                    ['id' => 'informasi', 'label' => 'Informasi HPV'],
                    ['id' => 'media', 'label' => 'Media Edukasi'],
                    ['id' => 'diskusi', 'label' => 'Diskusi'],
                    ['id' => 'kontak', 'label' => 'Kontak'],
                    ] as $item)
                    <a href="#{{ $item['id'] }}"
                        class="relative pb-1 transition-colors"
                        :class="active === '{{ $item['id'] }}' ? 'text-brand-navy' : 'text-slate-500 hover:text-brand-navy'">
                        {{ $item['label'] }}
                        <span class="absolute -bottom-0.5 left-0 h-[3px] w-full rounded-full bg-[var(--red-600)] transition-opacity duration-200"
                            :class="active === '{{ $item['id'] }}' ? 'opacity-100' : 'opacity-0'"></span>
                    </a>
                    @endforeach
                </nav>

                <a href="#kontak" class="hidden md:inline-flex items-center rounded-full bg-[var(--navy-700)] px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-[var(--navy-700)]/30 hover:bg-[var(--navy-800)] transition-colors">
                    Hubungi Kami
                </a>

                {{-- Mobile hamburger --}}
                <button @click="open = !open" class="md:hidden p-2 -mr-2 text-brand-navy" aria-label="Buka menu">
                    <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Mobile menu --}}
            <nav x-show="open" x-cloak @click="open = false" class="md:hidden pb-4 flex flex-col gap-3 text-sm font-medium border-t border-slate-200 pt-3">
                <a href="#beranda" class="text-brand-navy">Beranda</a>
                <a href="#profil" class="text-slate-500">Profil</a>
                <a href="#informasi" class="text-slate-500">Informasi HPV</a>
                <a href="#media" class="text-slate-500">Media Edukasi</a>
                <a href="#diskusi" class="text-slate-500">Diskusi</a>
                <a href="#kontak" class="text-slate-500">Kontak</a>
            </nav>
        </div>
    </header>

    {{-- ============ HERO ============ --}}
    <section id="beranda" class="relative bg-[var(--paper)] overflow-hidden">
        <div class="mx-auto max-w-6xl px-5 pt-16 pb-20 md:pt-20 md:pb-24">
            <div class="grid md:grid-cols-[1.1fr_0.9fr] gap-14 items-center">

                <div class="text-center md:text-left">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white border border-slate-200 text-[var(--navy-700)] text-xs font-semibold px-3.5 py-1.5 mb-6 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-[var(--red-600)]"></span>
                        Program edukasi & imunisasi HPV
                    </span>

                    <h1 class="font-display font-800 text-4xl sm:text-5xl leading-[1.12] text-brand-navy max-w-lg mx-auto md:mx-0">
                        Mengenal HPV, melindungi langkah anak sejak dini
                    </h1>

                    <p class="mt-5 text-base sm:text-lg text-slate-500 max-w-md mx-auto md:mx-0">
                        Hadirkan Informasi Seputar Human Papilloma Virus (HIS-HPV)
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3.5 justify-center md:justify-start">
                        <a href="#informasi" class="inline-flex justify-center items-center rounded-xl bg-[var(--navy-700)] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[var(--navy-700)]/25 hover:bg-[var(--navy-800)] transition-colors">
                            Pelajari Tentang HPV
                        </a>
                        <a href="#media" class="inline-flex justify-center items-center rounded-xl bg-white border border-slate-200 px-6 py-3 text-sm font-semibold text-brand-navy hover:border-[var(--navy-700)]/40 hover:bg-[var(--navy-100)]/60 transition-colors">
                            Lihat Media Edukasi
                        </a>
                    </div>

                    {{-- Pilar cepat menuju bagian utama --}}
                    <div class="mt-9 flex items-center justify-center md:justify-start gap-5 sm:gap-7 text-xs sm:text-sm font-medium text-slate-500">
                        <a href="#informasi" class="flex items-center gap-1.5 hover:text-[var(--navy-700)] transition-colors">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6c-2-1.4-5-1.8-8-1v12.5c3-.8 6-.4 8 1 2-1.4 5-1.8 8-1V5c-3-.8-6-.4-8 1z" />
                                <path stroke-linecap="round" d="M12 6v12.5" />
                            </svg>
                            Edukasi HPV
                        </a>
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                        <a href="#profil" class="flex items-center gap-1.5 hover:text-[var(--navy-700)] transition-colors">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5.5c0 4.8-3 8-7 9.5-4-1.5-7-4.7-7-9.5V6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4.2" />
                            </svg>
                            Imunisasi Anak
                        </a>
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                        <a href="#diskusi" class="flex items-center gap-1.5 hover:text-[var(--navy-700)] transition-colors">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.4 8.4 0 01-4.5 7.4 8.5 8.5 0 01-8-.4L3 20l1.5-4a8.4 8.4 0 01-1.5-6.5A8.5 8.5 0 0111.5 3 8.4 8.4 0 0121 11.5z" />
                            </svg>
                            Tanya Kami
                        </a>
                    </div>
                </div>

                {{-- Lencana logo — bentuk organik lembut, bukan cincin teks berputar --}}
                <div class="flex justify-center">
                    <div class="relative h-64 w-64 sm:h-80 sm:w-80">
                        <div class="absolute inset-0 bg-gradient-to-br from-[var(--navy-100)] via-[var(--navy-100)] to-white" style="border-radius: 42% 58% 63% 37% / 45% 40% 60% 55%;"></div>
                        <div class="absolute inset-[12%] rounded-full bg-white shadow-[0_25px_50px_-18px_rgba(15,27,60,0.35)] border border-slate-100 flex items-center justify-center p-7">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo HIS-HPV" class="w-full h-full object-contain">
                        </div>

                        <div class="float-badge absolute -left-2 top-6 h-14 w-14 rounded-2xl bg-white shadow-lg shadow-[var(--navy-900)]/10 border border-slate-100 flex items-center justify-center text-[var(--red-600)]">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6.5-4.3-9-9.1C1.4 8.4 3 5 6.3 5c2 0 3.4 1.1 4 2.3C10.9 6.1 12.3 5 14.3 5c3.3 0 4.9 3.4 3.3 6.9-2.5 4.8-9 9.1-9 9.1z" />
                            </svg>
                        </div>
                        <div class="float-badge delay absolute -right-3 bottom-10 h-14 w-14 rounded-2xl bg-white shadow-lg shadow-[var(--navy-900)]/10 border border-slate-100 flex items-center justify-center text-[var(--navy-700)]">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5.5c0 4.8-3 8-7 9.5-4-1.5-7-4.7-7-9.5V6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4.2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ PROFIL ============ --}}
    <section id="profil" class="bg-white py-16 md:py-20">
        <div class="mx-auto max-w-6xl px-5">
            <div class="max-w-lg">
                <span class="text-xs font-semibold text-[var(--red-600)]">Profil</span>
                <h2 class="font-display font-700 text-2xl sm:text-3xl text-brand-navy mt-1">Profil HIS-HPV</h2>
                <p class="mt-2 text-slate-500">Visi & misi kami, serta filosofi di balik logo HIS-HPV.</p>
            </div>

            @php
            $profilMeta = [
            'visi' => ['bg' => 'bg-[var(--navy-100)]', 'text' => 'text-[var(--navy-700)]', 'icon' => '
            <circle cx="12" cy="12" r="8.5" />
            <circle cx="12" cy="12" r="4.5" />
            <circle cx="12" cy="12" r="1" fill="currentColor" stroke="none" />'],
            'misi' => ['bg' => 'bg-[var(--red-100)]', 'text' => 'text-[var(--red-600)]', 'icon' => '
            <circle cx="12" cy="12" r="8.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-2.2 5.8L9 15l2.2-5.8z" fill="currentColor" stroke="none" />'],
            'filosofi_logo' => ['bg' => 'bg-[var(--navy-100)]', 'text' => 'text-[var(--navy-700)]', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5.5c0 4.8-3 8-7 9.5-4-1.5-7-4.7-7-9.5V6z" />'],
            ];
            @endphp

            <div class="mt-10 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="grid sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-slate-200">
                    @foreach ($profilMeta as $key => $meta)
                    @php $block = $profil[$key] ?? null; @endphp
                    <div class="p-8">
                        <div class="icon-chip h-11 w-11 rounded-xl {{ $meta['bg'] }} {{ $meta['text'] }} flex items-center justify-center">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">{!! $meta['icon'] !!}</svg>
                        </div>
                        <p class="font-display font-700 text-brand-navy mt-4">{{ $block->title ?? ucfirst(str_replace('_', ' ', $key)) }}</p>
                        <p class="mt-2 text-sm text-slate-400">{{ $block->description ?? 'Halaman ini sedang disiapkan' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ INFORMASI HPV ============ --}}
    {{-- Layout fleksibel: jumlah kartu mengikuti isi tabel content_blocks (section=informasi),
         tidak lagi dibatasi 3 topik. Warna & ikon kartu diambil bergilir dari $iconPalette,
         modal dilengkapi navigasi Sebelumnya/Selanjutnya + indikator titik agar tetap nyaman
         dijelajahi walau kontennya banyak. --}}
    <section id="informasi" x-data="{
            activeIndex: null,
            total: {{ $informasi->count() }},
            next() { this.activeIndex = (this.activeIndex + 1) % this.total },
            prev() { this.activeIndex = (this.activeIndex - 1 + this.total) % this.total }
        }"
        @keydown.window="if (activeIndex !== null) {
            if ($event.key === 'ArrowRight') next();
            if ($event.key === 'ArrowLeft') prev();
        }"
        class="bg-[var(--paper)] py-16 md:py-20 border-y border-slate-200">
        <div class="mx-auto max-w-6xl px-5">
            <div class="max-w-lg">
                <span class="text-xs font-semibold text-[var(--red-600)]">Informasi HPV</span>
                <h2 class="font-display font-700 text-2xl sm:text-3xl text-brand-navy mt-1">Informasi Seputar HPV</h2>
                <p class="mt-2 text-slate-500">Kumpulan bahasan seputar HPV, klik tiap kartu untuk membaca penjelasan lengkapnya.</p>
            </div>

            @php
            // Palet ikon & warna yang berputar otomatis mengikuti urutan konten,
            // supaya menambah topik baru di admin tidak perlu ubah kode ini.
            $iconPalette = [
            ['gradient' => 'from-[var(--navy-600)] to-[var(--navy-900)]', 'accent' => 'bg-[var(--navy-700)]', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6c-2-1.4-5-1.8-8-1v12.5c3-.8 6-.4 8 1 2-1.4 5-1.8 8-1V5c-3-.8-6-.4-8 1z" />
            <path stroke-linecap="round" d="M12 6v12.5" />'],
            ['gradient' => 'from-[var(--red-600)] to-[var(--red-700)]', 'accent' => 'bg-[var(--red-600)]', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h4l2 7 4-14 2 7h6" />'],
            ['gradient' => 'from-[var(--navy-600)] to-[var(--navy-900)]', 'accent' => 'bg-[var(--navy-700)]', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5.5c0 4.8-3 8-7 9.5-4-1.5-7-4.7-7-9.5V6z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4.2" />'],
            ['gradient' => 'from-[var(--red-600)] to-[var(--red-700)]', 'accent' => 'bg-[var(--red-600)]', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v3.2M12 8a4 4 0 014 4c0 1.8-1.4 2.6-1.4 4.3V18M9.4 16.3V18M12 18v3M9 21h6" />'],
            ['gradient' => 'from-[var(--navy-600)] to-[var(--navy-900)]', 'accent' => 'bg-[var(--navy-700)]', 'icon' => '
            <circle cx="10.5" cy="10.5" r="6.5" />
            <path stroke-linecap="round" d="M20 20l-4.8-4.8" />'],
            ['gradient' => 'from-[var(--red-600)] to-[var(--red-700)]', 'accent' => 'bg-[var(--red-600)]', 'icon' => '
            <circle cx="12" cy="12" r="8.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 9.2a2.5 2.5 0 114.2 1.9c-.9.8-1.7 1.2-1.7 2.4" />
            <circle cx="12" cy="16.6" r=".6" fill="currentColor" stroke="none" />'],
            ];
            @endphp

            <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($informasi as $key => $block)
                @php $meta = $iconPalette[$loop->index % count($iconPalette)]; @endphp
                <button
                    type="button"
                    @click="activeIndex = {{ $loop->index }}"
                    class="group relative text-left overflow-hidden rounded-3xl bg-white border border-slate-200 p-7 hover:shadow-xl hover:shadow-slate-200/70 hover:-translate-y-1 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--navy-700)]/40">
                    <span class="pointer-events-none absolute top-5 right-6 font-display font-800 text-4xl text-slate-100 group-hover:text-slate-200 transition-colors select-none">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <div class="relative h-14 w-14 rounded-2xl bg-gradient-to-br {{ $meta['gradient'] }} flex items-center justify-center text-white shadow-lg shadow-slate-300/50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-7 w-7">{!! $meta['icon'] !!}</svg>
                    </div>

                    <p class="relative font-display font-700 text-lg text-brand-navy mt-5">{{ $block->title ?? ucfirst(str_replace('_', ' ', $key)) }}</p>
                    <span class="relative block h-1 w-8 rounded-full {{ $meta['accent'] }} mt-2.5 mb-4"></span>

                    <p class="relative text-sm leading-relaxed line-clamp-3 {{ $block->description ? 'text-slate-500' : 'text-slate-400 italic' }}">
                        {{ $block->description ?? 'Konten segera hadir' }}
                    </p>

                    <span class="relative mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--navy-700)]">
                        Baca selengkapnya
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </span>
                </button>
                @empty
                <div class="sm:col-span-2 lg:col-span-3 rounded-3xl bg-white border border-dashed border-slate-300 p-10 text-center">
                    <p class="text-sm text-slate-400">Konten informasi HPV sedang disiapkan.</p>
                </div>
                @endforelse
            </div>

            @if ($informasi->hasPages())
            <div class="mt-8">
                {{ $informasi->fragment('informasi')->onEachSide(1)->links('partials.pagination') }}
            </div>
            @endif

            {{-- Modal detail Informasi HPV --}}
            <div
                x-show="activeIndex !== null"
                x-cloak
                class="fixed inset-0 z-50 flex items-end sm:items-center justify-center">

                <div
                    x-show="activeIndex !== null"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="activeIndex = null"
                    class="absolute inset-0 bg-[var(--navy-900)]/60 backdrop-blur-sm"></div>

                <div
                    x-show="activeIndex !== null"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @keydown.window.escape="activeIndex = null"
                    class="relative w-full sm:max-w-xl max-h-[88vh] overflow-hidden rounded-t-3xl sm:rounded-3xl bg-white shadow-2xl flex flex-col">

                    @foreach ($informasi as $key => $block)
                    @php $meta = $iconPalette[$loop->index % count($iconPalette)]; @endphp
                    <div x-show="activeIndex === {{ $loop->index }}" class="flex flex-col max-h-[88vh]">

                        {{-- Header banner --}}
                        <div class="relative bg-gradient-to-br {{ $meta['gradient'] }} px-7 sm:px-8 pt-7 pb-9 shrink-0">
                            <button type="button" @click="activeIndex = null" class="absolute top-5 right-5 p-1.5 rounded-full text-white/80 hover:bg-white/15 hover:text-white transition-colors" aria-label="Tutup">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <div class="h-12 w-12 rounded-2xl bg-white/15 flex items-center justify-center text-white">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-6 w-6">{!! $meta['icon'] !!}</svg>
                            </div>
                            <span class="inline-block mt-4 text-[11px] font-semibold tracking-wide text-white/70 uppercase">
                                Informasi HPV &middot; {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ str_pad($informasi->count(), 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <h3 class="font-display font-700 text-xl sm:text-2xl text-white mt-1.5 pr-8">{{ $block->title ?? ucfirst(str_replace('_', ' ', $key)) }}</h3>
                        </div>

                        {{-- Body --}}
                        <div class="px-7 sm:px-8 py-6 overflow-y-auto">
                            <p class="text-sm sm:text-[15px] leading-relaxed text-slate-600 whitespace-pre-line">
                                {{ $block->description ?? 'Konten segera hadir.' }}
                            </p>
                        </div>

                        {{-- Footer navigasi antar-topik --}}
                        @if ($informasi->count() > 1)
                        <div class="flex items-center justify-between gap-3 border-t border-slate-100 px-7 sm:px-8 py-4 shrink-0 bg-[var(--paper)]">
                            <button type="button" @click="prev()" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[var(--navy-700)] transition-colors">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6" />
                                </svg>
                                Sebelumnya
                            </button>
                            <div class="hidden xs:flex items-center gap-1.5">
                                @foreach ($informasi as $dotKey => $dotBlock)
                                <span class="h-1.5 rounded-full transition-all"
                                    :class="activeIndex === {{ $loop->index }} ? 'w-5 bg-[var(--navy-700)]' : 'w-1.5 bg-slate-300'"></span>
                                @endforeach
                            </div>
                            <button type="button" @click="next()" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[var(--navy-700)] transition-colors">
                                Selanjutnya
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" />
                                </svg>
                            </button>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ MEDIA EDUKASI ============ --}}
    {{-- Tiap kategori cukup menampilkan 1 sampul saja di grid; seluruh isinya
         (bisa banyak) baru dijelajahi lewat modal berbentuk carousel manual —
         berpindah item hanya lewat tombol panah kiri/kanan, tidak auto-scroll. --}}
    @php
    $jenisMedia = [
    'poster' => ['label' => 'Poster', 'icon' => '
    <rect x="4" y="4" width="16" height="16" rx="2" />
    <circle cx="9" cy="9.5" r="1.4" fill="currentColor" stroke="none" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M20 15.5l-4.5-4.5-3.5 3.5-2.5-2.5-5.5 5.5" />'],
    'presentasi' => ['label' => 'Presentasi', 'icon' => '
    <rect x="3" y="4.5" width="18" height="12" rx="2" />
    <path stroke-linecap="round" d="M8 20h8M12 16.5v3.5" />'],
    'video' => ['label' => 'Video', 'icon' => '
    <circle cx="12" cy="12" r="8.5" />
    <path d="M10 8.5l6 3.5-6 3.5z" fill="currentColor" stroke="none" />'],
    ];
    $mediaCounts = collect($jenisMedia)->mapWithKeys(fn ($jenis, $type) => [$type => ($mediaByType[$type] ?? collect())->count()]);

    // Beberapa item Presentasi berupa PDF/PPTX, bukan gambar — jadi tidak bisa
    // asal dipasang ke tag <img>. Helper ini menebak ekstensi file dari URL-nya
    // supaya kita tahu cara terbaik menampilkannya (gambar / PDF / ikon+unduh).
    $fileExt = fn ($url) => strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?: $url, PATHINFO_EXTENSION));
    $imageExts = ['png', 'jpg', 'jpeg', 'gif', 'webp', 'svg', 'bmp'];
    $downloadIcon = '
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2" />';
    $docIcon = '
    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l5 5v13a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1z" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5" />';
    // Nama file saat diunduh disamakan dengan judulnya, bukan nama acak di storage.
    $downloadName = fn ($title, $ext) => \Illuminate\Support\Str::slug($title) . ($ext ? '.' . $ext : '');
    @endphp

    <section id="media"
        x-data="{
            activeMedia: null,
            mediaIndex: 0,
            totals: {{ \Illuminate\Support\Js::from($mediaCounts) }},
            open(type) { this.activeMedia = type; this.mediaIndex = 0 },
            nextMedia() { const t = this.totals[this.activeMedia] || 1; this.mediaIndex = (this.mediaIndex + 1) % t },
            prevMedia() { const t = this.totals[this.activeMedia] || 1; this.mediaIndex = (this.mediaIndex - 1 + t) % t }
        }"
        @keydown.window="if (activeMedia !== null) {
            if ($event.key === 'ArrowRight') nextMedia();
            if ($event.key === 'ArrowLeft') prevMedia();
            if ($event.key === 'Escape') activeMedia = null;
        }"
        class="bg-white py-16 md:py-20">
        <div class="mx-auto max-w-6xl px-5">
            <div class="max-w-lg">
                <span class="text-xs font-semibold text-[var(--red-600)]">Media Edukasi</span>
                <h2 class="font-display font-700 text-2xl sm:text-3xl text-brand-navy mt-1">Media Edukasi</h2>
                <p class="mt-2 text-slate-500">Kumpulan poster, presentasi, dan video edukasi seputar HPV.</p>
            </div>

            {{-- Kartu sampul per kategori --}}
            <div class="mt-10 grid sm:grid-cols-3 gap-6">
                @foreach ($jenisMedia as $type => $jenis)
                @php
                $mediaItems = $mediaByType[$type] ?? collect();
                $cover = $mediaItems->first();
                $coverExt = $cover ? $fileExt($cover->file_url) : null;
                $isCoverImage = $cover && ($type === 'poster' || in_array($coverExt, $imageExts));
                $coverThumb = $cover->thumbnail_url ?? null;
                $isCoverPdfNoThumb = $cover && !$isCoverImage && !$coverThumb && $coverExt === 'pdf';
                @endphp
                <div class="group rounded-2xl bg-white border border-slate-200 overflow-hidden hover:shadow-lg hover:shadow-slate-200/70 transition-shadow">
                    <div class="relative aspect-[4/3] bg-[var(--navy-100)]/60 flex items-center justify-center text-[var(--navy-700)] overflow-hidden {{ $cover ? 'cursor-pointer' : '' }}"
                        @if ($cover) @click="open('{{ $type }}')" @endif>
                        @if ($isCoverImage)
                        <img src="{{ $cover->file_url }}" alt="{{ $cover->title }}" class="w-full h-full object-cover">
                        @elseif ($cover && $type === 'video')
                        <video src="{{ $cover->file_url }}" poster="{{ $coverThumb }}" class="w-full h-full object-cover" preload="metadata" muted></video>
                        @if ($cover)
                        <span class="pointer-events-none absolute inset-0 flex items-center justify-center">
                            <span class="h-11 w-11 rounded-full bg-white/85 flex items-center justify-center text-[var(--navy-700)] shadow-md">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">{!! $jenis['icon'] !!}</svg>
                            </span>
                        </span>
                        @endif
                        @elseif ($coverThumb)
                        {{-- Thumbnail halaman/slide pertama, dibuat otomatis saat file diunggah --}}
                        <img src="{{ $coverThumb }}" alt="{{ $cover->title }}" class="w-full h-full object-cover">
                        <span class="absolute bottom-2 left-2 text-[10px] font-bold tracking-wide text-white bg-[var(--red-600)] rounded px-1.5 py-0.5">{{ strtoupper($coverExt) }}</span>
                        @elseif ($isCoverPdfNoThumb)
                        {{-- Fallback: thumbnail belum sempat dibuat di server, tampilkan viewer PDF bawaan browser --}}
                        <iframe src="{{ $cover->file_url }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH" class="w-full h-full pointer-events-none bg-white" loading="lazy" title="{{ $cover->title }}"></iframe>
                        <span class="absolute bottom-2 left-2 text-[10px] font-bold tracking-wide text-white bg-[var(--red-600)] rounded px-1.5 py-0.5">PDF</span>
                        @elseif ($cover)
                        {{-- File non-gambar tanpa thumbnail (mis. .pptx saat server belum bisa mengonversi) --}}
                        <div class="flex flex-col items-center gap-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-10 w-10">{!! $docIcon !!}</svg>
                            <span class="text-[11px] font-bold uppercase tracking-wide text-[var(--navy-700)]">{{ $coverExt ?: 'File' }}</span>
                        </div>
                        @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-10 w-10">{!! $jenis['icon'] !!}</svg>
                        @endif

                        @if ($cover)
                        <span class="pointer-events-none absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></span>
                        @endif

                        {{-- Badge jumlah item --}}
                        @if ($mediaItems->count() > 0)
                        <span class="absolute top-3 right-3 text-[11px] font-semibold text-white bg-black/45 backdrop-blur-sm rounded-full px-2.5 py-1">
                            {{ $mediaItems->count() }} item
                        </span>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="flex items-center gap-1.5 mb-1.5 text-[11px] font-semibold text-[var(--red-600)] uppercase tracking-wide">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">{!! $jenis['icon'] !!}</svg>
                            {{ $jenis['label'] }}
                        </div>

                        @if ($cover)
                        <p class="text-sm font-medium text-slate-700 truncate">{{ $cover->title }}</p>
                        @if ($cover->description)
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $cover->description }}</p>
                        @endif

                        <button type="button" @click="open('{{ $type }}')"
                            class="mt-3.5 inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--navy-700)] hover:text-[var(--navy-800)] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--navy-700)]/40 rounded">
                            Lihat selengkapnya
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                            </svg>
                        </button>
                        @else
                        <p class="text-sm font-medium text-slate-400 italic">Segera hadir</p>
                        <p class="text-xs text-slate-400 mt-1">Konten {{ strtolower($jenis['label']) }} belum tersedia.</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Modal carousel Media Edukasi (manual, tidak auto-scroll) --}}
            <div x-show="activeMedia !== null" x-cloak class="fixed inset-0 z-50 flex items-end sm:items-center justify-center">

                <div
                    x-show="activeMedia !== null"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="activeMedia = null"
                    class="absolute inset-0 bg-[var(--navy-900)]/70 backdrop-blur-sm"></div>

                <div
                    x-show="activeMedia !== null"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="relative w-full sm:max-w-3xl lg:max-w-4xl max-h-[94vh] overflow-hidden rounded-t-3xl sm:rounded-3xl bg-white shadow-2xl flex flex-col">

                    <button type="button" @click="activeMedia = null"
                        class="absolute top-4 right-4 z-10 h-9 w-9 rounded-full bg-black/40 hover:bg-black/60 text-white flex items-center justify-center transition-colors" aria-label="Tutup">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    @foreach ($jenisMedia as $type => $jenis)
                    @php $mediaItems = $mediaByType[$type] ?? collect(); @endphp
                    @if ($mediaItems->isNotEmpty())
                    <div x-show="activeMedia === '{{ $type }}'" class="flex flex-col max-h-[92vh]">

                        {{-- Kanvas gambar/video/PDF + panah carousel --}}
                        <div class="relative bg-slate-900 aspect-[4/3] sm:aspect-[16/10] shrink-0 overflow-hidden">
                            @foreach ($mediaItems as $item)
                            @php
                            $ext = $fileExt($item->file_url);
                            $isImage = $type === 'poster' || in_array($ext, $imageExts);
                            $thumb = $item->thumbnail_url ?? null;
                            $isPdf = !$isImage && !$thumb && $ext === 'pdf';
                            @endphp
                            <div x-show="activeMedia === '{{ $type }}' && mediaIndex === {{ $loop->index }}" class="absolute inset-0 flex items-center justify-center">
                                @if ($type === 'video')
                                <video src="{{ $item->file_url }}" poster="{{ $thumb }}" class="w-full h-full object-contain" controls preload="metadata"></video>
                                @elseif ($isImage)
                                <img src="{{ $item->file_url }}" alt="{{ $item->title }}" class="w-full h-full object-contain bg-white">
                                @elseif ($thumb)
                                {{-- Thumbnail halaman/slide pertama, dibuat otomatis saat file diunggah --}}
                                <img src="{{ $thumb }}" alt="{{ $item->title }}" class="w-full h-full object-contain bg-white">
                                @elseif ($isPdf)
                                {{-- Fallback: thumbnail belum sempat dibuat di server, tampilkan viewer PDF bawaan browser --}}
                                <iframe src="{{ $item->file_url }}#toolbar=0&navpanes=0&view=FitH" class="w-full h-full bg-white" title="{{ $item->title }}"></iframe>
                                @else
                                {{-- File non-gambar tanpa thumbnail (mis. .pptx saat server belum bisa mengonversi) --}}
                                <div class="flex flex-col items-center gap-4 text-center px-6">
                                    <div class="h-20 w-20 rounded-2xl bg-white/10 flex items-center justify-center text-white">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" class="h-10 w-10">{!! $docIcon !!}</svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold text-sm uppercase tracking-wide">{{ $ext ?: 'File' }}</p>
                                        <p class="text-white/60 text-xs mt-1 max-w-[220px]">Pratinjau belum tersedia untuk tipe file ini — unduh untuk membukanya.</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach

                            {{-- Tombol unduh — selalu tampil di setiap item, nama file disamakan dengan judulnya --}}
                            @foreach ($mediaItems as $item)
                            @php $ext = $fileExt($item->file_url); @endphp
                            <a x-show="activeMedia === '{{ $type }}' && mediaIndex === {{ $loop->index }}"
                                href="{{ $item->file_url }}" target="_blank" download="{{ $downloadName($item->title, $ext) }}"
                                class="absolute top-3 left-3 inline-flex items-center gap-1.5 rounded-full bg-white/90 hover:bg-white text-[var(--navy-700)] text-xs font-semibold px-3.5 py-2 shadow-md transition-colors">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5">{!! $downloadIcon !!}</svg>
                                Unduh
                            </a>
                            @endforeach

                            @if ($mediaItems->count() > 1)
                            <button type="button" @click="prevMedia()"
                                class="absolute left-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-white/90 hover:bg-white text-[var(--navy-700)] shadow-md flex items-center justify-center transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white" aria-label="Sebelumnya">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6" />
                                </svg>
                            </button>
                            <button type="button" @click="nextMedia()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-white/90 hover:bg-white text-[var(--navy-700)] shadow-md flex items-center justify-center transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white" aria-label="Selanjutnya">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6" />
                                </svg>
                            </button>

                            <span class="absolute bottom-3 right-3 text-[11px] font-semibold text-white bg-black/50 backdrop-blur-sm rounded-full px-2.5 py-1">
                                <span x-text="String(mediaIndex + 1).padStart(2, '0')"></span>
                                / {{ str_pad($mediaItems->count(), 2, '0', STR_PAD_LEFT) }}
                            </span>
                            @endif
                        </div>

                        {{-- Detail teks --}}
                        <div class="px-6 sm:px-8 py-5 sm:py-6 overflow-y-auto">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-[var(--red-600)] uppercase tracking-wide">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">{!! $jenis['icon'] !!}</svg>
                                {{ $jenis['label'] }}
                            </span>

                            @foreach ($mediaItems as $item)
                            <div x-show="activeMedia === '{{ $type }}' && mediaIndex === {{ $loop->index }}">
                                <h3 class="font-display font-700 text-lg sm:text-xl text-brand-navy mt-2">{{ $item->title }}</h3>
                                <p class="text-sm leading-relaxed text-slate-600 mt-2 whitespace-pre-line">
                                    {{ $item->description ?? 'Belum ada deskripsi untuk media ini.' }}
                                </p>
                                <a href="{{ $item->file_url }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 mt-4 text-sm font-semibold text-[var(--navy-700)] hover:text-[var(--navy-800)] transition-colors">
                                    Buka file asli
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M8 7h9v9" />
                                    </svg>
                                </a>
                            </div>
                            @endforeach
                        </div>

                        {{-- Indikator titik --}}
                        @if ($mediaItems->count() > 1)
                        <div class="flex items-center justify-center gap-1.5 border-t border-slate-100 py-3.5 shrink-0 bg-[var(--paper)]">
                            @foreach ($mediaItems as $item)
                            <button type="button" @click="mediaIndex = {{ $loop->index }}"
                                class="h-1.5 rounded-full transition-all"
                                :class="(activeMedia === '{{ $type }}' && mediaIndex === {{ $loop->index }}) ? 'w-5 bg-[var(--navy-700)]' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                                aria-label="Ke item {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ DISKUSI ============ --}}
    <section id="diskusi" class="bg-[var(--paper)] py-16 md:py-20 border-y border-slate-200">
        <div class="mx-auto max-w-6xl px-5">
            <div class="max-w-lg">
                <span class="text-xs font-semibold text-[var(--red-600)]">Box Diskusi</span>
                <h2 class="font-display font-700 text-2xl sm:text-3xl text-brand-navy mt-1">Box Diskusi</h2>
                <p class="mt-2 text-slate-500">Ajukan pertanyaan seputar HPV, pertanyaan dan jawaban akan tampil di sini untuk semua pengunjung.</p>
            </div>

            @if (session('status'))
            <div class="mt-6 max-w-xl rounded-xl bg-green-50 text-green-700 text-sm px-4 py-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('diskusi.store') }}" class="mt-8 max-w-xl rounded-2xl bg-white border border-slate-200 shadow-sm p-5 space-y-3">
                @csrf
                <div>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Anda (opsional, kosongkan untuk anonim)"
                        class="w-full rounded-xl border border-slate-200 bg-[var(--paper)] px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="question" value="{{ old('question') }}" placeholder="Tulis pertanyaan Anda di sini..."
                        class="flex-1 rounded-xl border border-slate-200 bg-[var(--paper)] px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[var(--navy-700)] px-5 py-3 text-sm font-semibold text-white hover:bg-[var(--navy-800)] transition-colors">
                        Kirim
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2l-7 20-4-9-9-4z" />
                        </svg>
                    </button>
                </div>
                @error('question')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                <p class="text-xs text-slate-400">Setiap pertanyaan akan tampil bersama jawabannya dalam satu box.</p>
            </form>

            <div class="mt-8 grid sm:grid-cols-2 gap-5">
                @forelse ($discussions as $d)
                <div class="rounded-2xl bg-white border border-slate-200 p-5 hover:shadow-md hover:shadow-slate-200/60 transition-shadow">
                    <div class="flex items-start gap-3">
                        <div class="h-9 w-9 shrink-0 rounded-full bg-[var(--navy-100)] text-[var(--navy-700)] flex items-center justify-center text-sm font-bold">
                            {{ mb_strtoupper(mb_substr($d->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="text-sm font-semibold text-brand-navy">{{ $d->name }}</p>
                                <span class="text-slate-300">&middot;</span>
                                <p class="text-xs text-slate-400">{{ ($d->answered_at ?? $d->created_at)->diffForHumans() }}</p>
                            </div>
                            <p class="mt-1 text-sm text-slate-600 break-words">{{ $d->question }}</p>

                            <div class="mt-3 rounded-xl bg-[var(--paper)] border border-slate-100 px-4 py-3">
                                <p class="flex items-center gap-1.5 text-xs font-semibold text-[var(--red-600)] mb-1">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $d->answeredBy->name ?? 'Admin' }}
                                </p>
                                <p class="text-sm text-slate-600 break-words">{{ $d->answer }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="sm:col-span-2 rounded-2xl bg-white border border-dashed border-slate-300 p-8 text-center">
                    <p class="text-sm text-slate-400">Belum ada pertanyaan yang dijawab. Jadilah yang pertama bertanya!</p>
                </div>
                @endforelse
            </div>

            @if ($discussions->hasPages())
            <div class="mt-6">
                {{ $discussions->fragment('diskusi')->onEachSide(1)->links('partials.pagination') }}
            </div>
            @endif
        </div>
    </section>

    {{-- ============ KONTAK ============ --}}
    <section id="kontak" class="relative bg-[var(--navy-900)] py-16 md:py-20 overflow-hidden">
        <svg viewBox="0 0 200 200" class="absolute -right-12 -top-12 h-64 w-64 opacity-[0.08]" fill="none" stroke="white" stroke-width="1.5">
            <circle cx="100" cy="100" r="90" />
            <circle cx="100" cy="100" r="65" />
        </svg>
        <svg viewBox="0 0 200 200" class="absolute -left-16 -bottom-16 h-56 w-56 opacity-[0.06]" fill="none" stroke="white" stroke-width="1.5">
            <circle cx="100" cy="100" r="90" />
        </svg>
        <div class="mx-auto max-w-6xl px-5 text-center relative">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 text-white text-xs font-semibold px-3.5 py-1.5 mb-5">
                <span class="h-1.5 w-1.5 rounded-full bg-[var(--red-600)]"></span>
                Kontak
            </span>
            <h2 class="font-display font-700 text-2xl sm:text-3xl text-white">Punya pertanyaan seputar HPV?</h2>
            <p class="mt-2 text-white/70 max-w-md mx-auto">Hubungi kami melalui e-mail, tim kami akan membalas secepatnya.</p>
            <a href="mailto:{{ config('mail.from.address') }}?subject={{ urlencode('Pertanyaan seputar HPV') }}" class="inline-flex items-center gap-2 mt-7 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-[var(--navy-800)] hover:bg-white/90 transition-colors">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="h-4 w-4">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6" />
                </svg>
                Kirim E-mail
            </a>
        </div>
    </section>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-white py-8 border-t border-slate-200">
        <div class="mx-auto max-w-6xl px-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-400">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo HIS-HPV" class="h-6 w-6 rounded-full object-cover">
                <span>© {{ date('Y') }} HIS-HPV</span>
            </div>
            <span>Hadirkan Informasi Seputar Human Papilloma Virus</span>
        </div>
    </footer>

    {{-- ============ FLOATING RATING BUTTON + MODAL ============ --}}
    <div x-data="{ open: false, rating: 0, hoverRating: 0 }" @keydown.window.escape="open = false">

        <button type="button" @click="open = true; rating = 0"
            class="fixed bottom-5 right-5 z-40 flex items-center gap-2 rounded-full bg-[var(--navy-700)] shadow-lg shadow-[var(--navy-900)]/30 px-4 py-2.5 text-sm font-medium text-white hover:bg-[var(--navy-800)] transition-colors">
            <svg class="h-4 w-4 text-[var(--gold)]" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
            </svg>
            Beri Penilaian
        </button>

        {{-- Modal rating --}}
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-end sm:items-center justify-center">

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="open = false"
                class="absolute inset-0 bg-[var(--navy-900)]/60 backdrop-blur-sm"></div>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="relative w-full sm:max-w-sm rounded-t-3xl sm:rounded-3xl bg-white p-7 shadow-2xl text-center">

                <button type="button" @click="open = false" class="absolute top-4 right-4 p-1.5 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors" aria-label="Tutup">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="h-12 w-12 mx-auto rounded-2xl bg-[var(--navy-100)] flex items-center justify-center text-[var(--gold)]">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                    </svg>
                </div>

                <h3 class="font-display font-700 text-lg text-brand-navy mt-4">Bagaimana pengalaman Anda?</h3>
                <p class="text-sm text-slate-500 mt-1">Beri penilaian untuk website HIS-HPV ini.</p>

                <form method="POST" action="{{ route('feedback.store') }}" class="mt-5">
                    @csrf
                    <input type="hidden" name="rating" :value="rating">

                    <div class="flex items-center justify-center gap-1.5" @mouseleave="hoverRating = 0">
                        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                            <button type="button"
                                @click="rating = star"
                                @mouseenter="hoverRating = star"
                                class="p-1 transition-transform hover:scale-110 focus:outline-none"
                                :aria-label="`Beri ${star} bintang`">
                                <svg class="h-8 w-8 transition-colors" :class="(hoverRating || rating) >= star ? 'text-[var(--gold)]' : 'text-slate-200'" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                                </svg>
                            </button>
                        </template>
                    </div>

                    <p class="mt-2 text-xs font-medium h-4" :class="rating ? 'text-[var(--navy-700)]' : 'text-transparent'"
                        x-text="({1: 'Kurang memuaskan', 2: 'Cukup', 3: 'Baik', 4: 'Sangat baik', 5: 'Luar biasa!'})[rating] || '-'"></p>

                    @error('rating')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror

                    <button type="submit" :disabled="rating === 0"
                        class="mt-5 w-full inline-flex justify-center items-center rounded-xl bg-[var(--navy-700)] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[var(--navy-700)]/25 hover:bg-[var(--navy-800)] disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                        Kirim Penilaian
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Toast terima kasih, muncul setelah rating berhasil dikirim --}}
    @if (session('rating_status'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition
        class="fixed bottom-24 right-5 z-50 max-w-xs rounded-2xl bg-white border border-slate-200 shadow-xl px-4 py-3 flex items-start gap-3">
        <div class="h-8 w-8 shrink-0 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <p class="text-sm text-slate-600">{{ session('rating_status') }}</p>
    </div>
    @endif

</body>

</html>