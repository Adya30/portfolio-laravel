<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
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
            'company' => $data['company'],
            'duration' => $data['duration'] ?? null,
            'location' => $data['location'] ?? null,
            'desk' => $data['desk'],
            'practicum_desc' => $data['practicum_desc'] ?? null,
            'responsibilities' => $this->linesToArray($data['responsibilities'] ?? null),
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
            'company' => $data['company'],
            'duration' => $data['duration'] ?? null,
            'location' => $data['location'] ?? null,
            'desk' => $data['desk'],
            'practicum_desc' => $data['practicum_desc'] ?? null,
            'responsibilities' => $this->linesToArray($data['responsibilities'] ?? null),
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

    private function validateData(Request $request): array
    {
        return $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'desk' => ['required', 'string'],
            'practicum_desc' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'skills' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'role' => 'Posisi',
            'company' => 'Perusahaan',
            'duration' => 'Periode',
            'location' => 'Lokasi',
            'desk' => 'Deskripsi',
            'practicum_desc' => 'Deskripsi praktikum',
            'responsibilities' => 'Tanggung jawab utama',
            'skills' => 'Skill',
            'sort_order' => 'Urutan',
        ]);
    }
}
