<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Project::create([
            'nama' => $data['nama'],
            'desk' => $data['desk'],
            'full_desk' => $data['full_desk'] ?? null,
            'link' => $data['link'] ?? null,
            'tools' => $this->linesToArray($data['tools'] ?? null),
            'fitur' => $this->linesToArray($data['fitur'] ?? null),
            'gambar' => $this->resolveImage($request, 'projects'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateData($request);

        $project->update([
            'nama' => $data['nama'],
            'desk' => $data['desk'],
            'full_desk' => $data['full_desk'] ?? null,
            'link' => $data['link'] ?? null,
            'tools' => $this->linesToArray($data['tools'] ?? null),
            'fitur' => $this->linesToArray($data['fitur'] ?? null),
            'gambar' => $this->resolveImage($request, 'projects', $project->gambar),
            'sort_order' => $data['sort_order'] ?? $project->sort_order,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'desk' => ['required', 'string'],
            'full_desk' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'tools' => ['nullable', 'string'],
            'fitur' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gambar_url' => ['nullable', 'url'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'nama' => 'Nama project',
            'desk' => 'Deskripsi singkat',
            'full_desk' => 'Deskripsi lengkap',
            'link' => 'Link project',
            'tools' => 'Teknologi',
            'fitur' => 'Fitur utama',
            'gambar' => 'Gambar',
            'gambar_url' => 'URL gambar',
            'sort_order' => 'Urutan',
        ]);
    }
}
