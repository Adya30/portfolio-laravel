<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        return view('admin.experiences.index', [
            'experiences' => Experience::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Experience::create([
            'role' => $data['role'],
            'role_idn' => $data['role_idn'] ?? null,
            'company' => $data['company'],
            'duration' => $data['duration'] ?? null,
            'location' => $data['location'] ?? null,
            'desk' => $data['desk'],
            'desk_idn' => $data['desk_idn'] ?? null,
            'practicum_desc' => $data['practicum_desc'] ?? null,
            'practicum_desc_idn' => $data['practicum_desc_idn'] ?? null,
            'gambar' => $this->resolveImage($request, 'experiences'),
            'responsibilities' => $this->linesToArray($data['responsibilities'] ?? null),
            'responsibilities_idn' => $this->linesToArray($data['responsibilities_idn'] ?? null),
            'skills' => $this->linesToArray($data['skills'] ?? null),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil ditambahkan.');
    }

    public function edit(Experience $experience): View
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $data = $this->validateData($request);

        $experience->update([
            'role' => $data['role'],
            'role_idn' => $data['role_idn'] ?? null,
            'company' => $data['company'],
            'duration' => $data['duration'] ?? null,
            'location' => $data['location'] ?? null,
            'desk' => $data['desk'],
            'desk_idn' => $data['desk_idn'] ?? null,
            'practicum_desc' => $data['practicum_desc'] ?? null,
            'practicum_desc_idn' => $data['practicum_desc_idn'] ?? null,
            'gambar' => $this->resolveImage($request, 'experiences', $experience->gambar),
            'responsibilities' => $this->linesToArray($data['responsibilities'] ?? null),
            'responsibilities_idn' => $this->linesToArray($data['responsibilities_idn'] ?? null),
            'skills' => $this->linesToArray($data['skills'] ?? null),
            'sort_order' => $data['sort_order'] ?? $experience->sort_order,
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil diperbarui.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil dihapus.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        foreach ($ids as $index => $id) {
            Experience::whereKey($id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['ok' => true]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'role_idn' => ['nullable', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'desk' => ['required', 'string'],
            'desk_idn' => ['nullable', 'string'],
            'practicum_desc' => ['nullable', 'string'],
            'practicum_desc_idn' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image:allow_svg', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gambar_url' => ['nullable', 'url'],
            'responsibilities' => ['nullable', 'string'],
            'responsibilities_idn' => ['nullable', 'string'],
            'skills' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'role' => 'Posisi',
            'role_idn' => 'Posisi (Indonesia)',
            'company' => 'Perusahaan',
            'duration' => 'Periode',
            'location' => 'Lokasi',
            'desk' => 'Deskripsi',
            'desk_idn' => 'Deskripsi (Indonesia)',
            'practicum_desc' => 'Deskripsi praktikum',
            'practicum_desc_idn' => 'Deskripsi praktikum (Indonesia)',
            'gambar' => 'Logo / Foto',
            'gambar_url' => 'URL logo / foto',
            'responsibilities' => 'Tanggung jawab utama',
            'responsibilities_idn' => 'Tanggung jawab utama (Indonesia)',
            'skills' => 'Skill',
            'sort_order' => 'Urutan',
        ]);
    }
}
