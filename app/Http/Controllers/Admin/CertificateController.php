<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
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
            'penerbit' => $data['penerbit'] ?? null,
            'tanggal' => $data['tanggal'] ?? null,
            'desk' => $data['desk'] ?? null,
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
            'penerbit' => $data['penerbit'] ?? null,
            'tanggal' => $data['tanggal'] ?? null,
            'desk' => $data['desk'] ?? null,
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

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['nullable', 'string', 'max:255'],
            'desk' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gambar_url' => ['nullable', 'url'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'nama' => 'Nama sertifikat',
            'penerbit' => 'Penerbit',
            'tanggal' => 'Tanggal',
            'desk' => 'Deskripsi',
            'icon' => 'Ikon',
            'gambar' => 'Gambar sertifikat',
            'gambar_url' => 'URL gambar',
            'sort_order' => 'Urutan',
        ]);
    }
}
