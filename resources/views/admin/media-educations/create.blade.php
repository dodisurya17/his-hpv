@extends('layouts.admin')

@section('title', 'Tambah Media Edukasi')

@section('content')
<a href="{{ route('admin.media-edukasi.index') }}"
   class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[#1E3D7B] mb-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
    </svg>
    Kembali
</a>

<form method="POST" action="{{ route('admin.media-edukasi.store') }}" enctype="multipart/form-data" class="max-w-xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis</label>
        <select name="type" class="w-full rounded-lg border-slate-300">
            <option value="poster">Poster</option>
            <option value="presentasi">Presentasi</option>
            <option value="video">Video</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi (opsional)</label>
        <textarea name="description" rows="3" class="w-full rounded-lg border-slate-300">{{ old('description') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">File (jpg, png, pdf, ppt, pptx, mp4, webm — maks 20MB)</label>
        <input type="file" name="file" class="w-full text-sm">
    </div>
    <button class="rounded-lg bg-[#1E3D7B] text-white px-5 py-2.5 text-sm font-semibold hover:bg-[#16244F]">Simpan</button>
</form>
@endsection
