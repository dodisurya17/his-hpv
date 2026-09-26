@extends('layouts.admin')

@section('title', 'Edit ' . $contentBlock->title)

@section('content')
<a href="{{ route('admin.content.index', $contentBlock->section) }}"
   class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[#1E3D7B] mb-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
    </svg>
    Kembali
</a>

<form method="POST" action="{{ route('admin.content.update', $contentBlock) }}" class="max-w-xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title', $contentBlock->title) }}" class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
        <textarea name="description" rows="6" class="w-full rounded-lg border-slate-300">{{ old('description', $contentBlock->description) }}</textarea>
    </div>
    <div class="flex items-center justify-between pt-2">
        <button class="rounded-lg bg-[#1E3D7B] text-white px-5 py-2.5 text-sm font-semibold hover:bg-[#16244F] transition">Simpan</button>
    </div>
</form>

<form method="POST" action="{{ route('admin.content.destroy', $contentBlock) }}"
      onsubmit="return confirm('Hapus konten ini?')" class="max-w-xl mt-4">
    @csrf
    @method('DELETE')
    <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>
        Hapus konten ini
    </button>
</form>
@endsection
