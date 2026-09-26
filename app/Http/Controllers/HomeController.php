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
        $informasi = ContentBlock::where('section', 'informasi')->orderBy('order')->get()->keyBy('key');
        $mediaByType = MediaEducation::latest()->get()->groupBy('type');
        $discussions = Discussion::answered()
            ->with('answeredBy')
            ->latest('answered_at')
            ->paginate(6)
            ->withQueryString();

        return view('welcome', compact('profil', 'informasi', 'mediaByType', 'discussions'));
    }
}
