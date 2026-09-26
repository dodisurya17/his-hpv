@extends('layouts.admin')

@section('title', 'Jawab Pertanyaan')

@section('content')
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
