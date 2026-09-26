@extends('layouts.admin')

@section('title', 'Edit ' . $contentBlock->title)

@section('content')
<form method="POST" action="{{ route('admin.content.update', $contentBlock) }}" class="max-w-xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
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
    <button class="rounded-lg bg-[#1E3D7B] text-white px-5 py-2.5 text-sm font-semibold hover:bg-[#16244F]">Simpan</button>
</form>
@endsection
