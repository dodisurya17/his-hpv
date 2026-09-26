{{--
    Partial pagination untuk halaman publik (welcome.blade.php), gaya disamakan
    dengan pagination di dashboard admin: kartu putih, nomor halaman aktif
    berupa kotak solid warna navy brand.
    Dipakai lewat: {{ $paginator->links('partials.pagination') }}
    Laravel otomatis menyediakan variabel $paginator dan $elements ke view ini.
--}}
@if ($paginator->hasPages())
<nav class="flex flex-col sm:flex-row items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white px-5 py-4" aria-label="Navigasi halaman">
    <p class="text-xs sm:text-sm text-slate-500 order-2 sm:order-1">
        Menampilkan <span class="font-semibold text-brand-navy">{{ $paginator->firstItem() }}</span>–<span class="font-semibold text-brand-navy">{{ $paginator->lastItem() }}</span>
        dari <span class="font-semibold text-brand-navy">{{ $paginator->total() }}</span> data
    </p>

    <div class="flex items-center gap-1 order-1 sm:order-2">
        {{-- Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-slate-300" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors" aria-label="Halaman sebelumnya">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
        @endif

        {{-- Nomor halaman: disembunyikan di layar kecil supaya tetap ringkas di mobile --}}
        <div class="hidden sm:flex items-center gap-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="h-9 w-9 inline-flex items-center justify-center text-sm text-slate-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="h-9 w-9 inline-flex items-center justify-center rounded-lg bg-[var(--navy-700)] text-white text-sm font-semibold" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="h-9 w-9 inline-flex items-center justify-center rounded-lg text-slate-600 text-sm font-medium hover:bg-slate-100 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Indikator halaman ringkas khusus mobile --}}
        <span class="sm:hidden text-sm font-medium text-slate-600 px-2">
            {{ $paginator->currentPage() }}/{{ $paginator->lastPage() }}
        </span>

        {{-- Berikutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors" aria-label="Halaman berikutnya">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        @else
            <span class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-slate-300" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </span>
        @endif
    </div>
</nav>
@endif
