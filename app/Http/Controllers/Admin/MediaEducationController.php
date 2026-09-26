<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaEducation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaEducationController extends Controller
{
    public function index(): View
    {
        $items = MediaEducation::latest()->get();

        return view('admin.media-educations.index', compact('items'));
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
            $data['file_path'] = $request->file('file')->store('media-edukasi', 'public');
        }

        $mediaEducation->update($data);

        return redirect()->route('admin.media-edukasi.index')->with('status', 'Media berhasil diperbarui.');
    }

    public function destroy(MediaEducation $mediaEducation): RedirectResponse
    {
        Storage::disk('public')->delete($mediaEducation->file_path);
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
}
