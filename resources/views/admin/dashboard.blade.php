@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div>
    <p class="text-slate-500 text-sm mb-6">Ringkasan aktivitas aplikasi HIS-HPV hari ini.</p>

    <div class="grid sm:grid-cols-3 gap-5">
        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-[#E8EDF9] text-[#1E3D7B] flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V6a1.5 1.5 0 011.5-1.5h15A1.5 1.5 0 0121 6v10.5M3 16.5A1.5 1.5 0 004.5 18h15a1.5 1.5 0 001.5-1.5M3 16.5l5.5-5 3.5 3 3-3L21 16.5" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-slate-500 truncate">Media Edukasi</p>
                    <p class="text-3xl font-bold text-slate-800 mt-0.5">{{ $mediaCount }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8-1.35 0-2.63-.26-3.78-.72L3 20l1.05-3.16A7.94 7.94 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-slate-500 truncate">Pertanyaan Belum Dijawab</p>
                    <p class="text-3xl font-bold text-red-600 mt-0.5">{{ $unansweredCount }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-[#E8EDF9] text-[#1E3D7B] flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-1a4 4 0 00-4-4h-1M9 20H4v-1a4 4 0 014-4h1m0-4a3 3 0 100-6 3 3 0 000 6zm8 2a3 3 0 100-6 3 3 0 000 6zm-8 8a5 5 0 015-5h0a5 5 0 015 5v0H9v0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-slate-500 truncate">Jumlah Admin</p>
                    <p class="text-3xl font-bold text-slate-800 mt-0.5">{{ $adminCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-10 mb-3">Akses Cepat</p>
    <div class="grid sm:grid-cols-2 gap-4">
        <a href="{{ route('admin.content.index', 'profil') }}"
           class="group flex items-center justify-between rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-[#1E3D7B] transition">
            <span class="font-semibold text-slate-700 group-hover:text-[#1E3D7B]">Kelola konten Profil</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-[#1E3D7B] group-hover:translate-x-0.5 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </a>
        <a href="{{ route('admin.content.index', 'informasi') }}"
           class="group flex items-center justify-between rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-[#1E3D7B] transition">
            <span class="font-semibold text-slate-700 group-hover:text-[#1E3D7B]">Kelola konten Informasi HPV</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-[#1E3D7B] group-hover:translate-x-0.5 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </a>
        <a href="{{ route('admin.media-edukasi.index') }}"
           class="group flex items-center justify-between rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-[#1E3D7B] transition">
            <span class="font-semibold text-slate-700 group-hover:text-[#1E3D7B]">Kelola Media Edukasi</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-[#1E3D7B] group-hover:translate-x-0.5 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </a>
        <a href="{{ route('admin.discussions.index') }}"
           class="group flex items-center justify-between rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-[#1E3D7B] transition">
            <span class="font-semibold text-slate-700 group-hover:text-[#1E3D7B]">Jawab pertanyaan Diskusi</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-[#1E3D7B] group-hover:translate-x-0.5 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>
</div>
@endsection
