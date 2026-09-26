@extends('layouts.admin')

@section('title', 'Tambah Konten ' . ($section === 'profil' ? 'Profil' : 'Informasi HPV'))

@section('content')
<a href="{{ route('admin.content.index', $section) }}"
   class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[#1E3D7B] mb-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
    </svg>
    Kembali
</a>

<form method="POST" action="{{ route('admin.content.store', $section) }}"
      class="max-w-xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
    @csrf
    <input type="hidden" name="section" value="{{ $section }}">

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title') }}"
               class="w-full rounded-lg border-slate-300" placeholder="Contoh: Gejala HPV">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
        <textarea name="description" rows="6" class="w-full rounded-lg border-slate-300"
                  placeholder="Tulis isi konten di sini...">{{ old('description') }}</textarea>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button class="rounded-lg bg-[#1E3D7B] text-white px-5 py-2.5 text-sm font-semibold hover:bg-[#16244F] transition">
            Simpan
        </button>
        <a href="{{ route('admin.content.index', $section) }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">
            Batal
        </a>
    </div>
</form>
@endsection
