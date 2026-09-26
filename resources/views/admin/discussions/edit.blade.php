@extends('layouts.admin')

@section('title', 'Jawab Pertanyaan')

@section('content')
<a href="{{ route('admin.discussions.index') }}"
   class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-[#1E3D7B] mb-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
    </svg>
    Kembali
</a>

<div class="max-w-xl bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    <div>
        <p class="text-sm text-slate-500">Dari</p>
        <p class="font-semibold text-slate-800">{{ $discussion->name }}</p>
    </div>
    <div>
        <p class="text-sm text-slate-500">Pertanyaan</p>
        <p class="text-slate-700">{{ $discussion->question }}</p>
    </div>
    <form method="POST" action="{{ route('admin.discussions.update', $discussion) }}">
        @csrf
        @method('PUT')
        <label class="block text-sm font-medium text-slate-700 mb-1">Jawaban</label>
        <textarea name="answer" rows="6" class="w-full rounded-lg border-slate-300">{{ old('answer', $discussion->answer) }}</textarea>
        <button class="mt-3 rounded-lg bg-[#1E3D7B] text-white px-5 py-2.5 text-sm font-semibold hover:bg-[#16244F]">Simpan Jawaban</button>
    </form>
</div>
@endsection
