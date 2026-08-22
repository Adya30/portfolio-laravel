<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('admin.courses.index', [
            'courses' => Course::orderBy('sort_order')->get(),
        ]);
    }

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

        // Optimistic locking: cek updated_at sebelum update
        $oldUpdatedAt = $request->input('updated_at');
        if ($oldUpdatedAt) {
            $updated = Course::where('id', $course->id)
                ->where('updated_at', $oldUpdatedAt)
                ->update([
                    'nama' => $data['nama'],
                    'nama_idn' => $data['nama_idn'] ?? null,
                    'desk' => $data['desk'] ?? null,
                    'desk_idn' => $data['desk_idn'] ?? null,
                    'konten' => $request->has('konten') ? $this->decodeBlocks($request) : $course->konten,
                    'gambar' => $this->resolveImage($request, 'courses', $course->gambar),
                    'sort_order' => $data['sort_order'] ?? $course->sort_order,
                ]);

            if ($updated === 0) {
                return redirect()->route('admin.courses.edit', $course)
                    ->with('error', 'Konflik penyimpanan terdeteksi! Materi ini sedang diubah oleh pengguna lain. Silakan muat ulang halaman dan coba lagi.');
            }
        } else {
            $course->update([
                'nama' => $data['nama'],
                'nama_idn' => $data['nama_idn'] ?? null,
                'desk' => $data['desk'] ?? null,
                'desk_idn' => $data['desk_idn'] ?? null,
                'konten' => $request->has('konten') ? $this->decodeBlocks($request) : $course->konten,
                'gambar' => $this->resolveImage($request, 'courses', $course->gambar),
                'sort_order' => $data['sort_order'] ?? $course->sort_order,
            ]);
        }

        return redirect()->route('admin.courses.show', $course)->with('success', 'Materi berhasil diperbarui.');
    }

    public function editSubbab(Course $course, int $blockIndex): View
    {
        $allBlocks = $course->konten ?? [];

        if (! isset($allBlocks[$blockIndex]) || ($allBlocks[$blockIndex]['type'] ?? '') !== 'subbab') {
            abort(404);
        }

        $subbabIndices = [];
        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        $pos = array_search($blockIndex, $subbabIndices, true);

        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($allBlocks);
        $subbabBlocks = array_slice($allBlocks, $blockIndex, $end - $blockIndex);

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
            'originalSubbabTitle' => $allBlocks[$blockIndex]['judul'] ?? '',
            'originalSubbabPosition' => $pos,
        ]);
    }

    /**
     * Update subbab dengan concurrent editing support.
     * Re-reads the latest konten from DB, finds the subbab by original title+position,
     * merges new blocks, and saves with optimistic locking.
     */
    public function updateSubbab(Request $request, Course $course, int $blockIndex): RedirectResponse
    {
        $newBlocks = $this->decodeBlocks($request) ?? [];

        if (empty($newBlocks) || ($newBlocks[0]['type'] ?? '') !== 'subbab') {
            $existingSubbabHeader = ($course->konten ?? [])[$blockIndex] ?? null;
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
            } elseif ($existingSubbabHeader) {
                array_unshift($newBlocks, $existingSubbabHeader);
            }
        }

        // Ambil info subbab asli dari form untuk identifikasi
        $originalTitle = $request->input('original_subbab_title', '');
        $originalPosition = (int) $request->input('original_subbab_position', 0);

        // Re-read latest konten dari DB (bisa sudah diubah user lain)
        $course->refresh();
        $allBlocks = $course->konten ?? [];

        // Cari subbab berdasarkan posisi + judul asli
        $targetIndex = $this->findSubbabByOriginalInfo($allBlocks, $originalTitle, $originalPosition);

        // Fallback: coba cari berdasarkan blockIndex lama jika masih valid
        if ($targetIndex === null) {
            if (isset($allBlocks[$blockIndex]) && ($allBlocks[$blockIndex]['type'] ?? '') === 'subbab') {
                $targetIndex = $blockIndex;
            }
        }

        if ($targetIndex === null) {
            return redirect()->route('admin.courses.show', $course)
                ->with('error', 'Subbab yang diedit tidak ditemukan. Kemungkinan telah dihapus oleh pengguna lain. Silakan muat ulang halaman.');
        }

        // Cari posisi subbab di array terbaru
        $subbabIndices = [];
        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        $pos = array_search($targetIndex, $subbabIndices, true);
        if ($pos === false) {
            return redirect()->route('admin.courses.show', $course)
                ->with('error', 'Terjadi kesalahan saat menyimpan. Silakan coba lagi.');
        }

        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($allBlocks);

        // Pastikan judul subbab tidak kosong
        if (empty($newBlocks[0]['judul'])) {
            $newBlocks[0]['judul'] = $allBlocks[$targetIndex]['judul'] ?: ('Subbab '.($pos + 1));
        }

        $before = array_slice($allBlocks, 0, $targetIndex);
        $after = array_slice($allBlocks, $end);
        $merged = array_merge($before, $newBlocks, $after);

        // Optimistic locking: pastikan konten tidak berubah saat save
        $oldUpdatedAt = $request->input('updated_at');
        if ($oldUpdatedAt) {
            $updated = Course::where('id', $course->id)
                ->where('updated_at', $oldUpdatedAt)
                ->update(['konten' => $merged]);

            if ($updated === 0) {
                // Retry sekali dengan data terbaru
                $course->refresh();
                return $this->retryUpdateSubbab($course, $newBlocks, $originalTitle, $originalPosition);
            }
        } else {
            $course->update(['konten' => $merged]);
        }

        $newSubbabIndices = [];
        foreach ($merged as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $newSubbabIndices[] = $i;
            }
        }
        $newBlockIndex = $newSubbabIndices[$pos] ?? $targetIndex;

        $subbabTitle = $merged[$newBlockIndex]['judul'] ?? 'Subbab';

        return redirect()->route('admin.courses.subbab.edit', [$course, $newBlockIndex])
            ->with('success', 'Subbab "'.$subbabTitle.'" berhasil diperbarui.');
    }

    /**
     * Retry update subbab dengan data terbaru dari DB.
     */
    private function retryUpdateSubbab(Course $course, array $newBlocks, string $originalTitle, int $originalPosition): RedirectResponse
    {
        $allBlocks = $course->konten ?? [];

        $targetIndex = $this->findSubbabByOriginalInfo($allBlocks, $originalTitle, $originalPosition);

        if ($targetIndex === null) {
            return redirect()->route('admin.courses.show', $course)
                ->with('error', 'Subbab tidak ditemukan setelah retry. Silakan muat ulang halaman.');
        }

        $subbabIndices = [];
        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        $pos = array_search($targetIndex, $subbabIndices, true);
        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($allBlocks);

        if (empty($newBlocks[0]['judul'])) {
            $newBlocks[0]['judul'] = $allBlocks[$targetIndex]['judul'] ?: ('Subbab '.($pos + 1));
        }

        $before = array_slice($allBlocks, 0, $targetIndex);
        $after = array_slice($allBlocks, $end);
        $merged = array_merge($before, $newBlocks, $after);

        $course->update(['konten' => $merged]);

        $newSubbabIndices = [];
        foreach ($merged as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $newSubbabIndices[] = $i;
            }
        }
        $newBlockIndex = $newSubbabIndices[$pos] ?? $targetIndex;

        $subbabTitle = $merged[$newBlockIndex]['judul'] ?? 'Subbab';

        return redirect()->route('admin.courses.subbab.edit', [$course, $newBlockIndex])
            ->with('success', 'Subbab "'.$subbabTitle.'" berhasil diperbarui.');
    }

    /**
     * Cari index subbab berdasarkan judul asli dan posisi di antara subbab lainnya.
     * Cocokkan dengan urutan subbab (position) sebagai prioritas utama,
     * lalu verifikasi judul sebagai secondary check.
     */
    private function findSubbabByOriginalInfo(array $allBlocks, string $originalTitle, int $originalPosition): ?int
    {
        $subbabCount = 0;
        $candidateByPosition = null;
        $candidateByTitle = null;

        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                if ($subbabCount === $originalPosition) {
                    $candidateByPosition = $i;
                }

                if (Str::slug($block['judul'] ?? '') === Str::slug($originalTitle)) {
                    $candidateByTitle = $i;
                }

                $subbabCount++;
            }
        }

        // Prioritas: posisi + judul cocok
        if ($candidateByPosition !== null) {
            $posTitle = $allBlocks[$candidateByPosition]['judul'] ?? '';
            if (Str::slug($posTitle) === Str::slug($originalTitle)) {
                return $candidateByPosition;
            }
        }

        // Fallback: hanya judul cocok
        if ($candidateByTitle !== null) {
            return $candidateByTitle;
        }

        // Fallback: hanya posisi cocok (judul mungkin diubah user lain)
        if ($candidateByPosition !== null && $originalPosition < $subbabCount) {
            return $candidateByPosition;
        }

        return null;
    }

    public function storeSubbab(Course $course): RedirectResponse
    {
        // Re-read dari DB untuk menghindari conflict
        $course->refresh();
        $blocks = $course->konten ?? [];

        $blocks[] = ['type' => 'subbab', 'judul' => '', 'judul_idn' => null];
        $newIndex = count($blocks) - 1;

        $course->update(['konten' => $blocks]);

        return redirect()->route('admin.courses.subbab.edit', [$course, $newIndex])
            ->with('success', 'Subbab baru berhasil ditambahkan. Silakan isi judul dan kontennya.');
    }

    public function destroySubbab(Course $course, int $blockIndex): RedirectResponse
    {
        // Re-read dari DB untuk menghindari conflict
        $course->refresh();
        $allBlocks = $course->konten ?? [];

        if (! isset($allBlocks[$blockIndex]) || ($allBlocks[$blockIndex]['type'] ?? '') !== 'subbab') {
            abort(404);
        }

        $subbabIndices = [];
        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        $pos = array_search($blockIndex, $subbabIndices, true);
        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($allBlocks);

        $before = array_slice($allBlocks, 0, $blockIndex);
        $after = array_slice($allBlocks, $end);
        $merged = array_merge($before, $after);

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

    public function uploadBlockImage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'gambar' => ['required', 'image:allow_svg', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
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

    public function reorderSubbab(Request $request, Course $course): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        // Re-read dari DB untuk data terbaru
        $course->refresh();
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
            'gambar' => ['nullable', 'image:allow_svg', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
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
