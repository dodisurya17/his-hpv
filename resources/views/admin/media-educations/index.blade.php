@extends('layouts.admin')

@section('title', 'Media Edukasi')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.media-edukasi.create') }}" class="rounded-lg bg-[#1E3D7B] text-white px-4 py-2 text-sm font-semibold hover:bg-[#16244F]">+ Tambah Media</a>
</div>
<div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
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
    <p class="p-5 text-sm text-slate-400">Belum ada media.</p>
    @endforelse
</div>
@endsection
