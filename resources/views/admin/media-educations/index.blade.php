@extends('layouts.admin')

@section('title', 'Media Edukasi')

@section('content')

{{-- Toolbar: pencarian + filter tipe + tombol tambah --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.media-edukasi.index') }}" class="flex flex-col sm:flex-row gap-3 flex-1 min-w-0">
        <div class="relative flex-1 min-w-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-[18px] w-[18px] text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul media..."
                class="w-full rounded-xl border border-slate-200 bg-white !pl-10 !pr-4 !py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3D7B]/20 focus:border-[#1E3D7B]">
            @if ($search !== '')
            <a href="{{ route('admin.media-edukasi.index', ['type' => $type]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" aria-label="Hapus pencarian">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            @endif
        </div>

        <div class="relative shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>
            <select name="type" onchange="this.form.submit()"
                class="w-full sm:w-44 appearance-none rounded-xl border border-slate-200 bg-white !pl-10 !pr-9 !py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#1E3D7B]/20 focus:border-[#1E3D7B]">
                <option value="all" @selected($type==='all' )>Semua tipe</option>
                <option value="poster" @selected($type==='poster' )>Poster</option>
                <option value="presentasi" @selected($type==='presentasi' )>Presentasi</option>
                <option value="video" @selected($type==='video' )>Video</option>
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>

        @if ($search !== '' || $type !== 'all')
        <a href="{{ route('admin.media-edukasi.index') }}"
            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition shrink-0">
            Reset
        </a>
        @endif
    </form>

    <a href="{{ route('admin.media-edukasi.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1E3D7B] text-white px-4 py-2.5 text-sm font-semibold shadow-sm hover:bg-[#16244F] transition shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Media
    </a>
</div>

@if ($search !== '' || $type !== 'all')
<p class="text-sm text-slate-500 mb-3">{{ $items->total() }} media ditemukan.</p>
@endif

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="divide-y divide-slate-100">
        @forelse ($items as $item)
        <div class="flex items-center justify-between p-5 gap-4">
            <div class="min-w-0">
                <span class="text-[11px] font-semibold uppercase text-[#1E3D7B] bg-[#E8EDF9] rounded-full px-2 py-0.5">{{ $item->type }}</span>
                <p class="font-semibold text-slate-800 mt-1 truncate">{{ $item->title }}</p>
            </div>
            <div class="flex items-center gap-4 text-sm shrink-0">
                {{-- href tetap ada sebagai cadangan jika JavaScript tidak aktif --}}
                <a href="{{ $item->file_url }}" target="_blank" rel="noopener"
                    data-preview
                    data-url="{{ $item->file_url }}"
                    data-title="{{ $item->title }}"
                    data-type="{{ $item->type }}"
                    class="text-slate-500 hover:text-slate-700">Lihat file</a>
                <a href="{{ route('admin.media-edukasi.edit', $item) }}" class="text-[#1E3D7B] font-semibold hover:underline">Edit</a>
                <form method="POST" action="{{ route('admin.media-edukasi.destroy', $item) }}" onsubmit="return confirm('Hapus media ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 font-semibold hover:underline">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="p-10 text-center">
            <p class="text-sm text-slate-400">
                @if ($search !== '' || $type !== 'all')
                Tidak ada media yang cocok dengan filter ini.
                @else
                Belum ada media.
                @endif
            </p>
        </div>
        @endforelse
    </div>

    {{ $items->links('admin.partials.pagination') }}
</div>

{{-- Modal preview file --}}
<div id="preview-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6"
    role="dialog" aria-modal="true" aria-labelledby="pv-title">
    <div id="pv-backdrop" class="absolute inset-0 bg-slate-900/60"></div>

    <div class="relative flex max-h-full w-full max-w-4xl flex-col overflow-hidden rounded-2xl bg-white shadow-xl">
        <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4">
            <div class="min-w-0 flex-1">
                <span id="pv-type" class="text-[11px] font-semibold uppercase text-[#1E3D7B] bg-[#E8EDF9] rounded-full px-2 py-0.5"></span>
                <h3 id="pv-title" class="mt-1 truncate text-base font-semibold text-slate-800"></h3>
            </div>

            <a id="pv-open" href="#" target="_blank" rel="noopener" title="Buka di tab baru"
                class="inline-flex shrink-0 items-center gap-1.5 rounded-lg px-2.5 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                <span class="hidden sm:inline">Tab baru</span>
            </a>
            <a id="pv-download" href="#" download title="Unduh file"
                class="inline-flex shrink-0 items-center gap-1.5 rounded-lg px-2.5 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <span class="hidden sm:inline">Unduh</span>
            </a>
            <button type="button" id="pv-close" aria-label="Tutup pratinjau"
                class="shrink-0 rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="relative flex min-h-[50vh] flex-1 items-center justify-center overflow-auto bg-slate-100">
            <div id="pv-loading" class="absolute inset-0 hidden items-center justify-center">
                <svg class="h-7 w-7 animate-spin text-[#1E3D7B]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>
            <div id="pv-stage" class="flex w-full items-center justify-center"></div>
        </div>
    </div>
</div>

<script>
    (function() {
        var modal = document.getElementById('preview-modal');
        var backdrop = document.getElementById('pv-backdrop');
        var stage = document.getElementById('pv-stage');
        var loading = document.getElementById('pv-loading');
        var titleEl = document.getElementById('pv-title');
        var typeEl = document.getElementById('pv-type');
        var openLink = document.getElementById('pv-open');
        var dlLink = document.getElementById('pv-download');
        var closeBtn = document.getElementById('pv-close');

        var IMAGE = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        var VIDEO = ['mp4', 'webm'];
        var OFFICE = ['ppt', 'pptx'];
        var lastTrigger = null;

        function absolute(url) {
            try {
                return new URL(url, window.location.href);
            } catch (e) {
                return null;
            }
        }

        function extOf(url) {
            var u = absolute(url);
            return u ? u.pathname.split('.').pop().toLowerCase() : '';
        }

        // Office viewer hanya bisa membuka file yang bisa diakses dari internet
        function isPublicHost(url) {
            var u = absolute(url);
            if (!u) return false;
            var h = u.hostname;
            if (h === 'localhost' || h === '127.0.0.1' || h === '[::1]') return false;
            if (/\.(test|local|localhost)$/.test(h)) return false;
            if (/^(10\.|192\.168\.|172\.(1[6-9]|2\d|3[01])\.)/.test(h)) return false;
            return true;
        }

        function hideLoading() {
            loading.classList.add('hidden');
            loading.classList.remove('flex');
        }

        function showLoading() {
            loading.classList.remove('hidden');
            loading.classList.add('flex');
        }

        function fallback(url, message) {
            hideLoading();
            stage.innerHTML =
                '<div class="flex flex-col items-center px-6 py-12 text-center">' +
                '<span class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-400 border border-slate-200">' +
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">' +
                '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />' +
                '</svg>' +
                '</span>' +
                '<p class="mt-3 max-w-sm text-sm text-slate-600"></p>' +
                '<a target="_blank" rel="noopener" download class="mt-4 inline-flex items-center rounded-xl bg-[#1E3D7B] px-4 py-2 text-sm font-semibold text-white hover:bg-[#16244F] transition">Unduh file</a>' +
                '</div>';
            stage.querySelector('p').textContent = message;
            stage.querySelector('a').setAttribute('href', url);
        }

        function render(url, title) {
            var ext = extOf(url);
            var el;

            stage.innerHTML = '';
            showLoading();

            if (IMAGE.indexOf(ext) !== -1) {
                el = new Image();
                el.alt = title;
                el.className = 'max-h-[70vh] max-w-full object-contain';
                el.onload = hideLoading;
                el.onerror = function() {
                    fallback(url, 'Gambar tidak dapat ditampilkan.');
                };
                el.src = url;
                stage.appendChild(el);

            } else if (ext === 'pdf') {
                el = document.createElement('iframe');
                el.title = title;
                el.className = 'h-[70vh] w-full border-0 bg-white';
                el.onload = hideLoading;
                el.src = url;
                stage.appendChild(el);

            } else if (VIDEO.indexOf(ext) !== -1) {
                el = document.createElement('video');
                el.controls = true;
                el.preload = 'metadata';
                el.className = 'max-h-[70vh] w-full bg-black';
                el.onloadeddata = hideLoading;
                el.onerror = function() {
                    fallback(url, 'Video tidak dapat diputar di browser ini.');
                };
                el.src = url;
                stage.appendChild(el);

            } else if (OFFICE.indexOf(ext) !== -1) {
                if (isPublicHost(url)) {
                    el = document.createElement('iframe');
                    el.title = title;
                    el.className = 'h-[70vh] w-full border-0 bg-white';
                    el.onload = hideLoading;
                    el.src = 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(absolute(url).href);
                    stage.appendChild(el);
                } else {
                    fallback(url, 'Pratinjau presentasi hanya tersedia jika situs sudah online. Unduh file untuk membukanya.');
                }

            } else {
                fallback(url, 'Format file ini tidak bisa dipratinjau. Unduh file untuk membukanya.');
            }
        }

        function openModal(trigger) {
            var url = trigger.getAttribute('data-url');
            var title = trigger.getAttribute('data-title') || 'Pratinjau file';

            lastTrigger = trigger;
            titleEl.textContent = title;
            typeEl.textContent = trigger.getAttribute('data-type') || '';
            openLink.setAttribute('href', url);
            dlLink.setAttribute('href', url);

            render(url, title);

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            closeBtn.focus();
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            stage.innerHTML = ''; // menghentikan video/iframe yang sedang berjalan
            hideLoading();
            document.body.classList.remove('overflow-hidden');
            if (lastTrigger) lastTrigger.focus();
        }

        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('[data-preview]');
            if (!trigger) return;
            e.preventDefault();
            openModal(trigger);
        });

        closeBtn.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);

        document.addEventListener('keydown', function(e) {
            if (modal.classList.contains('hidden')) return;

            if (e.key === 'Escape') {
                closeModal();
                return;
            }

            // Jaga fokus keyboard tetap di dalam modal
            if (e.key === 'Tab') {
                var focusable = modal.querySelectorAll('a[href], button:not([disabled]), video[controls], iframe');
                if (!focusable.length) return;
                var first = focusable[0];
                var last = focusable[focusable.length - 1];
                if (e.shiftKey && document.activeElement === first) {
                    e.preventDefault();
                    last.focus();
                } else if (!e.shiftKey && document.activeElement === last) {
                    e.preventDefault();
                    first.focus();
                }
            }
        });
    })();
</script>
@endsection