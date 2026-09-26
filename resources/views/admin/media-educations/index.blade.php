@extends('layouts.admin')

@section('title', 'Media Edukasi')

@section('content')

{{-- Toolbar: pencarian + filter tipe + tombol tambah --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.media-edukasi.index') }}" class="flex flex-col sm:flex-row gap-3 flex-1 min-w-0">
        <div class="relative flex-1 min-w-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-[18px] w-[18px] text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul media..."
                   class="w-full rounded-xl border border-slate-200 bg-white !pl-10 !pr-4 !py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3D7B]/20 focus:border-[#1E3D7B]">
            @if ($search !== '')
            <a href="{{ route('admin.media-edukasi.index', ['type' => $type]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" aria-label="Hapus pencarian">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            @endif
        </div>

        <div class="relative shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>
            <select name="type" onchange="this.form.submit()"
                    class="w-full sm:w-44 appearance-none rounded-xl border border-slate-200 bg-white !pl-10 !pr-9 !py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1E3D7B]/20 focus:border-[#1E3D7B]">
                <option value="all" @selected($type === 'all')>Semua tipe</option>
                <option value="poster" @selected($type === 'poster')>Poster</option>
                <option value="presentasi" @selected($type === 'presentasi')>Presentasi</option>
                <option value="video" @selected($type === 'video')>Video</option>
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>

        @if ($search !== '' || $type !== 'all')
        <a href="{{ route('admin.media-edukasi.index') }}"
           class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition shrink-0">
            Reset
        </a>
        @endif
    </form>

    <a href="{{ route('admin.media-edukasi.create') }}"
       class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1E3D7B] text-white px-4 py-2.5 text-sm font-semibold shadow-sm hover:bg-[#16244F] transition shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Media
    </a>
</div>

@if ($search !== '' || $type !== 'all')
<p class="text-sm text-slate-500 mb-3">{{ $items->total() }} media ditemukan.</p>
@endif

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="divide-y divide-slate-100">
        @forelse ($items as $item)
        <div class="flex items-center justify-between p-5 gap-4">
            <div class="min-w-0">
                <span class="text-[11px] font-semibold uppercase text-[#1E3D7B] bg-[#E8EDF9] rounded-full px-2 py-0.5">{{ $item->type }}</span>
                <p class="font-semibold text-slate-800 mt-1 truncate">{{ $item->title }}</p>
            </div>
            <div class="flex items-center gap-4 text-sm shrink-0">
                <a href="{{ $item->file_url }}" target="_blank" class="text-slate-500 hover:text-slate-700">Lihat file</a>
                <a href="{{ route('admin.media-edukasi.edit', $item) }}" class="text-[#1E3D7B] font-semibold hover:underline">Edit</a>
                <form method="POST" action="{{ route('admin.media-edukasi.destroy', $item) }}" onsubmit="return confirm('Hapus media ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 font-semibold hover:underline">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="p-10 text-center">
            <p class="text-sm text-slate-400">
                @if ($search !== '' || $type !== 'all')
                    Tidak ada media yang cocok dengan filter ini.
                @else
                    Belum ada media.
                @endif
            </p>
        </div>
        @endforelse
    </div>

    {{ $items->links('admin.partials.pagination') }}
</div>
@endsection
