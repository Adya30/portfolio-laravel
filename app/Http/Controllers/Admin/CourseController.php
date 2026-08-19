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
                    'stats' => ['paragraf' => 0, 'gambar' => 0, 'kode' => 0, 'subheading' => 0, 'tabel' => 0, 'link' => 0],
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
            'konten' => $request->has('konten') ? $this->decodeBlocks($request) : $course->konten,
            'gambar' => $this->resolveImage($request, 'courses', $course->gambar),
            'sort_order' => $data['sort_order'] ?? $course->sort_order,
        ]);

        return redirect()->route('admin.courses.show', $course)->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Edit a single subbab's blocks. Extracts the blocks belonging to this
     * subbab (from this subbab to the next one) and presents them in a
     * focused block editor.
     */
    public function editSubbab(Course $course, int $blockIndex): View
    {
        $allBlocks = $course->konten ?? [];

        if (! isset($allBlocks[$blockIndex]) || ($allBlocks[$blockIndex]['type'] ?? '') !== 'subbab') {
            abort(404);
        }

        // Find all subbab indices
        $subbabIndices = [];
        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        // Find this subbab's position in the subbab list
        $pos = array_search($blockIndex, $subbabIndices, true);

        // Extract blocks for this subbab (from this index to the next subbab or end)
        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($allBlocks);
        $subbabBlocks = array_slice($allBlocks, $blockIndex, $end - $blockIndex);

        // Build subbab navigation list
        $subbabs = [];
        foreach ($subbabIndices as $si) {
            $subbabs[] = [
                'block_index' => $si,
                'judul' => $allBlocks[$si]['judul'] ?? '',
            ];
        }

        return view('admin.courses.edit-subbab', [
            'course' => $course,
            'subbabBlocks' => $subbabBlocks,
            'blockIndex' => $blockIndex,
            'subbabs' => $subbabs,
            'currentPos' => $pos,
            'prevSubbab' => $pos > 0 ? $subbabs[$pos - 1] : null,
            'nextSubbab' => $pos < count($subbabs) - 1 ? $subbabs[$pos + 1] : null,
            'subbabTitle' => $allBlocks[$blockIndex]['judul'] ?? 'Subbab '.($pos + 1),
        ]);
    }

    /**
     * Update a single subbab's blocks. Splices the new blocks back into the
     * full konten array at the correct position.
     */
    public function updateSubbab(Request $request, Course $course, int $blockIndex): RedirectResponse
    {
        $allBlocks = $course->konten ?? [];

        if (! isset($allBlocks[$blockIndex]) || ($allBlocks[$blockIndex]['type'] ?? '') !== 'subbab') {
            abort(404);
        }

        // Find all subbab indices
        $subbabIndices = [];
        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        $pos = array_search($blockIndex, $subbabIndices, true);
        if ($pos === false) {
            abort(404);
        }

        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($allBlocks);

        // Decode new blocks from editor
        $newBlocks = $this->decodeBlocks($request) ?? [];

        // Ensure the first block of the subbab is ALWAYS of type 'subbab'
        if (empty($newBlocks) || ($newBlocks[0]['type'] ?? '') !== 'subbab') {
            $existingSubbabHeader = $allBlocks[$blockIndex];
            $subbabKey = null;
            foreach ($newBlocks as $k => $b) {
                if (($b['type'] ?? '') === 'subbab') {
                    $subbabKey = $k;
                    break;
                }
            }
            if ($subbabKey !== null) {
                $subbabHeader = array_splice($newBlocks, $subbabKey, 1)[0];
                array_unshift($newBlocks, $subbabHeader);
            } else {
                array_unshift($newBlocks, $existingSubbabHeader);
            }
        }

        // Ensure subbab title is preserved
        if (empty($newBlocks[0]['judul'])) {
            $newBlocks[0]['judul'] = $allBlocks[$blockIndex]['judul'] ?: ('Subbab '.($pos + 1));
        }

        // Splice: replace blocks [$blockIndex .. $end) with new blocks
        $before = array_slice($allBlocks, 0, $blockIndex);
        $after = array_slice($allBlocks, $end);
        $merged = array_merge($before, $newBlocks, $after);

        $course->update(['konten' => $merged]);

        // Find the new block index of this subbab after merge
        $newSubbabIndices = [];
        foreach ($merged as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $newSubbabIndices[] = $i;
            }
        }
        $newBlockIndex = $newSubbabIndices[$pos] ?? $blockIndex;

        $subbabTitle = $merged[$newBlockIndex]['judul'] ?? 'Subbab';

        return redirect()->route('admin.courses.subbab.edit', [$course, $newBlockIndex])
            ->with('success', 'Subbab "'.$subbabTitle.'" berhasil diperbarui.');
    }

    /**
     * Add a new empty subbab block at the end of the course content
     * and redirect to its editor.
     */
    public function storeSubbab(Course $course): RedirectResponse
    {
        $blocks = $course->konten ?? [];

        // Append a new empty subbab block
        $blocks[] = ['type' => 'subbab', 'judul' => '', 'judul_idn' => null];
        $newIndex = count($blocks) - 1;

        $course->update(['konten' => $blocks]);

        return redirect()->route('admin.courses.subbab.edit', [$course, $newIndex])
            ->with('success', 'Subbab baru berhasil ditambahkan. Silakan isi judul dan kontennya.');
    }

    /**
     * Delete a single subbab and all its child blocks from the course content.
     */
    public function destroySubbab(Course $course, int $blockIndex): RedirectResponse
    {
        $allBlocks = $course->konten ?? [];

        if (! isset($allBlocks[$blockIndex]) || ($allBlocks[$blockIndex]['type'] ?? '') !== 'subbab') {
            abort(404);
        }

        // Find all subbab indices
        $subbabIndices = [];
        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        $pos = array_search($blockIndex, $subbabIndices, true);
        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($allBlocks);

        // Remove blocks from $blockIndex to $end (exclusive)
        $before = array_slice($allBlocks, 0, $blockIndex);
        $after = array_slice($allBlocks, $end);
        $merged = array_merge($before, $after);

        // If all blocks removed, set to null
        $course->update(['konten' => $merged === [] ? null : $merged]);

        $subbabTitle = $allBlocks[$blockIndex]['judul'] ?? 'Subbab';

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Subbab "'.$subbabTitle.'" berhasil dihapus.');
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

    /**
     * Reorder subbabs inside a course's content array.
     */
    public function reorderSubbab(Request $request, Course $course): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        $allBlocks = $course->konten ?? [];

        $subbabIndices = [];
        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        if (empty($subbabIndices)) {
            return response()->json(['ok' => true]);
        }

        $firstSubbabIndex = $subbabIndices[0];
        $prefixBlocks = array_slice($allBlocks, 0, $firstSubbabIndex);

        $chunks = [];
        foreach ($subbabIndices as $pos => $blockIndex) {
            $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($allBlocks);
            $chunks[$blockIndex] = array_slice($allBlocks, $blockIndex, $end - $blockIndex);
        }

        $newBlocks = $prefixBlocks;
        foreach ($ids as $id) {
            if (isset($chunks[$id])) {
                foreach ($chunks[$id] as $b) {
                    $newBlocks[] = $b;
                }
                unset($chunks[$id]);
            }
        }

        foreach ($chunks as $remainingChunk) {
            foreach ($remainingChunk as $b) {
                $newBlocks[] = $b;
            }
        }

        $course->update(['konten' => $newBlocks]);

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

        $allowed = ['subbab', 'subheading', 'paragraf', 'gambar', 'kode', 'link', 'pembatas', 'tabel'];

        return collect($decoded)
            ->filter(fn ($block) => is_array($block) && isset($block['type']) && in_array($block['type'], $allowed, true))
            ->values()
            ->all();
    }
}
