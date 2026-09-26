<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscussionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $status = $request->query('status', 'all');

        $discussions = Discussion::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('question', 'like', "%{$search}%");
                });
            })
            ->when($status === 'answered', fn($query) => $query->whereNotNull('answer'))
            ->when($status === 'unanswered', fn($query) => $query->whereNull('answer'))
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.discussions.index', compact('discussions', 'search', 'status'));
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
