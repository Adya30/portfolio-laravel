<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('admin.courses.index', [
            'courses' => Course::orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Subbab list for one materi. Derives the subbabs from the konten blocks
     * (type 'subbab') and remembers each subbab's block index so the editor
     * can scroll straight to it (admin.courses.edit#blok-{index}).
     */
    public function show(Course $course): View
    {
        $subbabs = [];
        $current = null;

        foreach ($course->konten ?? [] as $i => $block) {
            $type = $block['type'] ?? 'paragraf';

            if ($type === 'subbab') {
                $current = [
                    'block_index' => $i,
                    'judul' => $block['judul'] ?? '',
                    'judul_idn' => $block['judul_idn'] ?? null,
                    'stats' => ['paragraf' => 0, 'gambar' => 0, 'kode' => 0],
                ];
                $subbabs[] = $current;
            } elseif ($current !== null && array_key_exists($type, $subbabs[count($subbabs) - 1]['stats'])) {
                $subbabs[count($subbabs) - 1]['stats'][$type]++;
            }
        }

        return view('admin.courses.show', [
            'course' => $course,
            'subbabs' => $subbabs,
            'totalBlocks' => count($course->konten ?? []),
        ]);
    }

    public function create(): View
    {
        return view('admin.courses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Course::create([
            'nama' => $data['nama'],
            'nama_idn' => $data['nama_idn'] ?? null,
            'desk' => $data['desk'] ?? null,
            'desk_idn' => $data['desk_idn'] ?? null,
            'konten' => $this->decodeBlocks($request),
            'gambar' => $this->resolveImage($request, 'courses'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $data = $this->validateData($request);

        $course->update([
            'nama' => $data['nama'],
            'nama_idn' => $data['nama_idn'] ?? null,
            'desk' => $data['desk'] ?? null,
            'desk_idn' => $data['desk_idn'] ?? null,
            'konten' => $this->decodeBlocks($request),
            'gambar' => $this->resolveImage($request, 'courses', $course->gambar),
            'sort_order' => $data['sort_order'] ?? $course->sort_order,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Materi berhasil dihapus.');
    }

    /**
     * AJAX image upload for the block editor (subbab content). Returns the
     * public URL so the editor can store it inside the konten JSON. The file
     * is converted to webp server-side when possible.
     */
    public function uploadBlockImage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'gambar' => ['required', 'image:allow_svg', 'mimes:webp,svg', 'max:15360'],
        ], $this->validationMessages(), [
            'gambar' => 'Gambar blok',
        ]);

        try {
            $url = $this->uploadImage($request->file('gambar'), 'courses');
        } catch (\Throwable $e) {
            report($e);

            return response()->json(['error' => 'Upload gambar gagal.'], 422);
        }

        return response()->json(['url' => $url]);
    }

    public function reorder(Request $request): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        foreach ($ids as $index => $id) {
            Course::whereKey($id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['ok' => true]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nama_idn' => ['nullable', 'string', 'max:255'],
            'desk' => ['nullable', 'string'],
            'desk_idn' => ['nullable', 'string'],
            'konten' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image:allow_svg', 'mimes:webp,svg', 'max:15360'],
            'gambar_url' => ['nullable', 'url'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'nama' => 'Nama materi',
            'nama_idn' => 'Nama materi (Indonesia)',
            'desk' => 'Deskripsi singkat',
            'desk_idn' => 'Deskripsi singkat (Indonesia)',
            'konten' => 'Isi materi',
            'gambar' => 'Gambar',
            'gambar_url' => 'URL gambar',
            'sort_order' => 'Urutan',
        ]);
    }

    /**
     * Decode the block editor JSON (submitted as a string in the hidden
     * `konten` input) into an array of content blocks, or null when empty.
     */
    private function decodeBlocks(Request $request): ?array
    {
        if (! $request->filled('konten')) {
            return null;
        }

        $decoded = json_decode($request->input('konten'), true);

        if (! is_array($decoded) || $decoded === []) {
            return null;
        }

        $allowed = ['subbab', 'paragraf', 'gambar', 'kode'];

        return collect($decoded)
            ->filter(fn ($block) => is_array($block) && isset($block['type']) && in_array($block['type'], $allowed, true))
            ->values()
            ->all();
    }
}
