@extends('layouts.admin')

@section('title', $section === 'profil' ? 'Konten Profil' : 'Konten Informasi HPV')

@section('content')

{{-- Toolbar: pencarian + tombol tambah --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.content.index', $section) }}" class="flex-1 min-w-0">
        <label for="q" class="sr-only">Cari konten</label>
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-[18px] w-[18px] text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" id="q" name="q" value="{{ $search }}" placeholder="Cari judul atau deskripsi konten..."
                   class="w-full rounded-xl border border-slate-200 bg-white !pl-10 !pr-4 !py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3D7B]/20 focus:border-[#1E3D7B]">
            @if ($search !== '')
            <a href="{{ route('admin.content.index', $section) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" aria-label="Hapus pencarian">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            @endif
        </div>
    </form>

    <a href="{{ route('admin.content.create', $section) }}"
       class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1E3D7B] text-white px-4 py-2.5 text-sm font-semibold shadow-sm hover:bg-[#16244F] transition shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Konten
    </a>
</div>

<p class="text-sm text-slate-500 mb-4">
    @if ($search !== '')
        Hasil pencarian untuk "<span class="font-semibold text-slate-700">{{ $search }}</span>" &mdash;
        {{ $items->total() }} konten ditemukan.
    @else
        {{ $items->total() }} konten tersimpan.
    @endif
</p>

<div class="grid gap-4">
    @forelse ($items as $item)
    <div class="group rounded-2xl bg-white border border-slate-200 p-5 shadow-sm hover:shadow-md hover:border-[#1E3D7B]/40 transition">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0 flex items-start gap-3.5">
                <div class="h-10 w-10 rounded-xl bg-[#E8EDF9] text-[#1E3D7B] flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-1.519-2.394a2.25 2.25 0 10-3.462 2.868m3.462-2.868l-3.462 2.868m0 0L12 21.75l-2.25-2.25" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-slate-800">{{ $item->title }}</p>
                    <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $item->description ?: 'Belum ada deskripsi.' }}</p>
                </div>
            </div>
            <div class="shrink-0 flex items-center gap-4 text-sm">
                <a href="{{ route('admin.content.edit', $item) }}"
                   class="inline-flex items-center gap-1.5 font-semibold text-[#1E3D7B] opacity-80 group-hover:opacity-100 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.content.destroy', $item) }}" onsubmit="return confirm('Hapus konten ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 font-semibold text-red-600 opacity-80 group-hover:opacity-100 hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center">
        <p class="text-sm text-slate-400">
            @if ($search !== '')
                Tidak ada konten yang cocok dengan pencarian "{{ $search }}".
            @else
                Belum ada konten. Klik "Tambah Konten" untuk membuat yang pertama.
            @endif
        </p>
    </div>
    @endforelse
</div>

<div class="bg-white rounded-2xl border border-slate-200 mt-4 {{ $items->hasPages() ? '' : 'hidden' }}">
    {{ $items->links('admin.partials.pagination') }}
</div>
@endsection
