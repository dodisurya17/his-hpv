@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid sm:grid-cols-3 gap-6">
    <div class="rounded-xl bg-white border border-slate-200 p-6">
        <p class="text-sm text-slate-500">Media Edukasi</p>
        <p class="text-2xl font-bold text-slate-800 mt-1">{{ $mediaCount }}</p>
    </div>
    <div class="rounded-xl bg-white border border-slate-200 p-6">
        <p class="text-sm text-slate-500">Pertanyaan Belum Dijawab</p>
        <p class="text-2xl font-bold text-red-600 mt-1">{{ $unansweredCount }}</p>
    </div>
    <div class="rounded-xl bg-white border border-slate-200 p-6">
        <p class="text-sm text-slate-500">Jumlah Admin</p>
        <p class="text-2xl font-bold text-slate-800 mt-1">{{ $adminCount }}</p>
    </div>
</div>

<div class="mt-8 grid sm:grid-cols-2 gap-4 text-sm">
    <a href="{{ route('admin.content.index', 'profil') }}" class="rounded-xl bg-white border border-slate-200 p-5 hover:border-[#1E3D7B]">Kelola konten Profil &rarr;</a>
    <a href="{{ route('admin.content.index', 'informasi') }}" class="rounded-xl bg-white border border-slate-200 p-5 hover:border-[#1E3D7B]">Kelola konten Informasi HPV &rarr;</a>
    <a href="{{ route('admin.media-edukasi.index') }}" class="rounded-xl bg-white border border-slate-200 p-5 hover:border-[#1E3D7B]">Kelola Media Edukasi &rarr;</a>
    <a href="{{ route('admin.discussions.index') }}" class="rounded-xl bg-white border border-slate-200 p-5 hover:border-[#1E3D7B]">Jawab pertanyaan Diskusi &rarr;</a>
</div>
@endsection
