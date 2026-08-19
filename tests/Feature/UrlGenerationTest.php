<?php

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Experience;
use App\Models\Project;

test('landing page loads successfully even if a project has empty slug', function () {
    $category = Category::create(['nama' => 'Web App']);

    $project = Project::create([
        'nama' => 'Test Project Without Slug',
        'desk' => 'Test description',
        'category_id' => $category->id,
    ]);

    \Illuminate\Support\Facades\DB::table('projects')
        ->where('id', $project->id)
        ->update(['slug' => '']);

    $freshProject = Project::find($project->id);
    expect($freshProject->slug)->toBe('');

    $url = route('project.show', $freshProject);
    expect($url)->toContain('/project/');

    $this->get(route('landing'))
        ->assertOk()
        ->assertSee('Test Project Without Slug');
});

test('route model binding resolves project by slug and by id', function () {
    $project = Project::create([
        'nama' => 'Test Binding Project',
        'desk' => 'Test description',
    ]);

    $this->get(route('project.show', $project->slug))
        ->assertOk()
        ->assertSee('Test Binding Project');

    $this->get(route('project.show', $project->id))
        ->assertOk()
        ->assertSee('Test Binding Project');
});

test('experience route generation works with empty slug', function () {
    $experience = Experience::create([
        'role' => 'Software Developer',
        'company' => 'Tech Corp',
        'duration' => '2024 - Present',
        'desk' => 'Test experience description',
    ]);

    \Illuminate\Support\Facades\DB::table('experiences')
        ->where('id', $experience->id)
        ->update(['slug' => '']);

    $freshExperience = Experience::find($experience->id);

    $url = route('experience.show', $freshExperience);
    expect($url)->toContain('/experience/');

    $this->get($url)
        ->assertOk()
        ->assertSee('Software Developer');
});

test('certificate route generation works with empty slug', function () {
    $certificate = Certificate::create([
        'nama' => 'Web Certification',
        'penerbit' => 'Test Publisher',
        'tanggal' => '2025',
        'desk' => 'Test certificate description',
    ]);

    \Illuminate\Support\Facades\DB::table('certificates')
        ->where('id', $certificate->id)
        ->update(['slug' => '']);

    $freshCertificate = Certificate::find($certificate->id);

    $url = route('certificate.show', $freshCertificate);
    expect($url)->toContain('/certificate/');

    $this->get($url)
        ->assertOk()
        ->assertSee('Web Certification');
});

test('course route generation works with empty slug', function () {
    $course = Course::create([
        'nama' => 'Test Course',
        'desk' => 'Test course description',
    ]);

    \Illuminate\Support\Facades\DB::table('courses')
        ->where('id', $course->id)
        ->update(['slug' => '']);

    $freshCourse = Course::find($course->id);

    $url = route('course.show', $freshCourse);
    expect($url)->toContain('/course/');

    $this->get($url)
        ->assertOk()
        ->assertSee('Test Course');
});
