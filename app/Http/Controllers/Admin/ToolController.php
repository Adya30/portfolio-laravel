<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ToolController extends Controller
{
    public function index(): View
    {
        return view('admin.tools.index', [
            'tools' => Tool::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.tools.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Tool::create([
            'nama' => $data['nama'],
            'ket' => $data['ket'] ?? null,
            'gambar' => $this->resolveImage($request, 'tools'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.tools.index')->with('success', 'Tool berhasil ditambahkan.');
    }

    public function edit(Tool $tool): View
    {
        return view('admin.tools.edit', compact('tool'));
    }

    public function update(Request $request, Tool $tool): RedirectResponse
    {
        $data = $this->validateData($request);

        $tool->update([
            'nama' => $data['nama'],
            'ket' => $data['ket'] ?? null,
            'gambar' => $this->resolveImage($request, 'tools', $tool->gambar),
            'sort_order' => $data['sort_order'] ?? $tool->sort_order,
        ]);

        return redirect()->route('admin.tools.index')->with('success', 'Tool berhasil diperbarui.');
    }

    public function destroy(Tool $tool): RedirectResponse
    {
        $tool->delete();

        return redirect()->route('admin.tools.index')->with('success', 'Tool berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'ket' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image:allow_svg', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gambar_url' => ['nullable', 'url'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'nama' => 'Nama tool',
            'ket' => 'Kategori',
            'gambar' => 'Ikon tool',
            'gambar_url' => 'URL gambar',
            'sort_order' => 'Urutan',
        ]);
    }
}
