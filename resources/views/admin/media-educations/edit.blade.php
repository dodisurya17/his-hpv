@extends('layouts.admin')

@section('title', 'Edit Media Edukasi')

@section('content')
<form method="POST" action="{{ route('admin.media-edukasi.update', $mediaEducation) }}" enctype="multipart/form-data" class="max-w-xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis</label>
        <select name="type" class="w-full rounded-lg border-slate-300">
            @foreach (['poster' => 'Poster', 'presentasi' => 'Presentasi', 'video' => 'Video'] as $value => $label)
            <option value="{{ $value }}" @selected(old('type', $mediaEducation->type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title', $mediaEducation->title) }}" class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi (opsional)</label>
        <textarea name="description" rows="3" class="w-full rounded-lg border-slate-300">{{ old('description', $mediaEducation->description) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Ganti file (opsional)</label>
        <input type="file" name="file" class="w-full text-sm">
        <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti file yang sudah ada.</p>
    </div>
    <button class="rounded-lg bg-[#1E3D7B] text-white px-5 py-2.5 text-sm font-semibold hover:bg-[#16244F]">Simpan</button>
</form>
@endsection
