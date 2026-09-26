<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContentBlockController extends Controller
{
    public function index(Request $request, string $section): View
    {
        abort_unless(in_array($section, ['profil', 'informasi'], true), 404);

        $search = trim((string) $request->query('q', ''));

        $items = ContentBlock::where('section', $section)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('order')
            ->paginate(5)
            ->withQueryString();

        return view('admin.content.index', compact('items', 'section', 'search'));
    }

    public function create(string $section): View
    {
        abort_unless(in_array($section, ['profil', 'informasi'], true), 404);

        return view('admin.content.create', compact('section'));
    }

    public function store(Request $request, string $section): RedirectResponse
    {
        abort_unless(in_array($section, ['profil', 'informasi'], true), 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $data['section'] = $section;
        $data['order'] = (int) ContentBlock::where('section', $section)->max('order') + 1;
        $data['key'] = $this->generateUniqueKey($section, $data['title']);

        ContentBlock::create($data);

        return redirect()
            ->route('admin.content.index', $section)
            ->with('status', 'Konten berhasil ditambahkan.');
    }

    public function edit(ContentBlock $contentBlock): View
    {
        return view('admin.content.edit', compact('contentBlock'));
    }

    public function update(Request $request, ContentBlock $contentBlock): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $contentBlock->update($data);

        return redirect()
            ->route('admin.content.index', $contentBlock->section)
            ->with('status', 'Konten berhasil diperbarui.');
    }

    public function destroy(ContentBlock $contentBlock): RedirectResponse
    {
        $section = $contentBlock->section;

        $contentBlock->delete();

        return redirect()
            ->route('admin.content.index', $section)
            ->with('status', 'Konten berhasil dihapus.');
    }

    /**
     * Buat "key" unik berbasis section + judul, karena kolom ini wajib diisi
     * (dipakai sebagai identifier tetap) tapi tidak diinput lewat form.
     */
    private function generateUniqueKey(string $section, string $title): string
    {
        $base = $section . '_' . Str::slug($title, '_');
        $key = $base;
        $suffix = 1;

        while (ContentBlock::where('key', $key)->exists()) {
            $suffix++;
            $key = $base . '_' . $suffix;
        }

        return $key;
    }
}
