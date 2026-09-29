@extends('layouts.admin')

@section('title', 'Tambah Media Edukasi')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.media-edukasi.index') }}"
        class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[#1E3D7B] mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali
    </a>

    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Tambah media baru</h2>
        <p class="mt-1 text-sm text-slate-500">Unggah poster, presentasi, atau video edukasi untuk ditampilkan kepada pengguna.</p>
    </div>

    @include('admin.media-educations._form', [
    'action' => route('admin.media-edukasi.store'),
    'mediaEducation' => null,
    ])
</div>
@endsection