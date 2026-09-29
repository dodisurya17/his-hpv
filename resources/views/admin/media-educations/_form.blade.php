{{--
    Partial form Media Edukasi (dipakai oleh create & edit).
    Variabel:
      $action          : URL tujuan form
      $mediaEducation  : model MediaEducation (null saat tambah baru)
--}}
@php
    $isEdit      = !empty($mediaEducation);
    $currentType = old('type', $isEdit ? $mediaEducation->type : 'poster');

    $types = [
        'poster' => [
            'label' => 'Poster',
            'hint'  => 'Gambar atau PDF',
            'icon'  => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
        ],
        'presentasi' => [
            'label' => 'Presentasi',
            'hint'  => 'Slide PPT atau PPTX',
            'icon'  => 'M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6',
        ],
        'video' => [
            'label' => 'Video',
            'hint'  => 'MP4 atau WEBM',
            'icon'  => 'M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z',
        ],
    ];

    $docIcon = 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z';

    if ($isEdit) {
        $fileUrl   = $mediaEducation->file_url;
        $filePath  = strtolower(parse_url((string) $fileUrl, PHP_URL_PATH) ?? '');
        $fileName  = basename($filePath);
        $isImage   = \Illuminate\Support\Str::endsWith($filePath, ['.jpg', '.jpeg', '.png']);
    }
@endphp

