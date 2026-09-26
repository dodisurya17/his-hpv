<?php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use App\Models\Discussion;
use App\Models\MediaEducation;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $profil = ContentBlock::where('section', 'profil')->orderBy('order')->get()->keyBy('key');

        // Dipaginasi 6 per halaman. Page-name "informasi_page" dipakai supaya
        // parameter query-nya tidak bentrok dengan pagination "Box Diskusi" di
        // bawah, yang sama-sama tampil di satu halaman (welcome.blade.php).
        $informasi = ContentBlock::where('section', 'informasi')
            ->orderBy('order')
            ->paginate(6, ['*'], 'informasi_page')
            ->withQueryString();
        $informasi->setCollection($informasi->getCollection()->keyBy('key'));

        $mediaByType = MediaEducation::latest()->get()->groupBy('type');

        $discussions = Discussion::answered()
            ->with('answeredBy')
            ->latest('answered_at')
            ->paginate(6)
            ->withQueryString();

        return view('welcome', compact('profil', 'informasi', 'mediaByType', 'discussions'));
    }
}
