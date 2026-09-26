<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentBlockController extends Controller
{
    public function index(string $section): View
    {
        abort_unless(in_array($section, ['profil', 'informasi'], true), 404);

        $items = ContentBlock::where('section', $section)->orderBy('order')->get();

        return view('admin.content.index', compact('items', 'section'));
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
}
