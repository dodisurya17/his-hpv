<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DiscussionPublicController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'question' => ['required', 'string', 'max:1000'],
        ]);

        $data['name'] = trim((string) ($data['name'] ?? '')) !== '' ? trim($data['name']) : 'Anonymous';

        Discussion::create($data);

        return back()
            ->withFragment('diskusi')
            ->with('status', 'Pertanyaan kamu sudah terkirim. Tunggu jawaban dari admin ya!');
    }
}
