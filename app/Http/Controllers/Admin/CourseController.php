<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
    private const DEFAULT_SUBBAB_PREFIX = 'Subbab ';

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

        $course = Course::create([
            'nama' => $data['nama'],
            'nama_idn' => $data['nama_idn'] ?? null,
            'desk' => $data['desk'] ?? null,
            'desk_idn' => $data['desk_idn'] ?? null,
            'konten' => $this->decodeBlocks($request) ?? [],
            'gambar' => $this->resolveImage($request, 'courses'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.courses.show', $course)->with('success', 'Materi berhasil ditambahkan. Silakan tambahkan subbab.');
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $data = $this->validateData($request);
        $oldUpdatedAt = $this->parseUpdatedAt($request->input('updated_at'));

        if (! $oldUpdatedAt) {
            $course->update($this->mapCourseData($data, $request, $course));
            return redirect()->route('admin.courses.show', $course)->with('success', 'Materi berhasil diperbarui.');
        }

        $updated = Course::where('id', $course->id)
            ->where('updated_at', $oldUpdatedAt)
            ->update($this->mapCourseData($data, $request, $course));

        if ($updated === 0) {
            return redirect()->route('admin.courses.edit', $course)
                ->with('error', 'Konflik penyimpanan terdeteksi! Materi ini sedang diubah oleh pengguna lain. Silakan muat ulang halaman dan coba lagi.');
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
            'subbabTitle' => $allBlocks[$blockIndex]['judul'] ?? self::DEFAULT_SUBBAB_PREFIX . ($pos + 1),
            'originalSubbabTitle' => $allBlocks[$blockIndex]['judul'] ?? '',
            'originalSubbabPosition' => $pos,
        ]);
    }

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

        $originalTitle = (string) ($request->input('original_subbab_title') ?? '');
        $originalPosition = (int) $request->input('original_subbab_position', 0);

        $course->refresh();
        $allBlocks = $course->konten ?? [];

        $targetIndex = $this->resolveTargetIndex($allBlocks, $originalTitle, $originalPosition, $blockIndex);

        if ($targetIndex === null) {
            return redirect()->route('admin.courses.show', $course)
                ->with('error', 'Subbab yang diedit tidak ditemukan. Kemungkinan telah dihapus oleh pengguna lain. Silakan muat ulang halaman.');
        }

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

        if (empty($newBlocks[0]['judul'])) {
            $newBlocks[0]['judul'] = $allBlocks[$targetIndex]['judul'] ?: (self::DEFAULT_SUBBAB_PREFIX . ($pos + 1));
        }

        $before = array_slice($allBlocks, 0, $targetIndex);
        $after = array_slice($allBlocks, $end);
        $merged = array_merge($before, $newBlocks, $after);

        $oldUpdatedAt = $this->parseUpdatedAt($request->input('updated_at'));
        if ($oldUpdatedAt) {
            $updated = Course::where('id', $course->id)
                ->where('updated_at', $oldUpdatedAt)
                ->update(['konten' => $merged]);

            if ($updated === 0) {
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
            ->with('success', 'Subbab "' . $subbabTitle . '" berhasil diperbarui.');
    }

    private function retryUpdateSubbab(Course $course, array $newBlocks, ?string $originalTitle, int $originalPosition): RedirectResponse
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
            $newBlocks[0]['judul'] = $allBlocks[$targetIndex]['judul'] ?: (self::DEFAULT_SUBBAB_PREFIX . ($pos + 1));
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
            ->with('success', 'Subbab "' . $subbabTitle . '" berhasil diperbarui.');
    }

    private function resolveTargetIndex(array $allBlocks, string $originalTitle, int $originalPosition, int $blockIndex): ?int
    {
        $targetIndex = $this->findSubbabByOriginalInfo($allBlocks, $originalTitle, $originalPosition);

        if ($targetIndex === null && isset($allBlocks[$blockIndex]) && ($allBlocks[$blockIndex]['type'] ?? '') === 'subbab') {
            return $blockIndex;
        }

        return $targetIndex;
    }

    private function findSubbabByOriginalInfo(array $allBlocks, ?string $originalTitle, int $originalPosition): ?int
    {
        $originalTitle = (string) ($originalTitle ?? '');
        $subbabCount = 0;
        $candidateByPosition = null;
        $candidateByTitle = null;

        foreach ($allBlocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                if ($subbabCount === $originalPosition) {
                    $candidateByPosition = $i;
                }

                if ($originalTitle !== '' && Str::slug($block['judul'] ?? '') === Str::slug($originalTitle)) {
                    $candidateByTitle = $i;
                }

                $subbabCount++;
            }
        }

        if ($candidateByPosition !== null) {
            $posTitle = $allBlocks[$candidateByPosition]['judul'] ?? '';
            if ($originalTitle === '' || Str::slug($posTitle) === Str::slug($originalTitle)) {
                return $candidateByPosition;
            }
        }

        if ($candidateByTitle !== null) {
            return $candidateByTitle;
        }

        if ($candidateByPosition !== null && $originalPosition < $subbabCount) {
            return $candidateByPosition;
        }

        return null;
    }

    public function storeSubbab(Course $course): RedirectResponse
    {
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
            ->with('success', 'Subbab "' . $subbabTitle . '" berhasil dihapus.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Materi berhasil dihapus.');
    }

    public function uploadBlockImage(Request $request): JsonResponse
    {
        $request->validate([
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
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ]);

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
        foreach ($request->input('ids') as $id) {
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
            'konten' => ['nullable', 'string', 'max:1048576'],
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

    /**
     * Parse nilai updated_at dari form (bisa berupa Unix timestamp integer
     * atau string datetime) menjadi Carbon instance yang kompatibel dengan MySQL.
     */
    private function parseUpdatedAt(mixed $value): ?Carbon
    {
        if (! $value) {
            return null;
        }

        if (is_numeric($value)) {
            return Carbon::createFromTimestamp((int) $value);
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }

    private function mapCourseData(array $data, Request $request, Course $course): array
    {
        return [
            'nama' => $data['nama'],
            'nama_idn' => $data['nama_idn'] ?? null,
            'desk' => $data['desk'] ?? null,
            'desk_idn' => $data['desk_idn'] ?? null,
            'konten' => $request->has('konten') ? $this->decodeBlocks($request) : $course->konten,
            'gambar' => $this->resolveImage($request, 'courses', $course->gambar),
            'sort_order' => $data['sort_order'] ?? $course->sort_order,
        ];
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
            ->filter(fn($block) => is_array($block) && isset($block['type']) && in_array($block['type'], $allowed, true))
            ->map(function ($block) {
                if (($block['type'] ?? '') === 'link' && !empty($block['href'])) {
                    $block['href'] = filter_var($block['href'], FILTER_VALIDATE_URL)
                        && preg_match('#^https?://#i', $block['href'])
                        ? $block['href'] : '#';
                }
                return $block;
            })
            ->take(500)
            ->values()
            ->all();
    }
}
