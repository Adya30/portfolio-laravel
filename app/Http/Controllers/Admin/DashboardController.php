<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()?->isMateriOnly()) {
            return redirect()->route('admin.courses.index');
        }

        return view('admin.dashboard', [
            'projectsCount' => Project::count(),
            'toolsCount' => Tool::count(),
            'certificatesCount' => Certificate::count(),
            'experiencesCount' => Experience::count(),
            'coursesCount' => Course::count(),
            'recentProjects' => Project::orderByDesc('id')->limit(5)->get(),
        ]);
    }
}
