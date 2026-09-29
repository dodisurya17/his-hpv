<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin HIS-HPV @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"],
        textarea,
        select {
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            color: #1e293b;
            background-color: #fff;
            transition: box-shadow .15s ease, border-color .15s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus,
        select:focus {
            border-color: #1E3D7B;
            box-shadow: 0 0 0 3px rgba(30, 61, 123, 0.15);
            outline: none;
        }

        /* Desktop: sidebar menempel di kolom kiri dengan tinggi layar penuh dan tidak ikut
           ter-scroll. Ditulis sebagai CSS biasa (bukan kelas Tailwind) supaya tidak perlu
           rebuild aset. Mobile tetap berupa menu geser (fixed). */
        @media (min-width: 768px) {
            .admin-sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
                align-self: flex-start;
            }
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen md:flex">

        {{-- Topbar mobile: tombol buka menu, hanya tampil di layar kecil --}}
        <div class="md:hidden sticky top-0 z-30 flex items-center justify-between bg-gradient-to-r from-[#0F1B3C] to-[#1E3D7B] text-white px-4 py-3 shadow-sm">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo HIS-HPV" class="h-8 w-8 rounded-lg object-cover ring-1 ring-white/25">
                <span class="font-bold">HIS-HPV Admin</span>
            </div>
            <button @click="sidebarOpen = true" class="p-1.5 rounded-lg hover:bg-white/10" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Overlay gelap saat sidebar mobile terbuka --}}
        <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/50 md:hidden"></div>

        <aside
            class="admin-sidebar fixed z-40 inset-y-0 left-0 w-72 md:w-64 shrink-0 bg-gradient-to-b from-[#0F1B3C] to-[#1E3D7B] text-white flex flex-col transform transition-transform duration-200 md:static md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="px-5 py-5 border-b border-white/10 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo HIS-HPV" class="h-10 w-10 rounded-xl object-cover ring-2 ring-white/20 shrink-0">
                    <div class="min-w-0">
                        <p class="font-bold leading-tight truncate">HIS-HPV</p>
                        <p class="text-xs text-white/60 leading-tight">Admin Panel</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden p-1 text-white/70 hover:text-white shrink-0" aria-label="Tutup menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto">
                @php
                $navClass = fn ($active) => 'flex items-center gap-3 rounded-xl px-3.5 py-2.5 font-medium transition '
                . ($active ? 'bg-white text-[#1E3D7B] shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white');
                @endphp

                <a href="{{ route('admin.dashboard') }}" class="{{ $navClass(request()->routeIs('admin.dashboard')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.content.index', 'profil') }}" class="{{ $navClass(request()->routeIs('admin.content.*') && request()->route('section') === 'profil') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil
                </a>

                <a href="{{ route('admin.content.index', 'informasi') }}" class="{{ $navClass(request()->routeIs('admin.content.*') && request()->route('section') === 'informasi') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 4.556-3.03 8.25-9 10.5C6.03 20.25 3 16.556 3 12V6.75l9-4.5 9 4.5V12z" />
                    </svg>
                    Informasi HPV
                </a>

                <a href="{{ route('admin.media-edukasi.index') }}" class="{{ $navClass(request()->routeIs('admin.media-edukasi.*')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V6a1.5 1.5 0 011.5-1.5h15A1.5 1.5 0 0121 6v10.5M3 16.5A1.5 1.5 0 004.5 18h15a1.5 1.5 0 001.5-1.5M3 16.5l5.5-5 3.5 3 3-3L21 16.5" />
                    </svg>
                    Media Edukasi
                </a>

                <a href="{{ route('admin.discussions.index') }}" class="{{ $navClass(request()->routeIs('admin.discussions.*')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8-1.35 0-2.63-.26-3.78-.72L3 20l1.05-3.16A7.94 7.94 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Diskusi
                    @isset($unansweredCount)
                    @if ($unansweredCount > 0)
                    <span class="ml-auto text-[11px] font-bold bg-red-500 text-white rounded-full px-2 py-0.5">{{ $unansweredCount }}</span>
                    @endif
                    @endisset
                </a>

                <a href="{{ route('admin.kelola-admin.index') }}" class="{{ $navClass(request()->routeIs('admin.kelola-admin.*')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-1a4 4 0 00-4-4h-1M9 20H4v-1a4 4 0 014-4h1m0-4a3 3 0 100-6 3 3 0 000 6zm8 2a3 3 0 100-6 3 3 0 000 6zm-8 8a5 5 0 015-5h0a5 5 0 015 5v0H9v0z" />
                    </svg>
                    Kelola Admin
                </a>
            </nav>

            <div class="p-3 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 5v1a3 3 0 01-3 3H6a3 3 0 01-3-3V6a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="truncate">Keluar ({{ auth()->user()->name }})</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 min-w-0 w-full">
            <header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200 px-5 md:px-8 py-4">
                <h1 class="text-lg font-bold text-slate-800">@yield('title')</h1>
            </header>
            <div class="p-5 md:p-8">
                @if (session('status'))
                <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>