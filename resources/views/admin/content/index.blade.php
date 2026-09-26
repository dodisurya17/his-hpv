@extends('layouts.admin')

@section('title', $section === 'profil' ? 'Konten Profil' : 'Konten Informasi HPV')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
    @foreach ($items as $item)
    <div class="flex items-center justify-between p-5 gap-4">
        <div class="min-w-0">
            <p class="font-semibold text-slate-800">{{ $item->title }}</p>
            <p class="text-sm text-slate-500 mt-1 truncate">{{ $item->description ?: 'Belum ada deskripsi.' }}</p>
        </div>
        <a href="{{ route('admin.content.edit', $item) }}" class="shrink-0 text-sm font-semibold text-[#1E3D7B] hover:underline">Edit</a>
    </div>
    @endforeach
</div>
@endsection
