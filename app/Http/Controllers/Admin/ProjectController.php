<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::with('category')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.create', [
            'categories' => Category::orderBy('id')->get(),
            'tools' => Tool::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Project::create([
            'nama' => $data['nama'],
            'desk' => $data['desk'],
            'desk_idn' => $data['desk_idn'] ?? null,
            'full_desk' => $data['full_desk'] ?? null,
            'full_desk_idn' => $data['full_desk_idn'] ?? null,
            'link' => $data['link'] ?? null,
            'link_live' => $data['link_live'] ?? null,
            'tools' => $data['tools'] ?? [],
            'fitur' => $this->linesToArray($data['fitur'] ?? null),
            'fitur_idn' => $this->linesToArray($data['fitur_idn'] ?? null),
            'gambar' => $this->resolveImage($request, 'projects'),
            'category_id' => $data['category_id'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', [
            'project' => $project->load('category'),
            'categories' => Category::orderBy('id')->get(),
            'tools' => Tool::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateData($request);

        $project->update([
            'nama' => $data['nama'],
            'desk' => $data['desk'],
            'desk_idn' => $data['desk_idn'] ?? null,
            'full_desk' => $data['full_desk'] ?? null,
            'full_desk_idn' => $data['full_desk_idn'] ?? null,
            'link' => $data['link'] ?? null,
            'link_live' => $data['link_live'] ?? null,
            'tools' => $data['tools'] ?? [],
            'fitur' => $this->linesToArray($data['fitur'] ?? null),
            'fitur_idn' => $this->linesToArray($data['fitur_idn'] ?? null),
            'gambar' => $this->resolveImage($request, 'projects', $project->gambar),
            'category_id' => $data['category_id'] ?? null,
            'sort_order' => $data['sort_order'] ?? $project->sort_order,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        foreach ($ids as $index => $id) {
            Project::whereKey($id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['ok' => true]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'desk' => ['required', 'string'],
            'desk_idn' => ['nullable', 'string'],
            'full_desk' => ['nullable', 'string'],
            'full_desk_idn' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'link_live' => ['nullable', 'url'],
            'tools' => ['nullable', 'array'],
            'tools.*' => ['integer', 'exists:tools,id'],
            'fitur' => ['nullable', 'string'],
            'fitur_idn' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image:allow_svg', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gambar_url' => ['nullable', 'url'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'nama' => 'Nama project',
            'desk' => 'Deskripsi singkat',
            'desk_idn' => 'Deskripsi singkat (Indonesia)',
            'full_desk' => 'Deskripsi lengkap',
            'full_desk_idn' => 'Deskripsi lengkap (Indonesia)',
            'link' => 'Link GitHub',
            'link_live' => 'Link live',
            'tools' => 'Teknologi',
            'fitur' => 'Fitur utama',
            'fitur_idn' => 'Fitur utama (Indonesia)',
            'gambar' => 'Gambar',
            'gambar_url' => 'URL gambar',
            'category_id' => 'Kategori',
            'sort_order' => 'Urutan',
        ]);
    }
}
