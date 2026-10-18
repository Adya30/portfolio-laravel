<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::with('category')->orderBy('sort_order')->get(),
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

        return view('admin.projects.create', [
            'categories' => Category::orderBy('id')->get(),
            'tools' => Tool::orderBy('sort_order')->get(),
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
            $desk = $firstParagraph ?: ($data['nama'] ?? 'Project');
        }

        $deskIdn = $data['desk_idn'] ?? null;
        if (empty($deskIdn) && !empty($firstParagraphIdn)) {
            $deskIdn = $firstParagraphIdn;
        }

        $fullDesk = $data['full_desk'] ?? null;
        if (empty($fullDesk) && !empty($konten)) {
            $fullDesk = $this->extractFirstParagraphText($konten, 2000);
        }

        $fullDeskIdn = $data['full_desk_idn'] ?? null;
        if (empty($fullDeskIdn) && !empty($kontenIdn)) {
            $fullDeskIdn = $this->extractFirstParagraphText($kontenIdn, 2000);
        }

        Project::create([
            'nama' => $data['nama'],
            'desk' => $desk,
            'desk_idn' => $deskIdn,
            'full_desk' => $fullDesk,
            'full_desk_idn' => $fullDeskIdn,
            'link' => $data['link'] ?? null,
            'link_live' => $data['link_live'] ?? null,
            'tools' => $data['tools'] ?? [],
            'fitur' => $this->linesToArray($data['fitur'] ?? null),
            'fitur_idn' => $this->linesToArray($data['fitur_idn'] ?? null),
            'gambar' => $this->resolveImage($request, 'projects'),
            'konten' => $konten,
            'konten_idn' => $kontenIdn,
            'category_id' => $data['category_id'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        $blocksEn = $this->buildInitialBlocks($project->konten, $project->full_desk ?: $project->desk, $project->fitur);
        $blocksIdn = $this->buildInitialBlocks($project->konten_idn, $project->full_desk_idn ?: $project->desk_idn, $project->fitur_idn);
        $blocksValue = $this->mergeProjectBlocks($blocksEn, $blocksIdn);

        return view('admin.projects.edit', [
            'project' => $project->load('category'),
            'categories' => Category::orderBy('id')->get(),
            'tools' => Tool::orderBy('sort_order')->get(),
            'blocksValue' => $blocksValue,
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateData($request);
        $konten = $this->parseBlocks($data['konten'] ?? null);
        $kontenIdn = $this->parseBlocks($data['konten_idn'] ?? null);

        $firstParagraph = $this->extractFirstParagraphText($konten, 250);
        $firstParagraphIdn = $this->extractFirstParagraphText($kontenIdn, 250);

        $desk = $data['desk'] ?? null;
        if (empty($desk)) {
            $desk = $firstParagraph ?: ($project->desk ?: ($data['nama'] ?? 'Project'));
        }

        $deskIdn = $data['desk_idn'] ?? null;
        if (empty($deskIdn)) {
            $deskIdn = $firstParagraphIdn ?: $project->desk_idn;
        }

        $fullDesk = $data['full_desk'] ?? null;
        if (empty($fullDesk) && !empty($konten)) {
            $fullDesk = $this->extractFirstParagraphText($konten, 2000);
        }

        $fullDeskIdn = $data['full_desk_idn'] ?? null;
        if (empty($fullDeskIdn) && !empty($kontenIdn)) {
            $fullDeskIdn = $this->extractFirstParagraphText($kontenIdn, 2000);
        }

        $project->update([
            'nama' => $data['nama'],
            'desk' => $desk,
            'desk_idn' => $deskIdn,
            'full_desk' => $fullDesk ?: $project->full_desk,
            'full_desk_idn' => $fullDeskIdn ?: $project->full_desk_idn,
            'link' => $data['link'] ?? null,
            'link_live' => $data['link_live'] ?? null,
            'tools' => $data['tools'] ?? [],
            'fitur' => $this->linesToArray($data['fitur'] ?? null) ?: $project->fitur,
            'fitur_idn' => $this->linesToArray($data['fitur_idn'] ?? null) ?: $project->fitur_idn,
            'gambar' => $this->resolveImage($request, 'projects', $project->gambar),
            'konten' => $konten,
            'konten_idn' => $kontenIdn,
            'category_id' => $data['category_id'] ?? null,
            'sort_order' => $data['sort_order'] ?? $project->sort_order,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        foreach ($ids as $index => $id) {
            Project::whereKey($id)->update(['sort_order' => $index + 1]);
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
            $url = $this->uploadImage($request->file('gambar'), 'projects');
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

    private function buildInitialBlocks(?array $konten, ?string $fallbackText, ?array $features = null): array
    {
        if (!empty($konten) && is_array($konten)) {
            return $konten;
        }

        $blocks = [];
        if (!empty($fallbackText)) {
            $html = collect(explode("\n\n", str_replace("\r\n", "\n", $fallbackText)))
                ->filter(fn($p) => trim($p) !== '')
                ->map(fn($p) => '<p>' . e(trim($p)) . '</p>')
                ->implode('');
            $blocks[] = [
                'type' => 'paragraf',
                'teks' => $html ?: '<p>' . e($fallbackText) . '</p>',
                'align' => 'kiri',
            ];
        }

        if (!empty($features) && is_array($features) && count($features) > 0) {
            $listItems = collect($features)
                ->filter(fn($f) => trim($f) !== '')
                ->map(fn($f) => '<li>' . e(trim($f)) . '</li>')
                ->implode('');
            if ($listItems) {
                $blocks[] = [
                    'type' => 'paragraf',
                    'teks' => '<p><strong>Key Features:</strong></p><ul>' . $listItems . '</ul>',
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

    private function mergeProjectBlocks(array $enBlocks, array $idnBlocks): array
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
            'nama' => ['required', 'string', 'max:255'],
            'desk' => ['nullable', 'string'],
            'desk_idn' => ['nullable', 'string'],
            'full_desk' => ['nullable', 'string'],
            'full_desk_idn' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'link_live' => ['nullable', 'url'],
            'tools' => ['nullable', 'array'],
            'tools.*' => ['integer', 'exists:tools,id'],
            'fitur' => ['nullable', 'string'],
            'fitur_idn' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image:allow_svg', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
            'gambar_url' => ['nullable', 'url'],
            'konten' => ['nullable'],
            'konten_idn' => ['nullable'],
            'blocks_data' => ['nullable'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], $this->validationMessages(), [
            'nama' => 'Nama project',
            'desk' => 'Deskripsi singkat',
            'desk_idn' => 'Deskripsi singkat (Indonesia)',
            'full_desk' => 'Deskripsi lengkap',
            'full_desk_idn' => 'Deskripsi lengkap (Indonesia)',
            'link' => 'Link GitHub',
            'link_live' => 'Link live',
            'tools' => 'Teknologi',
            'fitur' => 'Fitur utama',
            'fitur_idn' => 'Fitur utama (Indonesia)',
            'gambar' => 'Gambar',
            'gambar_url' => 'URL gambar',
            'konten' => 'Konten blok (English)',
            'konten_idn' => 'Konten blok (Indonesia)',
            'category_id' => 'Kategori',
            'sort_order' => 'Urutan',
        ]);
    }

    private function extractFirstParagraphText(array $konten, int $limit = 500): ?string
    {
        foreach ($konten as $block) {
            if (($block['type'] ?? '') === 'paragraf' && !empty($block['teks'])) {
                $plain = trim(html_entity_decode(strip_tags($block['teks']), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($plain !== '') {
                    return Str::limit($plain, $limit);
                }
            }
        }

        return null;
    }
}
