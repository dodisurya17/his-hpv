<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscussionController extends Controller
{
    public function index(): View
    {
        $discussions = Discussion::latest()->get();

        return view('admin.discussions.index', compact('discussions'));
    }

    public function edit(Discussion $discussion): View
    {
        return view('admin.discussions.edit', compact('discussion'));
    }

    public function update(Request $request, Discussion $discussion): RedirectResponse
    {
        $data = $request->validate([
            'answer' => ['required', 'string', 'max:2000'],
        ]);

        $discussion->update([
            'answer' => $data['answer'],
            'answered_by' => $request->user()->id,
            'answered_at' => now(),
        ]);

        return redirect()->route('admin.discussions.index')->with('status', 'Jawaban berhasil disimpan.');
    }

    public function destroy(Discussion $discussion): RedirectResponse
    {
        $discussion->delete();

        return back()->with('status', 'Pertanyaan berhasil dihapus.');
    }
}
