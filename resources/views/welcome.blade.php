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
         TIDAK perlu mengubah tailwind.config kamu. --}}
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

        /* sembunyikan scrollbar halaman utama (halaman tetap bisa di-scroll) */
        html {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* Edge lama / IE */
        }

        html::-webkit-scrollbar {
            display: none;
            /* Chrome, Edge, Safari */
        }

        /* scrollbar modern & tipis untuk semua area scroll di dalam modal */
        [role="dialog"] .overflow-y-auto {
            scrollbar-width: thin;
            /* Firefox */
            scrollbar-color: rgba(30, 61, 123, 0.28) transparent;
        }

        [role="dialog"] .overflow-y-auto::-webkit-scrollbar {
            width: 10px;
        }

        [role="dialog"] .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
            margin: 10px 0;
        }

        [role="dialog"] .overflow-y-auto::-webkit-scrollbar-thumb {
            background-color: rgba(30, 61, 123, 0.28);
            border-radius: 9999px;
            /* border transparan membuat thumb tampak lebih ramping & melayang */
            border: 3px solid transparent;
            background-clip: content-box;
            transition: background-color .2s;
        }

        [role="dialog"] .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background-color: rgba(30, 61, 123, 0.55);
        }

        [role="dialog"] .overflow-y-auto::-webkit-scrollbar-thumb:active {
            background-color: var(--navy-700);
        }

        [role="dialog"] .overflow-y-auto::-webkit-scrollbar-button {
            display: none;
            /* hilangkan tombol panah atas/bawah */
        }

        /* dua lencana kecil di hero mengambang pelan */
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

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    {{-- ============ LOGIKA HALAMAN (Alpine) ============
         Satu "state" pusat untuk semua modal. Menu navbar tidak lagi scroll ke section,
         melainkan memanggil openModal('<id>'). URL ikut diberi hash (#profil, #informasi, dst)
         sehingga link langsung, pagination, dan redirect form tetap membuka modal yang benar. --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('hisHpv', (cfg) => ({
                // ---- modal utama ----
                modalOpen: false,
                modal: 'profil', // sengaja tidak di-reset saat ditutup, supaya isi modal tidak "kosong" saat animasi keluar
                mobileMenu: false,

                // ---- detail Informasi HPV ----
                infoOpen: false,
                infoIdx: 0,
                infoTotal: cfg.infoTotal || 0,

                // ---- carousel Media Edukasi ----
                mediaOpen: false,
                activeMedia: 'poster',
                mediaIndex: 0,
                mediaTotals: cfg.mediaTotals || {},

                // ---- penilaian ----
                ratingOpen: false,
                rating: 0,
                hoverRating: 0,

                meta: {
                    profil: {
                        title: 'Profil HIS-HPV',
                        desc: 'Visi & misi kami, serta filosofi di balik logo HIS-HPV.',
                        size: 'sm:max-w-4xl'
                    },
                    informasi: {
                        title: 'Informasi Seputar HPV',
                        desc: 'Kumpulan bahasan seputar HPV. Pilih salah satu kartu untuk membaca penjelasan lengkapnya.',
                        size: 'sm:max-w-5xl'
                    },
                    media: {
                        title: 'Media Edukasi',
                        desc: 'Kumpulan poster, presentasi, dan video edukasi seputar HPV.',
                        size: 'sm:max-w-5xl'
                    },
                    diskusi: {
                        title: 'Box Diskusi',
                        desc: 'Ajukan pertanyaan seputar HPV. Pertanyaan dan jawabannya akan tampil di sini untuk semua pengunjung.',
                        size: 'sm:max-w-4xl'
                    },
                    kontak: {
                        title: 'Punya pertanyaan seputar HPV?',
                        desc: 'Hubungi kami melalui e-mail, tim kami akan membalas secepatnya.',
                        size: 'sm:max-w-lg'
                    }
                },

                init() {
                    const fromHash = () => {
                        const id = location.hash.slice(1);
                        if (this.meta[id]) this.openModal(id);
                        else if (this.modalOpen) this.closeModal(false);
                    };

                    // Prioritas: hasil server (mis. validasi form gagal) > hash di URL
                    if (cfg.initial) this.openModal(cfg.initial);
                    else fromHash();

                    if (cfg.ratingError) this.ratingOpen = true;

                    window.addEventListener('hashchange', fromHash);
                },

                isActive(id) {
                    return id === 'beranda' ? !this.modalOpen : (this.modalOpen && this.modal === id);
                },

                nav(id) {
                    this.mobileMenu = false;
                    if (id === 'beranda') this.goHome();
                    else this.openModal(id);
                },

                goHome() {
                    this.closeModal();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                openModal(id) {
                    if (!this.meta[id]) return;
                    this.mobileMenu = false;
                    this.infoOpen = false;
                    this.mediaOpen = false;
                    this.modal = id;
                    this.modalOpen = true;
                    history.replaceState(null, '', '#' + id);
                    this.$nextTick(() => {
                        if (this.$refs.modalBody) this.$refs.modalBody.scrollTop = 0;
                        if (this.$refs.modalPanel) this.$refs.modalPanel.focus({
                            preventScroll: true
                        });
                    });
                },

                closeModal(updateUrl = true) {
                    this.modalOpen = false;
                    this.infoOpen = false;
                    this.mediaOpen = false;
                    if (updateUrl && location.hash) {
                        history.replaceState(null, '', location.pathname + location.search);
                    }
                },

                // ---- Informasi HPV ----
                openInfo(i) {
                    this.infoIdx = i;
                    this.infoOpen = true;
                },
                infoNext() {
                    if (this.infoTotal) this.infoIdx = (this.infoIdx + 1) % this.infoTotal;
                },
                infoPrev() {
                    if (this.infoTotal) this.infoIdx = (this.infoIdx - 1 + this.infoTotal) % this.infoTotal;
                },

                // ---- Media Edukasi ----
                openMedia(type) {
                    this.activeMedia = type;
                    this.mediaIndex = 0;
                    this.mediaOpen = true;
                },
                mediaNext() {
                    const t = this.mediaTotals[this.activeMedia] || 1;
                    this.mediaIndex = (this.mediaIndex + 1) % t;
                },
                mediaPrev() {
                    const t = this.mediaTotals[this.activeMedia] || 1;
                    this.mediaIndex = (this.mediaIndex - 1 + t) % t;
                },

                // ---- keyboard: Esc menutup lapisan paling atas, panah untuk geser ----
                onKey(e) {
                    if (e.key === 'Escape') {
                        if (this.ratingOpen) this.ratingOpen = false;
                        else if (this.infoOpen) this.infoOpen = false;
                        else if (this.mediaOpen) this.mediaOpen = false;
                        else if (this.modalOpen) this.closeModal();
                        return;
                    }
                    if (e.target && ['INPUT', 'TEXTAREA', 'VIDEO'].includes(e.target.tagName)) return;
                    if (this.ratingOpen) return;
                    if (this.infoOpen) {
                        if (e.key === 'ArrowRight') this.infoNext();
                        if (e.key === 'ArrowLeft') this.infoPrev();
                    } else if (this.mediaOpen) {
                        if (e.key === 'ArrowRight') this.mediaNext();
                        if (e.key === 'ArrowLeft') this.mediaPrev();
                    }
                }
            }));
        });
    </script>
</head>

{{-- ============ DATA & HELPER UNTUK SEMUA MODAL ============ --}}
@php
// Modal Diskusi otomatis terbuka lagi setelah form dikirim / validasi gagal
$initialModal = ($errors->has('question') || $errors->has('name') || session('status')) ? 'diskusi' : null;

// Palet ikon & warna kartu Informasi HPV — berputar otomatis mengikuti urutan konten,
// jadi menambah topik baru di admin tidak perlu ubah kode ini.
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

// Profil
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

// Media Edukasi
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

// Beberapa item Presentasi berupa PDF/PPTX, bukan gambar — jadi tidak bisa asal dipasang
// ke tag <img>. Helper ini menebak ekstensi file dari URL-nya.
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

<body class="bg-white text-slate-600 font-body antialiased"
    x-data="hisHpv({
        initial: {{ \Illuminate\Support\Js::from($initialModal) }},
        ratingError: {{ $errors->has('rating') ? 'true' : 'false' }},
        infoTotal: {{ $informasi->count() }},
        mediaTotals: {{ \Illuminate\Support\Js::from($mediaCounts) }}
    })"
    x-effect="document.body.classList.toggle('overflow-hidden', modalOpen || infoOpen || mediaOpen || ratingOpen)"
    @keydown.window="onKey($event)">

    {{-- ============ NAVBAR ============ --}}
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200">
        <div class="mx-auto max-w-6xl px-5">
            <div class="flex h-16 items-center justify-between">

                <a href="#beranda" @click.prevent="nav('beranda')" class="flex items-center gap-2.5">
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
                        @click.prevent="nav('{{ $item['id'] }}')"
                        class="relative pb-1 transition-colors"
                        :class="isActive('{{ $item['id'] }}') ? 'text-brand-navy' : 'text-slate-500 hover:text-brand-navy'">
                        {{ $item['label'] }}
                        <span class="absolute -bottom-0.5 left-0 h-[3px] w-full rounded-full bg-[var(--red-600)] transition-opacity duration-200"
                            :class="isActive('{{ $item['id'] }}') ? 'opacity-100' : 'opacity-0'"></span>
                    </a>
                    @endforeach
                </nav>

                <a href="#kontak" @click.prevent="nav('kontak')" class="hidden md:inline-flex items-center rounded-full bg-[var(--navy-700)] px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-[var(--navy-700)]/30 hover:bg-[var(--navy-800)] transition-colors">
                    Hubungi Kami
                </a>

                {{-- Mobile hamburger --}}
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 -mr-2 text-brand-navy" aria-label="Buka menu">
                    <svg x-show="!mobileMenu" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenu" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Mobile menu --}}
            <nav x-show="mobileMenu" x-cloak class="md:hidden pb-4 flex flex-col gap-1 text-sm font-medium border-t border-slate-200 pt-3">
                @foreach ([
                ['id' => 'beranda', 'label' => 'Beranda'],
                ['id' => 'profil', 'label' => 'Profil'],
                ['id' => 'informasi', 'label' => 'Informasi HPV'],
                ['id' => 'media', 'label' => 'Media Edukasi'],
                ['id' => 'diskusi', 'label' => 'Diskusi'],
                ['id' => 'kontak', 'label' => 'Kontak'],
                ] as $item)
                <a href="#{{ $item['id'] }}" @click.prevent="nav('{{ $item['id'] }}')"
                    class="rounded-lg px-3 py-2.5 transition-colors"
                    :class="isActive('{{ $item['id'] }}') ? 'bg-[var(--navy-100)] text-brand-navy' : 'text-slate-500 hover:bg-slate-50'">
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>
        </div>
    </header>

    {{-- ============ HERO (satu-satunya halaman yang tampil) ============ --}}
    <main id="beranda" class="relative flex min-h-[calc(100dvh-4rem)] items-center bg-[var(--paper)] overflow-hidden">
        <div class="mx-auto w-full max-w-6xl px-5 py-12 md:py-16">
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
                        <a href="#informasi" @click.prevent="openModal('informasi')" class="inline-flex justify-center items-center rounded-xl bg-[var(--navy-700)] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[var(--navy-700)]/25 hover:bg-[var(--navy-800)] transition-colors">
                            Pelajari Tentang HPV
                        </a>
                        <a href="#media" @click.prevent="openModal('media')" class="inline-flex justify-center items-center rounded-xl bg-white border border-slate-200 px-6 py-3 text-sm font-semibold text-brand-navy hover:border-[var(--navy-700)]/40 hover:bg-[var(--navy-100)]/60 transition-colors">
                            Lihat Media Edukasi
                        </a>
                    </div>

                    {{-- Pilar cepat menuju bagian utama --}}
                    <div class="mt-9 flex items-center justify-center md:justify-start gap-5 sm:gap-7 text-xs sm:text-sm font-medium text-slate-500">
                        <a href="#informasi" @click.prevent="openModal('informasi')" class="flex items-center gap-1.5 hover:text-[var(--navy-700)] transition-colors">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6c-2-1.4-5-1.8-8-1v12.5c3-.8 6-.4 8 1 2-1.4 5-1.8 8-1V5c-3-.8-6-.4-8 1z" />
                                <path stroke-linecap="round" d="M12 6v12.5" />
                            </svg>
                            Edukasi HPV
                        </a>
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                        <a href="#profil" @click.prevent="openModal('profil')" class="flex items-center gap-1.5 hover:text-[var(--navy-700)] transition-colors">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5.5c0 4.8-3 8-7 9.5-4-1.5-7-4.7-7-9.5V6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4.2" />
                            </svg>
                            Imunisasi Anak
                        </a>
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                        <a href="#diskusi" @click.prevent="openModal('diskusi')" class="flex items-center gap-1.5 hover:text-[var(--navy-700)] transition-colors">
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
    </main>

    {{-- ====================================================================
         MODAL UTAMA — satu "cangkang" dipakai bersama oleh:
         Profil · Informasi HPV · Media Edukasi · Diskusi · Kontak
         Di HP tampil sebagai bottom-sheet, di desktop sebagai dialog di tengah.
         ==================================================================== --}}
    <div x-show="modalOpen" x-cloak
        class="fixed inset-0 z-[60] flex items-end sm:items-center justify-center sm:p-6"
        role="dialog" aria-modal="true" :aria-label="meta[modal].title">

        <div x-show="modalOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeModal()"
            style="background-color: rgba(15, 27, 60, 0.72);"
            class="absolute inset-0 backdrop-blur-sm"></div>

        <div x-show="modalOpen" x-ref="modalPanel" tabindex="-1"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-3 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-y-4"
            :class="meta[modal].size"
            class="relative flex w-full max-h-[92dvh] sm:max-h-[86dvh] flex-col overflow-hidden rounded-t-3xl sm:rounded-3xl bg-white shadow-2xl outline-none">

            {{-- Header (berubah otomatis sesuai modal yang aktif) --}}
            <div class="relative shrink-0 border-b border-slate-200 bg-white px-6 sm:px-8 pt-3 sm:pt-6 pb-5">
                <span class="mx-auto mb-3 block h-1 w-10 rounded-full bg-slate-200 sm:hidden"></span>

                <button type="button" @click="closeModal()"
                    class="absolute top-3 sm:top-5 right-4 sm:right-5 p-2 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--navy-700)]/40"
                    aria-label="Tutup">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="flex items-start gap-4 pr-10">
                    <div class="icon-chip h-11 w-11 shrink-0 rounded-xl flex items-center justify-center"
                        :class="modal === 'informasi' || modal === 'profil' || modal === 'media' ? 'bg-[var(--navy-100)] text-[var(--navy-700)]' : 'bg-[var(--red-100)] text-[var(--red-600)]'">
                        {{-- ikon per modal --}}
                        <svg x-show="modal === 'profil'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5.5c0 4.8-3 8-7 9.5-4-1.5-7-4.7-7-9.5V6z" />
                        </svg>
                        <svg x-show="modal === 'informasi'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6c-2-1.4-5-1.8-8-1v12.5c3-.8 6-.4 8 1 2-1.4 5-1.8 8-1V5c-3-.8-6-.4-8 1z" />
                            <path stroke-linecap="round" d="M12 6v12.5" />
                        </svg>
                        <svg x-show="modal === 'media'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="display:none">
                            <rect x="3" y="4.5" width="18" height="12" rx="2" />
                            <path stroke-linecap="round" d="M8 20h8M12 16.5v3.5" />
                        </svg>
                        <svg x-show="modal === 'diskusi'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.4 8.4 0 01-4.5 7.4 8.5 8.5 0 01-8-.4L3 20l1.5-4a8.4 8.4 0 01-1.5-6.5A8.5 8.5 0 0111.5 3 8.4 8.4 0 0121 11.5z" />
                        </svg>
                        <svg x-show="modal === 'kontak'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="display:none">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h2 class="font-display font-700 text-xl sm:text-2xl text-brand-navy leading-tight" x-text="meta[modal].title"></h2>
                        <p class="mt-1 text-sm text-slate-500" x-text="meta[modal].desc"></p>
                    </div>
                </div>
            </div>

            {{-- Isi (bisa di-scroll di dalam modal) --}}
            <div x-ref="modalBody" class="min-h-0 flex-1 overflow-y-auto overscroll-contain bg-[var(--paper)] px-6 sm:px-8 py-6 sm:py-8">

                {{-- ---------- PROFIL ---------- --}}
                <div x-show="modal === 'profil'">
                    <div class="grid sm:grid-cols-3 gap-4">
                        @foreach ($profilMeta as $key => $meta)
                        @php $block = $profil[$key] ?? null; @endphp
                        <div class="rounded-2xl bg-white border border-slate-200 p-6">
                            <div class="icon-chip h-11 w-11 rounded-xl {{ $meta['bg'] }} {{ $meta['text'] }} flex items-center justify-center">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">{!! $meta['icon'] !!}</svg>
                            </div>
                            <p class="font-display font-700 text-brand-navy mt-4">{{ $block->title ?? ucfirst(str_replace('_', ' ', $key)) }}</p>
                            <p class="mt-2 text-sm leading-relaxed whitespace-pre-line {{ $block?->description ? 'text-slate-500' : 'text-slate-400 italic' }}">{{ $block->description ?? 'Halaman ini sedang disiapkan' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ---------- INFORMASI HPV ---------- --}}
                <div x-show="modal === 'informasi'" style="display:none">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @forelse ($informasi as $key => $block)
                        @php $meta = $iconPalette[$loop->index % count($iconPalette)]; @endphp
                        <button type="button" @click="openInfo({{ $loop->index }})"
                            class="group relative text-left overflow-hidden rounded-2xl bg-white border border-slate-200 p-6 hover:shadow-xl hover:shadow-slate-200/70 hover:-translate-y-1 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--navy-700)]/40">
                            <span class="pointer-events-none absolute top-4 right-5 font-display font-800 text-4xl text-slate-100 group-hover:text-slate-200 transition-colors select-none">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <div class="relative h-12 w-12 rounded-2xl bg-gradient-to-br {{ $meta['gradient'] }} flex items-center justify-center text-white shadow-lg shadow-slate-300/50">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-6 w-6">{!! $meta['icon'] !!}</svg>
                            </div>

                            <p class="relative font-display font-700 text-base text-brand-navy mt-4">{{ $block->title ?? ucfirst(str_replace('_', ' ', $key)) }}</p>
                            <span class="relative block h-1 w-8 rounded-full {{ $meta['accent'] }} mt-2 mb-3"></span>

                            <p class="relative text-sm leading-relaxed line-clamp-3 {{ $block->description ? 'text-slate-500' : 'text-slate-400 italic' }}">
                                {{ $block->description ?? 'Konten segera hadir' }}
                            </p>

                            <span class="relative mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-[var(--navy-700)]">
                                Baca selengkapnya
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
                                </svg>
                            </span>
                        </button>
                        @empty
                        <div class="sm:col-span-2 lg:col-span-3 rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center">
                            <p class="text-sm text-slate-400">Konten informasi HPV sedang disiapkan.</p>
                        </div>
                        @endforelse
                    </div>

                    @if ($informasi->hasPages())
                    <div class="mt-8">
                        {{ $informasi->fragment('informasi')->onEachSide(1)->links('partials.pagination') }}
                    </div>
                    @endif
                </div>

                {{-- ---------- MEDIA EDUKASI ---------- --}}
                <div x-show="modal === 'media'" style="display:none">
                    <div class="grid sm:grid-cols-3 gap-5">
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
                                @if ($cover) @click="openMedia('{{ $type }}')" @endif>
                                @if ($isCoverImage)
                                <img src="{{ $cover->file_url }}" alt="{{ $cover->title }}" class="w-full h-full object-cover">
                                @elseif ($cover && $type === 'video')
                                <video src="{{ $cover->file_url }}" poster="{{ $coverThumb }}" class="w-full h-full object-cover" preload="metadata" muted></video>
                                <span class="pointer-events-none absolute inset-0 flex items-center justify-center">
                                    <span class="h-11 w-11 rounded-full bg-white/85 flex items-center justify-center text-[var(--navy-700)] shadow-md">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">{!! $jenis['icon'] !!}</svg>
                                    </span>
                                </span>
                                @elseif ($coverThumb)
                                <img src="{{ $coverThumb }}" alt="{{ $cover->title }}" class="w-full h-full object-cover">
                                <span class="absolute bottom-2 left-2 text-[10px] font-bold tracking-wide text-white bg-[var(--red-600)] rounded px-1.5 py-0.5">{{ strtoupper($coverExt) }}</span>
                                @elseif ($isCoverPdfNoThumb)
                                <iframe src="{{ $cover->file_url }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH" class="w-full h-full pointer-events-none bg-white" loading="lazy" title="{{ $cover->title }}"></iframe>
                                <span class="absolute bottom-2 left-2 text-[10px] font-bold tracking-wide text-white bg-[var(--red-600)] rounded px-1.5 py-0.5">PDF</span>
                                @elseif ($cover)
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

                                <button type="button" @click="openMedia('{{ $type }}')"
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
                </div>

                {{-- ---------- DISKUSI ---------- --}}
                <div x-show="modal === 'diskusi'" style="display:none">
                    @if (session('status'))
                    <div class="mb-5 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('diskusi.store') }}" class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 space-y-3">
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

                    <div class="mt-6 grid sm:grid-cols-2 gap-4">
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

                {{-- ---------- KONTAK ---------- --}}
                <div x-show="modal === 'kontak'" style="display:none">
                    <div class="rounded-2xl bg-white border border-slate-200 p-6 text-center">
                        <div class="mx-auto h-14 w-14 rounded-2xl bg-[var(--navy-100)] text-[var(--navy-700)] flex items-center justify-center">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-7 w-7">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6" />
                            </svg>
                        </div>
                        <p class="mt-4 text-xs font-semibold text-slate-400">Alamat e-mail</p>
                        <p class="mt-0.5 font-display font-700 text-brand-navy break-all">{{ config('mail.from.address') }}</p>

                        <a href="mailto:{{ config('mail.from.address') }}?subject={{ urlencode('Pertanyaan seputar HPV') }}"
                            class="mt-5 inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-[var(--navy-700)] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[var(--navy-700)]/25 hover:bg-[var(--navy-800)] transition-colors">
                            Kirim E-mail
                        </a>
                    </div>

                    <p class="mt-5 text-center text-sm text-slate-500">
                        Ingin jawabannya bisa dibaca semua orang?
                        <button type="button" @click="openModal('diskusi')" class="font-semibold text-[var(--navy-700)] hover:text-[var(--navy-800)] underline underline-offset-2">Tanya lewat Box Diskusi</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================================================================
         DETAIL INFORMASI HPV — lapisan kedua di atas modal Informasi
         (navigasi Sebelumnya/Selanjutnya, panah keyboard, indikator titik)
         ==================================================================== --}}
    <div x-show="infoOpen" x-cloak class="fixed inset-0 z-[70] flex items-end sm:items-center justify-center" role="dialog" aria-modal="true">

        <div x-show="infoOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="infoOpen = false"
            class="absolute inset-0 bg-[var(--navy-900)]/60 backdrop-blur-sm"></div>

        <div x-show="infoOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="relative w-full sm:max-w-xl max-h-[88dvh] overflow-hidden rounded-t-3xl sm:rounded-3xl bg-white shadow-2xl flex flex-col">

            @foreach ($informasi as $key => $block)
            @php $meta = $iconPalette[$loop->index % count($iconPalette)]; @endphp
            <div x-show="infoIdx === {{ $loop->index }}" class="flex flex-col max-h-[88dvh]" @if (!$loop->first) style="display:none" @endif>

                <div class="relative bg-gradient-to-br {{ $meta['gradient'] }} px-7 sm:px-8 pt-7 pb-9 shrink-0">
                    <button type="button" @click="infoOpen = false" class="absolute top-5 right-5 p-1.5 rounded-full text-white/80 hover:bg-white/15 hover:text-white transition-colors" aria-label="Tutup">
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

                <div class="px-7 sm:px-8 py-6 overflow-y-auto">
                    <p class="text-sm sm:text-[15px] leading-relaxed text-slate-600 whitespace-pre-line">
                        {{ $block->description ?? 'Konten segera hadir.' }}
                    </p>
                </div>

                @if ($informasi->count() > 1)
                <div class="flex items-center justify-between gap-3 border-t border-slate-100 px-7 sm:px-8 py-4 shrink-0 bg-[var(--paper)]">
                    <button type="button" @click="infoPrev()" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[var(--navy-700)] transition-colors">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6" />
                        </svg>
                        Sebelumnya
                    </button>
                    <div class="hidden xs:flex items-center gap-1.5">
                        @foreach ($informasi as $dotKey => $dotBlock)
                        <span class="h-1.5 rounded-full transition-all"
                            :class="infoIdx === {{ $loop->index }} ? 'w-5 bg-[var(--navy-700)]' : 'w-1.5 bg-slate-300'"></span>
                        @endforeach
                    </div>
                    <button type="button" @click="infoNext()" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[var(--navy-700)] transition-colors">
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

    {{-- ====================================================================
         CAROUSEL MEDIA EDUKASI — lapisan kedua di atas modal Media
         (geser manual lewat panah, tidak auto-scroll)
         ==================================================================== --}}
    <div x-show="mediaOpen" x-cloak class="fixed inset-0 z-[70] flex items-end sm:items-center justify-center" role="dialog" aria-modal="true">

        <div x-show="mediaOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mediaOpen = false"
            class="absolute inset-0 bg-[var(--navy-900)]/70 backdrop-blur-sm"></div>

        <div x-show="mediaOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="relative w-full sm:max-w-3xl lg:max-w-4xl max-h-[94dvh] overflow-hidden rounded-t-3xl sm:rounded-3xl bg-white shadow-2xl flex flex-col">

            <button type="button" @click="mediaOpen = false"
                class="absolute top-4 right-4 z-10 h-9 w-9 rounded-full bg-black/40 hover:bg-black/60 text-white flex items-center justify-center transition-colors" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            @foreach ($jenisMedia as $type => $jenis)
            @php $mediaItems = $mediaByType[$type] ?? collect(); @endphp
            @if ($mediaItems->isNotEmpty())
            <div x-show="activeMedia === '{{ $type }}'" class="flex flex-col max-h-[92dvh]" style="display:none">

                <div class="relative bg-slate-900 aspect-[4/3] sm:aspect-[16/10] shrink-0 overflow-hidden">
                    @foreach ($mediaItems as $item)
                    @php
                    $ext = $fileExt($item->file_url);
                    $isImage = $type === 'poster' || in_array($ext, $imageExts);
                    $thumb = $item->thumbnail_url ?? null;
                    $isPdf = !$isImage && !$thumb && $ext === 'pdf';
                    @endphp
                    <div x-show="activeMedia === '{{ $type }}' && mediaIndex === {{ $loop->index }}" class="absolute inset-0 flex items-center justify-center" @if (!$loop->first) style="display:none" @endif>
                        @if ($type === 'video')
                        <video src="{{ $item->file_url }}" poster="{{ $thumb }}" class="w-full h-full object-contain" controls preload="metadata"></video>
                        @elseif ($isImage)
                        <img src="{{ $item->file_url }}" alt="{{ $item->title }}" class="w-full h-full object-contain bg-white">
                        @elseif ($thumb)
                        <img src="{{ $thumb }}" alt="{{ $item->title }}" class="w-full h-full object-contain bg-white">
                        @elseif ($isPdf)
                        <iframe src="{{ $item->file_url }}#toolbar=0&navpanes=0&view=FitH" class="w-full h-full bg-white" title="{{ $item->title }}"></iframe>
                        @else
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

                    @foreach ($mediaItems as $item)
                    @php $ext = $fileExt($item->file_url); @endphp
                    <a x-show="activeMedia === '{{ $type }}' && mediaIndex === {{ $loop->index }}"
                        href="{{ $item->file_url }}" target="_blank" download="{{ $downloadName($item->title, $ext) }}"
                        @if (!$loop->first) style="display:none" @endif
                        class="absolute top-3 left-3 inline-flex items-center gap-1.5 rounded-full bg-white/90 hover:bg-white text-[var(--navy-700)] text-xs font-semibold px-3.5 py-2 shadow-md transition-colors">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-3.5 w-3.5">{!! $downloadIcon !!}</svg>
                        Unduh
                    </a>
                    @endforeach

                    @if ($mediaItems->count() > 1)
                    <button type="button" @click="mediaPrev()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-white/90 hover:bg-white text-[var(--navy-700)] shadow-md flex items-center justify-center transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white" aria-label="Sebelumnya">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6" />
                        </svg>
                    </button>
                    <button type="button" @click="mediaNext()"
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

                <div class="px-6 sm:px-8 py-5 sm:py-6 overflow-y-auto">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-[var(--red-600)] uppercase tracking-wide">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5">{!! $jenis['icon'] !!}</svg>
                        {{ $jenis['label'] }}
                    </span>

                    @foreach ($mediaItems as $item)
                    <div x-show="activeMedia === '{{ $type }}' && mediaIndex === {{ $loop->index }}" @if (!$loop->first) style="display:none" @endif>
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

    {{-- ============ FLOATING RATING BUTTON + MODAL (tidak diubah tampilannya) ============ --}}
    <div>
        <button type="button" @click="ratingOpen = true; rating = 0"
            class="fixed bottom-5 right-5 z-40 flex items-center gap-2 rounded-full bg-[var(--navy-700)] shadow-lg shadow-[var(--navy-900)]/30 px-4 py-2.5 text-sm font-medium text-white hover:bg-[var(--navy-800)] transition-colors">
            <svg class="h-4 w-4 text-[var(--gold)]" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
            </svg>
            Beri Penilaian
        </button>

        <div x-show="ratingOpen" x-cloak class="fixed inset-0 z-[80] flex items-end sm:items-center justify-center">

            <div
                x-show="ratingOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="ratingOpen = false"
                class="absolute inset-0 bg-[var(--navy-900)]/60 backdrop-blur-sm"></div>

            <div
                x-show="ratingOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="relative w-full sm:max-w-sm rounded-t-3xl sm:rounded-3xl bg-white p-7 shadow-2xl text-center">

                <button type="button" @click="ratingOpen = false" class="absolute top-4 right-4 p-1.5 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors" aria-label="Tutup">
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
        class="fixed bottom-24 right-5 z-[90] max-w-xs rounded-2xl bg-white border border-slate-200 shadow-xl px-4 py-3 flex items-start gap-3">
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