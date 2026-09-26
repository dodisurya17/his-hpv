<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\MediaEducation;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'mediaCount' => MediaEducation::count(),
            'unansweredCount' => Discussion::unanswered()->count(),
            'adminCount' => User::count(),
        ]);
    }
}
