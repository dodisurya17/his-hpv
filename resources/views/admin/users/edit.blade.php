@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')
<form method="POST" action="{{ route('admin.kelola-admin.update', $admin) }}" class="max-w-md bg-white rounded-xl border border-slate-200 p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
        <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Password baru (opsional)</label>
        <input type="password" name="password" class="w-full rounded-lg border-slate-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password baru</label>
        <input type="password" name="password_confirmation" class="w-full rounded-lg border-slate-300">
    </div>
    <button class="rounded-lg bg-[#1E3D7B] text-white px-5 py-2.5 text-sm font-semibold hover:bg-[#16244F]">Simpan</button>
</form>
@endsection
