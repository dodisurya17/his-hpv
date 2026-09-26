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
    </style>
</head>

<body class="bg-slate-100 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen md:flex">

        {{-- Topbar mobile: tombol buka menu, hanya tampil di layar kecil --}}
        <div class="md:hidden sticky top-0 z-30 flex items-center justify-between bg-[#0F1B3C] text-white px-4 py-3">
            <span class="font-bold">HIS-HPV Admin</span>
            <button @click="sidebarOpen = true" class="p-1" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Overlay gelap saat sidebar mobile terbuka --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/40 md:hidden"></div>

        <aside
            class="fixed z-40 inset-y-0 left-0 w-64 shrink-0 bg-[#0F1B3C] text-white flex flex-col transform transition-transform duration-200 md:static md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="px-5 py-5 border-b border-white/10 flex items-center justify-between">
                <span class="font-bold text-lg">HIS-HPV Admin</span>
                <button @click="sidebarOpen = false" class="md:hidden p-1" aria-label="Tutup menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : '' }}">Dashboard</a>
                <a href="{{ route('admin.content.index', 'profil') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.content.*') && request()->route('section') === 'profil' ? 'bg-white/10' : '' }}">Profil</a>
                <a href="{{ route('admin.content.index', 'informasi') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.content.*') && request()->route('section') === 'informasi' ? 'bg-white/10' : '' }}">Informasi HPV</a>
                <a href="{{ route('admin.media-edukasi.index') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.media-edukasi.*') ? 'bg-white/10' : '' }}">Media Edukasi</a>
                <a href="{{ route('admin.discussions.index') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.discussions.*') ? 'bg-white/10' : '' }}">Diskusi</a>
                <a href="{{ route('admin.kelola-admin.index') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('admin.kelola-admin.*') ? 'bg-white/10' : '' }}">Kelola Admin</a>
            </nav>
            <div class="p-3 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left rounded-lg px-3 py-2 hover:bg-white/10 text-sm">Keluar ({{ auth()->user()->name }})</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 min-w-0 w-full">
            <header class="bg-white border-b border-slate-200 px-5 md:px-8 py-4">
                <h1 class="text-lg font-semibold text-slate-800">@yield('title')</h1>
            </header>
            <div class="p-5 md:p-8">
                @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 text-green-700 text-sm px-4 py-3">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc list-inside">
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