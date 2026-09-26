<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaEducation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Imagick;
use Symfony\Component\Process\Process;
use Throwable;

class MediaEducationController extends Controller
{
    /**
     * Ekstensi yang dicoba dijadikan thumbnail (halaman/slide pertama).
     * Gambar & video tidak butuh thumbnail terpisah karena filenya sendiri
     * sudah bisa langsung ditampilkan.
     */
    private const THUMBNAILABLE_EXTENSIONS = ['pdf', 'ppt', 'pptx'];

    /**
     * Nilai valid untuk filter "type" pada halaman index.
     */
    private const FILTERABLE_TYPES = ['poster', 'presentasi', 'video'];

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $type = $request->query('type', 'all');

        $items = MediaEducation::query()
            ->when($search !== '', fn($query) => $query->where('title', 'like', "%{$search}%"))
            ->when(
                in_array($type, self::FILTERABLE_TYPES, true),
                fn($query) => $query->where('type', $type)
            )
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.media-educations.index', compact('items', 'search', 'type'));
    }

    public function create(): View
    {
        return view('admin.media-educations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, required: true);

        $file = $request->file('file');
        unset($data['file']);
        $data['file_path'] = $file->store('media-edukasi', 'public');
        $data['thumbnail_path'] = $this->generateThumbnail($file, $data['file_path']);

        MediaEducation::create($data);

        return redirect()->route('admin.media-edukasi.index')->with('status', 'Media berhasil ditambahkan.');
    }

    public function edit(MediaEducation $mediaEducation): View
    {
        return view('admin.media-educations.edit', compact('mediaEducation'));
    }

    public function update(Request $request, MediaEducation $mediaEducation): RedirectResponse
    {
        $data = $this->validated($request, required: false);
        unset($data['file']);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($mediaEducation->file_path);
            if ($mediaEducation->thumbnail_path) {
                Storage::disk('public')->delete($mediaEducation->thumbnail_path);
            }

            $file = $request->file('file');
            $data['file_path'] = $file->store('media-edukasi', 'public');
            $data['thumbnail_path'] = $this->generateThumbnail($file, $data['file_path']);
        }

        $mediaEducation->update($data);

        return redirect()->route('admin.media-edukasi.index')->with('status', 'Media berhasil diperbarui.');
    }

    public function destroy(MediaEducation $mediaEducation): RedirectResponse
    {
        Storage::disk('public')->delete($mediaEducation->file_path);
        if ($mediaEducation->thumbnail_path) {
            Storage::disk('public')->delete($mediaEducation->thumbnail_path);
        }
        $mediaEducation->delete();

        return back()->with('status', 'Media berhasil dihapus.');
    }

    private function validated(Request $request, bool $required): array
    {
        return $request->validate([
            'type' => ['required', 'in:poster,presentasi,video'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'file' => [$required ? 'required' : 'nullable', 'file', 'max:20480', 'mimes:jpg,jpeg,png,pdf,ppt,pptx,mp4,webm'],
        ]);
    }

    /**
     * Buat thumbnail JPG dari halaman/slide pertama file PDF/PPT/PPTX yang baru
     * disimpan. Mengembalikan path relatif di disk "public", atau null kalau
     * tipe filenya tidak perlu thumbnail atau proses konversinya gagal/tidak
     * tersedia di server (fitur ini fail-safe: upload tetap sukses tanpa thumbnail).
     *
     * Butuh di server:
     *  - ekstensi PHP "imagick" + Ghostscript (untuk merender halaman PDF)
     *  - binari LibreOffice ("soffice"/"libreoffice") di PATH (khusus PPT/PPTX,
     *    dipakai untuk mengonversi slide pertama ke PDF sebelum dirender)
     */
    private function generateThumbnail(UploadedFile $file, string $storedPath): ?string
    {
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, self::THUMBNAILABLE_EXTENSIONS, true) || !class_exists(Imagick::class)) {
            return null;
        }

        $sourcePath = Storage::disk('public')->path($storedPath);
        $pdfPath = $ext === 'pdf' ? $sourcePath : $this->convertOfficeToPdf($sourcePath);

        if (!$pdfPath || !is_file($pdfPath)) {
            return null;
        }

        try {
            $imagick = new Imagick();
            $imagick->setResolution(150, 150);
            $imagick->readImage($pdfPath . '[0]'); // hanya halaman/slide pertama
            $imagick->setImageFormat('jpg');
            $imagick->setImageCompressionQuality(85);
            $imagick->flattenImages();
            $imagick->resizeImage(1000, 0, Imagick::FILTER_LANCZOS, 1, true);

            $thumbnailPath = 'media-edukasi/thumbnails/' . uniqid('thumb_', true) . '.jpg';
            Storage::disk('public')->put($thumbnailPath, $imagick->getImageBlob());

            $imagick->clear();
            $imagick->destroy();

            return $thumbnailPath;
        } catch (Throwable $e) {
            report($e);

            return null;
        } finally {
            // Bersihkan PDF hasil konversi sementara (bukan file PDF asli milik user)
            if ($ext !== 'pdf' && is_file($pdfPath)) {
                @unlink($pdfPath);
            }
        }
    }

    /**
     * Konversi .ppt/.pptx ke .pdf lewat LibreOffice headless supaya halaman
     * pertamanya bisa dirender jadi gambar. Mengembalikan null kalau LibreOffice
     * tidak terpasang di server atau konversinya gagal.
     */
    private function convertOfficeToPdf(string $sourcePath): ?string
    {
        $binary = $this->resolveLibreOfficeBinary();

        if (!$binary) {
            return null;
        }

        $outputDir = sys_get_temp_dir();

        $process = new Process([
            $binary,
            '--headless',
            '--norestore',
            '--convert-to',
            'pdf',
            '--outdir',
            $outputDir,
            $sourcePath,
        ]);
        $process->setTimeout(90);

        try {
            $process->run();
        } catch (Throwable $e) {
            report($e);

            return null;
        }

        if (!$process->isSuccessful()) {
            report(new \RuntimeException('Konversi LibreOffice gagal: ' . $process->getErrorOutput()));

            return null;
        }

        $expectedPdf = rtrim($outputDir, '/') . '/' . pathinfo($sourcePath, PATHINFO_FILENAME) . '.pdf';

        return is_file($expectedPdf) ? $expectedPdf : null;
    }

    private function resolveLibreOfficeBinary(): ?string
    {
        foreach (['soffice', 'libreoffice'] as $binary) {
            $path = trim((string) shell_exec('command -v ' . escapeshellarg($binary) . ' 2>/dev/null'));
            if ($path !== '') {
                return $path;
            }
        }

        return null;
    }
}
