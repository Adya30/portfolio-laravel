<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function index(): View
    {
        return view('admin.certificates.index', [
            'certificates' => Certificate::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Certificate::create([
            'nama' => $data['nama'],
            'nama_idn' => $data['nama_idn'] ?? null,
            'penerbit' => $data['penerbit'] ?? null,
            'tanggal' => $data['tanggal'] ?? null,
            'desk' => $data['desk'] ?? null,
            'desk_idn' => $data['desk_idn'] ?? null,
            'icon' => $data['icon'] ?? null,
            'gambar' => $this->resolveImage($request, 'certificates'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate): RedirectResponse
    {
        $data = $this->validateData($request);

        $certificate->update([
            'nama' => $data['nama'],
            'nama_idn' => $data['nama_idn'] ?? null,
            'penerbit' => $data['penerbit'] ?? null,
            'tanggal' => $data['tanggal'] ?? null,
            'desk' => $data['desk'] ?? null,
            'desk_idn' => $data['desk_idn'] ?? null,
            'icon' => $data['icon'] ?? null,
            'gambar' => $this->resolveImage($request, 'certificates', $certificate->gambar),
            'sort_order' => $data['sort_order'] ?? $certificate->sort_order,
        ]);

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        foreach ($ids as $index => $id) {
            Certificate::whereKey($id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['ok' => true]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nama_idn' => ['nullable', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['nullable', 'string', 'max:255'],
            'desk' => ['nullable', 'string'],
            'desk_idn' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image:allow_svg', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gambar_url' => ['nullable', 'url'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'nama' => 'Nama sertifikat',
            'nama_idn' => 'Nama sertifikat (Indonesia)',
            'penerbit' => 'Penerbit',
            'tanggal' => 'Tanggal',
            'desk' => 'Deskripsi',
            'desk_idn' => 'Deskripsi (Indonesia)',
            'icon' => 'Ikon',
            'gambar' => 'Gambar sertifikat',
            'gambar_url' => 'URL gambar',
            'sort_order' => 'Urutan',
        ]);
    }
}
