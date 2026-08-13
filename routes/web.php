<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ToolController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// SEO: sitemap & robots (dinamis, mengikuti APP_URL)
Route::get('/sitemap.xml', [LandingController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', function () {
    $content = "User-agent: *\n"
        ."Allow: /\n"
        ."Disallow: /admin\n"
        ."Disallow: /login\n\n"
        .'Sitemap: '.url('/sitemap.xml')."\n";

    return response($content, 200, ['Content-Type' => 'text/plain']);
})->name('robots');

Route::get('/project/{project}', [LandingController::class, 'showProject'])->name('project.show');
Route::get('/experience/{experience}', [LandingController::class, 'showExperience'])->name('experience.show');
Route::get('/certificate/{certificate}', [LandingController::class, 'showCertificate'])->name('certificate.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Drag & drop row ordering (kept before the resource routes).
    Route::post('projects/reorder', [ProjectController::class, 'reorder'])->name('projects.reorder');
    Route::post('tools/reorder', [ToolController::class, 'reorder'])->name('tools.reorder');
    Route::post('certificates/reorder', [CertificateController::class, 'reorder'])->name('certificates.reorder');
    Route::post('experiences/reorder', [ExperienceController::class, 'reorder'])->name('experiences.reorder');

    Route::resource('categories', CategoryController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tools', ToolController::class);
    Route::resource('certificates', CertificateController::class);
    Route::resource('experiences', ExperienceController::class);

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
