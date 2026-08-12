<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'projectsCount' => Project::count(),
            'toolsCount' => Tool::count(),
            'certificatesCount' => Certificate::count(),
            'experiencesCount' => Experience::count(),
            'recentProjects' => Project::orderByDesc('id')->limit(5)->get(),
        ]);
    }
}
