@extends('layouts.admin')

@section('title', 'Diskusi')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
    @forelse ($discussions as $d)
    <div class="p-5">
        <div class="flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="font-semibold text-slate-800">{{ $d->name }}</p>
                <p class="text-sm text-slate-600 mt-1">{{ $d->question }}</p>
            </div>
            <span class="shrink-0 text-[11px] font-semibold rounded-full px-2 py-0.5 {{ $d->answer ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">
                {{ $d->answer ? 'Sudah dijawab' : 'Belum dijawab' }}
            </span>
        </div>
        @if ($d->answer)
        <p class="text-sm text-slate-500 mt-2 pl-3 border-l-2 border-slate-200">{{ $d->answer }}</p>
        @endif
        <div class="flex items-center gap-4 mt-3 text-sm">
            <a href="{{ route('admin.discussions.edit', $d) }}" class="text-[#1E3D7B] font-semibold hover:underline">{{ $d->answer ? 'Edit jawaban' : 'Jawab' }}</a>
            <form method="POST" action="{{ route('admin.discussions.destroy', $d) }}" onsubmit="return confirm('Hapus pertanyaan ini?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 font-semibold hover:underline">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <p class="p-5 text-sm text-slate-400">Belum ada pertanyaan.</p>
    @endforelse
</div>
@endsection
