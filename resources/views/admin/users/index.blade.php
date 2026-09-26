@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('content')

{{-- Toolbar: pencarian + tombol tambah --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.kelola-admin.index') }}" class="flex-1 min-w-0">
        <label for="q" class="sr-only">Cari admin</label>
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-[18px] w-[18px] text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" id="q" name="q" value="{{ $search }}" placeholder="Cari nama atau email admin..."
                   class="w-full rounded-xl border border-slate-200 bg-white !pl-10 !pr-4 !py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3D7B]/20 focus:border-[#1E3D7B]">
            @if ($search !== '')
            <a href="{{ route('admin.kelola-admin.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" aria-label="Hapus pencarian">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            @endif
        </div>
    </form>

    <a href="{{ route('admin.kelola-admin.create') }}"
       class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1E3D7B] text-white px-4 py-2.5 text-sm font-semibold shadow-sm hover:bg-[#16244F] transition shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Admin
    </a>
</div>

@if ($search !== '')
<p class="text-sm text-slate-500 mb-3">
    Hasil pencarian untuk "<span class="font-semibold text-slate-700">{{ $search }}</span>" &mdash;
    {{ $admins->total() }} admin ditemukan.
</p>
@endif

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="divide-y divide-slate-100">
        @forelse ($admins as $item)
        <div class="flex items-center justify-between p-5 gap-4">
            <div class="min-w-0 flex items-center gap-3.5">
                <div class="h-10 w-10 rounded-full bg-[#E8EDF9] text-[#1E3D7B] flex items-center justify-center shrink-0 font-bold text-sm">
                    {{ strtoupper(substr($item->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-slate-800 truncate">{{ $item->name }}</p>
                    <p class="text-sm text-slate-500 truncate">{{ $item->email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm shrink-0">
                <a href="{{ route('admin.kelola-admin.edit', $item) }}" class="text-[#1E3D7B] font-semibold hover:underline">Edit</a>
                @if ($item->id !== auth()->id())
                <form method="POST" action="{{ route('admin.kelola-admin.destroy', $item) }}" onsubmit="return confirm('Hapus admin ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 font-semibold hover:underline">Hapus</button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="p-10 text-center">
            <p class="text-sm text-slate-400">
                @if ($search !== '')
                    Tidak ada admin yang cocok dengan pencarian "{{ $search }}".
                @else
                    Belum ada admin.
                @endif
            </p>
        </div>
        @endforelse
    </div>

    {{ $admins->links('admin.partials.pagination') }}
</div>
@endsection
