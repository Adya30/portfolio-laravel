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
        $defaultBlock = [
            [
                'type' => 'paragraf',
                'teks' => '',
                'teks_idn' => '',
                'align' => 'kiri',
            ],
        ];

        return view('admin.experiences.create', [
            'blocksValue' => $defaultBlock,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $konten = $this->parseBlocks($data['konten'] ?? null);
        $kontenIdn = $this->parseBlocks($data['konten_idn'] ?? null);

        $firstParagraph = $this->extractFirstParagraphText($konten, 250);
        $firstParagraphIdn = $this->extractFirstParagraphText($kontenIdn, 250);

        $desk = $data['desk'] ?? null;
        if (empty($desk)) {
            $desk = $firstParagraph ?: ($data['role'] . ' at ' . $data['company']);
        }

        $deskIdn = $data['desk_idn'] ?? null;
        if (empty($deskIdn)) {
            $deskIdn = $firstParagraphIdn ?: $desk;
        }

        Experience::create([
            'role' => $data['role'],
            'role_idn' => $data['role_idn'] ?? null,
            'company' => $data['company'],
            'duration' => $data['duration'] ?? null,
            'location' => $data['location'] ?? null,
            'desk' => $desk,
            'desk_idn' => $deskIdn,
            'practicum_desc' => $data['practicum_desc'] ?? null,
            'practicum_desc_idn' => $data['practicum_desc_idn'] ?? null,
            'gambar' => $this->resolveImage($request, 'experiences'),
            'konten' => $konten,
            'konten_idn' => $kontenIdn,
            'responsibilities' => $this->linesToArray($data['responsibilities'] ?? null),
            'responsibilities_idn' => $this->linesToArray($data['responsibilities_idn'] ?? null),
            'skills' => $this->linesToArray($data['skills'] ?? null),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil ditambahkan.');
    }

    public function edit(Experience $experience): View
    {
        $blocksEn = $this->buildInitialBlocks($experience->konten, $experience->desk, $experience->responsibilities);
        $blocksIdn = $this->buildInitialBlocks($experience->konten_idn, $experience->desk_idn, $experience->responsibilities_idn);
        $blocksValue = $this->mergeExperienceBlocks($blocksEn, $blocksIdn);

        return view('admin.experiences.edit', [
            'experience' => $experience,
            'blocksValue' => $blocksValue,
        ]);
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $data = $this->validateData($request);
        $konten = $this->parseBlocks($data['konten'] ?? null);
        $kontenIdn = $this->parseBlocks($data['konten_idn'] ?? null);

        $firstParagraph = $this->extractFirstParagraphText($konten, 250);
        $firstParagraphIdn = $this->extractFirstParagraphText($kontenIdn, 250);

        $desk = $data['desk'] ?? null;
        if (empty($desk)) {
            $desk = $firstParagraph ?: ($experience->desk ?: ($data['role'] . ' at ' . $data['company']));
        }

        $deskIdn = $data['desk_idn'] ?? null;
        if (empty($deskIdn)) {
            $deskIdn = $firstParagraphIdn ?: $experience->desk_idn;
        }

        $experience->update([
            'role' => $data['role'],
            'role_idn' => $data['role_idn'] ?? null,
            'company' => $data['company'],
            'duration' => $data['duration'] ?? null,
            'location' => $data['location'] ?? null,
            'desk' => $desk,
            'desk_idn' => $deskIdn,
            'practicum_desc' => $data['practicum_desc'] ?? null,
            'practicum_desc_idn' => $data['practicum_desc_idn'] ?? null,
            'gambar' => $this->resolveImage($request, 'experiences', $experience->gambar),
            'konten' => $konten,
            'konten_idn' => $kontenIdn,
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

    public function uploadBlockImage(Request $request): JsonResponse
    {
        $request->validate([
            'gambar' => ['required', 'image:allow_svg', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
        ], $this->validationMessages(), [
            'gambar' => 'Gambar blok',
        ]);

        try {
            $url = $this->uploadImage($request->file('gambar'), 'experiences');
        } catch (\Throwable $e) {
            report($e);

            return response()->json(['error' => 'Upload gambar gagal.'], 422);
        }

        return response()->json(['url' => $url]);
    }

    private function parseBlocks(mixed $konten): array
    {
        if (empty($konten)) {
            return [];
        }
        if (is_string($konten)) {
            $decoded = json_decode($konten, true);

            return is_array($decoded) ? $decoded : [];
        }

        return is_array($konten) ? $konten : [];
    }

    private function extractFirstParagraphText(array $konten, int $limit = 500): ?string
    {
        foreach ($konten as $block) {
            if (($block['type'] ?? '') === 'paragraf' && !empty($block['teks'])) {
                $plain = trim(html_entity_decode(strip_tags($block['teks']), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($plain !== '') {
                    return \Illuminate\Support\Str::limit($plain, $limit);
                }
            }
        }

        return null;
    }

    private function buildInitialBlocks(?array $konten, ?string $fallbackText, ?array $responsibilities = null): array
    {
        if (!empty($konten) && is_array($konten) && count($konten) > 0) {
            return $konten;
        }

        $blocks = [];

        if (!empty($fallbackText) && trim($fallbackText) !== '') {
            $paragraphs = preg_split("/\r\n|\n|\r/", trim($fallbackText));
            $html = collect($paragraphs)
                ->filter(fn($p) => trim($p) !== '')
                ->map(fn($p) => '<p>' . e(trim($p)) . '</p>')
                ->implode('');
            $blocks[] = [
                'type' => 'paragraf',
                'teks' => $html ?: '<p>' . e($fallbackText) . '</p>',
                'align' => 'kiri',
            ];
        }

        if (!empty($responsibilities) && is_array($responsibilities) && count($responsibilities) > 0) {
            $listItems = collect($responsibilities)
                ->filter(fn($r) => trim($r) !== '')
                ->map(fn($r) => '<li>' . e(trim($r)) . '</li>')
                ->implode('');
            if ($listItems) {
                $blocks[] = [
                    'type' => 'paragraf',
                    'teks' => '<p><strong>Key Responsibilities:</strong></p><ul>' . $listItems . '</ul>',
                    'align' => 'kiri',
                ];
            }
        }

        if (empty($blocks)) {
            $blocks = [
                [
                    'type' => 'paragraf',
                    'teks' => '',
                    'align' => 'kiri',
                ],
            ];
        }

        return $blocks;
    }

    private function mergeExperienceBlocks(array $enBlocks, array $idnBlocks): array
    {
        $merged = [];
        $max = max(count($enBlocks), count($idnBlocks));

        for ($i = 0; $i < $max; $i++) {
            $en = $enBlocks[$i] ?? [];
            $idn = $idnBlocks[$i] ?? [];

            $type = $en['type'] ?? $idn['type'] ?? 'paragraf';

            $block = [
                'type' => $type,
            ];

            if ($type === 'paragraf') {
                $block['teks'] = $en['teks'] ?? '';
                $block['teks_idn'] = $idn['teks'] ?? ($idn['teks_idn'] ?? '');
                $block['align'] = $en['align'] ?? $idn['align'] ?? 'kiri';
            } elseif ($type === 'gambar') {
                $block['url'] = $en['url'] ?? $idn['url'] ?? '';
                $block['ukuran'] = $en['ukuran'] ?? $idn['ukuran'] ?? 'penuh';
                $block['caption'] = $en['caption'] ?? '';
                $block['caption_idn'] = $idn['caption'] ?? ($idn['caption_idn'] ?? '');
            } elseif ($type === 'kode') {
                $block['bahasa'] = $en['bahasa'] ?? $idn['bahasa'] ?? 'php';
                $block['kode'] = $en['kode'] ?? $idn['kode'] ?? '';
            } elseif ($type === 'link') {
                $block['href'] = $en['href'] ?? $idn['href'] ?? '';
                $block['label'] = $en['label'] ?? '';
                $block['label_idn'] = $idn['label'] ?? ($idn['label_idn'] ?? '');
                $block['desc'] = $en['desc'] ?? '';
                $block['desc_idn'] = $idn['desc'] ?? ($idn['desc_idn'] ?? '');
            } else {
                $block = array_merge($idn, $en);
            }

            $merged[] = $block;
        }

        if (empty($merged)) {
            $merged[] = [
                'type' => 'paragraf',
                'teks' => '',
                'teks_idn' => '',
                'align' => 'kiri',
            ];
        }

        return $merged;
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'role' => ['required', 'string', 'max:255'],
            'role_idn' => ['nullable', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'desk' => ['nullable', 'string'],
            'desk_idn' => ['nullable', 'string'],
            'practicum_desc' => ['nullable', 'string'],
            'practicum_desc_idn' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image:allow_svg', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
            'gambar_url' => ['nullable', 'url'],
            'konten' => ['nullable'],
            'konten_idn' => ['nullable'],
            'blocks_data' => ['nullable'],
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
            'konten' => 'Konten blok',
            'responsibilities' => 'Tanggung jawab utama',
            'responsibilities_idn' => 'Tanggung jawab utama (Indonesia)',
            'skills' => 'Skill',
            'sort_order' => 'Urutan',
        ]);
    }
}