<form id="media-form" method="POST" action="{{ $action }}" enctype="multipart/form-data"
      class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    {{-- Ringkasan error --}}
    @if ($errors->any())
    <div class="m-6 mb-0 rounded-xl border border-red-200 bg-red-50 p-4 flex gap-3" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
        </svg>
        <div class="text-sm">
            <p class="font-semibold text-red-700">Media belum bisa disimpan</p>
            <ul class="mt-1 list-disc pl-4 text-red-600 space-y-0.5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="p-6 sm:p-8 space-y-8">

        {{-- 1. Jenis media --}}
        <fieldset>
            <legend class="text-sm font-semibold text-slate-800">Jenis media</legend>
            <p class="text-sm text-slate-500 mt-0.5">Pilih format yang paling sesuai dengan file Anda.</p>

            <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                @foreach ($types as $value => $t)
                <label class="relative block cursor-pointer">
                    <input type="radio" name="type" value="{{ $value }}" class="peer sr-only" @checked($currentType === $value)>
                    <span class="pointer-events-none absolute top-3 right-3 hidden peer-checked:flex h-5 w-5 items-center justify-center rounded-full bg-[#1E3D7B] text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </span>
                    <div class="flex sm:flex-col items-center sm:items-start gap-3 rounded-xl border-2 border-slate-200 bg-white p-4 transition
                                hover:border-slate-300 peer-checked:border-[#1E3D7B] peer-checked:bg-[#E8EDF9]/60
                                peer-focus-visible:ring-2 peer-focus-visible:ring-[#1E3D7B]/30">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#E8EDF9] text-[#1E3D7B]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}" />
                            </svg>
                        </span>
                        <span>
                            <span class="block text-sm font-semibold text-slate-800">{{ $t['label'] }}</span>
                            <span class="block text-xs text-slate-500 mt-0.5">{{ $t['hint'] }}</span>
                        </span>
                    </div>
                </label>
                @endforeach
            </div>
            @error('type')
            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </fieldset>

        {{-- 2. Informasi --}}
        <div class="space-y-5">
            <div>
                <label for="title" class="block text-sm font-semibold text-slate-800">Judul <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" required
                       value="{{ old('title', $isEdit ? $mediaEducation->title : '') }}"
                       placeholder="Contoh: Poster pencegahan kanker serviks"
                       class="mt-1.5 w-full rounded-xl border bg-white !px-4 !py-2.5 text-sm text-slate-700 placeholder:text-slate-400
                              focus:outline-none focus:ring-2 focus:ring-[#1E3D7B]/20 focus:border-[#1E3D7B]
                              @error('title') border-red-400 @else border-slate-200 @enderror">
                @error('title')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-baseline justify-between">
                    <label for="description" class="block text-sm font-semibold text-slate-800">Deskripsi</label>
                    <span class="text-xs text-slate-400">Opsional</span>
                </div>
                <textarea id="description" name="description" rows="4"
                          placeholder="Jelaskan singkat isi media ini agar mudah dipahami pembaca."
                          class="mt-1.5 w-full rounded-xl border bg-white !px-4 !py-2.5 text-sm text-slate-700 placeholder:text-slate-400
                                 focus:outline-none focus:ring-2 focus:ring-[#1E3D7B]/20 focus:border-[#1E3D7B]
                                 @error('description') border-red-400 @else border-slate-200 @enderror">{{ old('description', $isEdit ? $mediaEducation->description : '') }}</textarea>
                @error('description')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- 3. File --}}
        <div>
            <label for="file" class="block text-sm font-semibold text-slate-800">
                {{ $isEdit ? 'Ganti file' : 'File' }}
                @unless ($isEdit)<span class="text-red-500">*</span>@endunless
            </label>
            <p class="text-sm text-slate-500 mt-0.5">
                {{ $isEdit ? 'Biarkan kosong jika tidak ingin mengganti file yang sudah ada.' : 'Tarik file ke area di bawah, atau klik untuk memilih dari perangkat.' }}
            </p>

            @if ($isEdit)
            {{-- File saat ini --}}
            <div class="mt-3 flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50 p-3">
                <div class="h-14 w-14 shrink-0 overflow-hidden rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400">
                    @if ($isImage)
                        <img src="{{ $fileUrl }}" alt="Pratinjau file saat ini" class="h-full w-full object-cover">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $docIcon }}" />
                        </svg>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-slate-500">File saat ini</p>
                    <p class="text-sm font-medium text-slate-800 truncate">{{ $fileName ?: 'File terunggah' }}</p>
                </div>
                <a href="{{ $fileUrl }}" target="_blank" rel="noopener"
                   class="shrink-0 text-sm font-semibold text-[#1E3D7B] hover:underline">Lihat file</a>
            </div>
            @endif

            {{-- Area unggah --}}
            <label id="dropzone" for="file"
                   class="mt-3 flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50/60 px-6 py-10 text-center transition
                          hover:border-[#1E3D7B] hover:bg-[#E8EDF9]/40 focus-within:border-[#1E3D7B] focus-within:ring-2 focus-within:ring-[#1E3D7B]/20">
                <input type="file" id="file" name="file" class="sr-only"
                       accept=".jpg,.jpeg,.png,.pdf,.ppt,.pptx,.mp4,.webm"
                       @unless ($isEdit) required @endunless>
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-[#E8EDF9] text-[#1E3D7B]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                    </svg>
                </span>
                <span class="mt-3 text-sm font-semibold text-slate-700">
                    <span class="text-[#1E3D7B]">Pilih file</span> atau tarik ke sini
                </span>
                <span class="mt-1 text-xs text-slate-500">JPG, PNG, PDF, PPT, PPTX, MP4, WEBM &middot; maksimal 20 MB</span>
            </label>

            {{-- File yang baru dipilih --}}
            <div id="file-picked" class="mt-3 hidden items-center gap-4 rounded-xl border border-[#1E3D7B]/30 bg-[#E8EDF9]/50 p-3">
                <div id="file-thumb" class="h-14 w-14 shrink-0 overflow-hidden rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400"></div>
                <div class="min-w-0 flex-1">
                    <p id="file-name" class="text-sm font-medium text-slate-800 truncate"></p>
                    <p id="file-size" class="text-xs text-slate-500 mt-0.5"></p>
                </div>
                <button type="button" id="file-remove"
                        class="shrink-0 rounded-lg p-2 text-slate-500 hover:bg-white hover:text-red-600 transition" aria-label="Hapus file yang dipilih">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p id="file-error" class="mt-2 hidden text-xs text-red-600" role="alert"></p>
            @error('file')
            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Aksi --}}
    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:px-8">
        <a href="{{ route('admin.media-edukasi.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">
            Batal
        </a>
        <button type="submit" id="submit-btn"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1E3D7B] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#16244F] transition
                       focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1E3D7B]/40 focus-visible:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed">
            <svg id="submit-spinner" class="hidden h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span id="submit-label">Simpan perubahan</span>
        </button>
    </div>
</form>

