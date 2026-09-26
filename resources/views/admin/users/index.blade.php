@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.kelola-admin.create') }}" class="rounded-lg bg-[#1E3D7B] text-white px-4 py-2 text-sm font-semibold hover:bg-[#16244F]">+ Tambah Admin</a>
</div>
<div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
    @foreach ($admins as $item)
    <div class="flex items-center justify-between p-5 gap-4">
        <div class="min-w-0">
            <p class="font-semibold text-slate-800">{{ $item->name }}</p>
            <p class="text-sm text-slate-500">{{ $item->email }}</p>
        </div>
        <div class="flex items-center gap-4 text-sm shrink-0">
            <a href="{{ route('admin.kelola-admin.edit', $item) }}" class="text-[#1E3D7B] font-semibold hover:underline">Edit</a>
            @if ($item->id !== auth()->id())
            <form method="POST" action="{{ route('admin.kelola-admin.destroy', $item) }}" onsubmit="return confirm('Hapus admin ini?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 font-semibold hover:underline">Hapus</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