<script>
(function () {
    var form      = document.getElementById('media-form');
    var input     = document.getElementById('file');
    var dropzone  = document.getElementById('dropzone');
    var picked    = document.getElementById('file-picked');
    var thumb     = document.getElementById('file-thumb');
    var nameEl    = document.getElementById('file-name');
    var sizeEl    = document.getElementById('file-size');
    var removeBtn = document.getElementById('file-remove');
    var errorEl   = document.getElementById('file-error');
    var submitBtn = document.getElementById('submit-btn');
    var spinner   = document.getElementById('submit-spinner');
    var label     = document.getElementById('submit-label');

    var MAX_BYTES = 20 * 1024 * 1024;
    var TYPE_BY_EXT = {
        jpg: 'poster', jpeg: 'poster', png: 'poster',
        ppt: 'presentasi', pptx: 'presentasi',
        mp4: 'video', webm: 'video'
    };
    var ALLOWED = ['jpg', 'jpeg', 'png', 'pdf', 'ppt', 'pptx', 'mp4', 'webm'];
    var DOC_ICON = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $docIcon }}"/></svg>';
    var previewUrl = null;

    // Label tombol: "Simpan media" saat tambah, "Simpan perubahan" saat edit
    label.textContent = {{ $isEdit ? 'true' : 'false' }} ? 'Simpan perubahan' : 'Simpan media';

    function formatSize(bytes) {
        if (bytes < 1024 * 1024) return Math.max(1, Math.round(bytes / 1024)) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function showError(msg) {
        errorEl.textContent = msg;
        errorEl.classList.toggle('hidden', !msg);
    }

    function clearPreview() {
        if (previewUrl) { URL.revokeObjectURL(previewUrl); previewUrl = null; }
    }

    function reset() {
        input.value = '';
        clearPreview();
        picked.classList.add('hidden');
        picked.classList.remove('flex');
        dropzone.classList.remove('hidden');
    }

    function handle(file) {
        var ext = (file.name.split('.').pop() || '').toLowerCase();

        if (ALLOWED.indexOf(ext) === -1) {
            reset();
            showError('Format .' + ext + ' tidak didukung. Gunakan JPG, PNG, PDF, PPT, PPTX, MP4, atau WEBM.');
            return;
        }
        if (file.size > MAX_BYTES) {
            reset();
            showError('Ukuran file ' + formatSize(file.size) + ' melebihi batas 20 MB.');
            return;
        }
        showError('');

        clearPreview();
        if (['jpg', 'jpeg', 'png'].indexOf(ext) !== -1) {
            previewUrl = URL.createObjectURL(file);
            thumb.innerHTML = '<img src="' + previewUrl + '" alt="Pratinjau" class="h-full w-full object-cover">';
        } else {
            thumb.innerHTML = DOC_ICON;
        }

        nameEl.textContent = file.name;
        sizeEl.textContent = formatSize(file.size);
        dropzone.classList.add('hidden');
        picked.classList.remove('hidden');
        picked.classList.add('flex');

        // Pilih jenis media otomatis berdasarkan ekstensi (PDF dibiarkan sesuai pilihan pengguna)
        var guess = TYPE_BY_EXT[ext];
        if (guess) {
            var radio = form.querySelector('input[name="type"][value="' + guess + '"]');
            if (radio) radio.checked = true;
        }
    }

    input.addEventListener('change', function () {
        if (input.files && input.files[0]) handle(input.files[0]);
    });

    removeBtn.addEventListener('click', function () {
        reset();
        showError('');
    });

    // Drag & drop
    ['dragenter', 'dragover'].forEach(function (evt) {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            dropzone.classList.add('border-[#1E3D7B]', 'bg-[#E8EDF9]/40');
        });
    });
    ['dragleave', 'drop'].forEach(function (evt) {
        dropzone.addEventListener(evt, function (e) {
            e.preventDefault();
            dropzone.classList.remove('border-[#1E3D7B]', 'bg-[#E8EDF9]/40');
        });
    });
    dropzone.addEventListener('drop', function (e) {
        var files = e.dataTransfer && e.dataTransfer.files;
        if (!files || !files.length) return;
        var dt = new DataTransfer();
        dt.items.add(files[0]);
        input.files = dt.files;
        handle(files[0]);
    });

    // Cegah klik ganda & beri tahu bahwa unggahan sedang berjalan
    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        spinner.classList.remove('hidden');
        label.textContent = (input.files && input.files.length) ? 'Mengunggah file...' : 'Menyimpan...';
    });
})();
</script>
