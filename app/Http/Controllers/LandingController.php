<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $profile = profile();
        $categories = Category::orderBy('id')->get();
        $projects = Project::with('category')->orderBy('sort_order')->get();
        $tools = Tool::orderBy('sort_order')->get();
        $experiences = Experience::orderBy('sort_order')->get();
        $certificates = Certificate::orderBy('sort_order')->get();

        $name = $profile->name ?? 'Adya Handika Putra AP';
        $roleTitle = $profile->role_title ?? 'Web Developer | UI Design';
        $socials = array_filter([
            $profile->github ?? null,
            $profile->instagram ?? null,
            $profile->youtube ?? null,
            $profile->linkedin ?? null,
        ]);

        $githubUsername = 'Adya30';
        if (! empty($profile->github)) {
            $parsedPath = parse_url($profile->github, PHP_URL_PATH);
            $trimmed = trim((string) $parsedPath, '/');
            if (! empty($trimmed)) {
                $githubUsername = $trimmed;
            }
        }

        $githubData = Cache::remember("github_contributions_{$githubUsername}_last", 7200, function () use ($githubUsername) {
            try {
                $response = Http::timeout(5)->get("https://github-contributions-api.jogruber.de/v4/{$githubUsername}?y=last");
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                // fallback
            }

            return null;
        });

        return view('landing.landing', [
            'profile' => $profile,
            'categories' => $categories,
            'projects' => $projects,
            'tools' => $tools,
            'experiences' => $experiences,
            'certificates' => $certificates,
            'githubData' => $githubData,
            'githubUsername' => $githubUsername,
            'seo' => [
                'title' => $name.' | Web Developer & UI Designer Portfolio',
                'description' => $profile->tagline
                    ?? 'Design UI for website, building modular web applications with a focus on architecture and precise digital experiences.',
                'image' => $this->resolveImageUrl($profile?->hero_image),
                'url' => route('landing'),
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WebSite',
                            '@id' => route('landing').'#website',
                            'name' => $name,
                            'alternateName' => ['Portfolio Adya', 'Adya Komputer', 'Adya Portfolio'],
                            'url' => route('landing'),
                            'description' => $profile->tagline ?? 'Portfolio of Adya Handika Putra AP — Full Stack Web Developer & UI Designer.',
                            'publisher' => ['@id' => route('landing').'#person'],
                            'inLanguage' => ['id-ID', 'en-US'],
                        ],
                        [
                            '@type' => 'ImageObject',
                            '@id' => route('landing').'#primaryimage',
                            'url' => $this->resolveImageUrl($profile?->hero_image),
                            'contentUrl' => $this->resolveImageUrl($profile?->hero_image),
                            'caption' => $name.' - Full Stack Web Developer & UI Designer',
                            'width' => 1200,
                            'height' => 630,
                        ],
                        [
                            '@type' => 'Person',
                            '@id' => route('landing').'#person',
                            'name' => $name,
                            'alternateName' => ['Adya', 'Adya Handika', 'Portfolio Adya', 'Adya Komputer'],
                            'jobTitle' => $roleTitle,
                            'url' => route('landing'),
                            'email' => $profile->email ?? 'handikaadya@gmail.com',
                            'image' => ['@id' => route('landing').'#primaryimage'],
                            'sameAs' => array_values($socials),
                            'knowsAbout' => [
                                'Web Development',
                                'Full Stack Development',
                                'Laravel',
                                'PHP',
                                'JavaScript',
                                'Tailwind CSS',
                                'UI/UX Design',
                                'Alpine.js',
                                'MySQL',
                                'REST API',
                            ],
                        ],
                        [
                            '@type' => 'ProfilePage',
                            'name' => $name,
                            'url' => route('landing'),
                            'isPartOf' => ['@id' => route('landing').'#website'],
                            'about' => ['@id' => route('landing').'#person'],
                            'mainEntity' => ['@id' => route('landing').'#person'],
                            'primaryImageOfPage' => ['@id' => route('landing').'#primaryimage'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function courseIndex(): View
    {
        $courses = Course::orderBy('sort_order')->get();
        $ogImage = $this->resolveImageUrl(null);

        return view('course.index', [
            'courses' => $courses,
            'activeNav' => 'course',
            'seo' => [
                'title' => 'Course Programming | Materi Pembelajaran Web Development',
                'description' => 'Kumpulan materi belajar programming dan web development. Tutorial Laravel, JavaScript, PHP, dan desain UI untuk pemula hingga lanjut.',
                'image' => $ogImage,
                'url' => route('course.index'),
                'keywords' => 'Course Programming, Tutorial Web Development, Materi Laravel, Belajar JavaScript, PHP Tutorial, UI Design, Pemrograman Web',
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => array_values(array_filter([
                        [
                            '@type' => 'CollectionPage',
                            'name' => 'Course Programming',
                            'description' => 'Kumpulan materi belajar programming dan web development.',
                            'url' => route('course.index'),
                            'image' => $ogImage,
                        ],
                        $ogImage ? [
                            '@type' => 'ImageObject',
                            'url' => $ogImage,
                            'contentUrl' => $ogImage,
                            'caption' => 'Course Programming - Materi Web Development',
                        ] : null,
                        [
                            '@type' => 'BreadcrumbList',
                            'itemListElement' => [
                                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('landing')],
                                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Course', 'item' => route('course.index')],
                            ],
                        ],
                    ])),
                ],
            ],
        ]);
    }

    public function showCourse(Course $course): View
    {
        $allCourses = Course::orderBy('sort_order')->get();
        $courseIndex = $allCourses->search(fn ($item) => $item->id === $course->id);
        $courseImage = $this->resolveImageUrl($course->gambar);

        return view('course.show', [
            'course' => $course,
            'allCourses' => $allCourses,
            'courseIndex' => $courseIndex === false ? 0 : $courseIndex,
            'totalCourses' => $allCourses->count(),
            ...$this->navigation($course, $allCourses),
            'activeNav' => 'course',
            'seo' => [
                'title' => $course->nama.' | Course Material',
                'description' => $course->desk,
                'image' => $courseImage,
                'url' => route('course.show', $course),
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'LearningResource',
                            'name' => $course->nama,
                            'description' => $course->desk,
                            'image' => $courseImage,
                            'url' => route('course.show', $course),
                            'learningResourceType' => 'Course material',
                            'author' => ['@type' => 'Person', 'name' => profile()->name ?? 'Adya Handika Putra AP'],
                        ],
                        [
                            '@type' => 'ImageObject',
                            'url' => $courseImage,
                            'contentUrl' => $courseImage,
                            'caption' => 'Course: '.$course->nama,
                        ],
                        [
                            '@type' => 'BreadcrumbList',
                            'itemListElement' => [
                                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('landing')],
                                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Course', 'item' => route('course.index')],
                                ['@type' => 'ListItem', 'position' => 3, 'name' => $course->nama, 'item' => route('course.show', $course)],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function showSubbab(Course $course, string $subbabSlug): View
    {
        $index = $course->getSubbabIndexBySlug($subbabSlug);

        if ($index === null) {
            abort(404);
        }

        $blocks = $course->konten ?? [];

        $subbabIndices = [];
        foreach ($blocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        if (empty($subbabIndices) || ! in_array($index, $subbabIndices, true)) {
            abort(404);
        }

        $pos = array_search($index, $subbabIndices, true);
        $start = $index;
        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($blocks);
        $subbabBlocks = array_slice($blocks, $start, $end - $start);

        $subbabs = [];
        foreach ($subbabIndices as $si) {
            $slug = $course->getSubbabSlugByIndex($si);
            if ($slug) {
                $subbabs[] = [
                    'index' => $si,
                    'judul' => $blocks[$si]['judul'] ?? '',
                    'slug' => $slug,
                ];
            }
        }

        $subbabPos = $pos;
        $codeLangs = ['php', 'javascript', 'typescript', 'html', 'css', 'sql', 'python', 'bash', 'json', 'csharp', 'java'];
        $subbabTitle = $blocks[$index]['judul'] ?? 'Subbab';
        $subbabImage = $this->resolveImageUrl($course->gambar);

        return view('course.subbab', [
            'course' => $course,
            'subbabBlocks' => $subbabBlocks,
            'subbabs' => $subbabs,
            'currentSubbabIndex' => $index,
            'currentSubbabPos' => $subbabPos,
            'allCourses' => Course::orderBy('sort_order')->get(),
            'codeLangs' => $codeLangs,
            'prevSubbab' => $subbabPos > 0 ? $subbabs[$subbabPos - 1] : null,
            'nextSubbab' => $subbabPos < count($subbabs) - 1 ? $subbabs[$subbabPos + 1] : null,
            'activeNav' => 'course',
            'seo' => [
                'title' => $subbabTitle.' | '.$course->nama,
                'description' => $course->desk ?? $course->nama,
                'url' => route('course.subbab', [$course, $subbabSlug]),
                'image' => $subbabImage,
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'Article',
                            'headline' => $subbabTitle,
                            'description' => $course->desk,
                            'image' => $subbabImage,
                            'url' => route('course.subbab', [$course, $subbabSlug]),
                            'author' => ['@type' => 'Person', 'name' => profile()->name ?? 'Adya Handika Putra AP'],
                            'publisher' => ['@type' => 'Organization', 'name' => profile()->name ?? 'Adya Handika Putra AP'],
                            'isPartOf' => [
                                '@type' => 'LearningResource',
                                'name' => $course->nama,
                                'url' => route('course.show', $course),
                            ],
                        ],
                        [
                            '@type' => 'ImageObject',
                            'url' => $subbabImage,
                            'contentUrl' => $subbabImage,
                            'caption' => $subbabTitle.' - '.$course->nama,
                        ],
                        [
                            '@type' => 'BreadcrumbList',
                            'itemListElement' => [
                                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('landing')],
                                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Course', 'item' => route('course.index')],
                                ['@type' => 'ListItem', 'position' => 3, 'name' => $course->nama, 'item' => route('course.show', $course)],
                                ['@type' => 'ListItem', 'position' => 4, 'name' => $subbabTitle, 'item' => route('course.subbab', [$course, $subbabSlug])],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function showProject(Project $project): View
    {
        $allTools = Tool::orderBy('sort_order')->get();

        $projectTools = collect($project->tools ?? [])->map(
            fn ($item) => $allTools->firstWhere('id', $item)
                ?? $allTools->firstWhere('nama', $item)
                ?? (object) ['nama' => (string) $item, 'gambar' => null]
        )->values();

        $projectImage = $this->resolveImageUrl($project->gambar);

        return view('landing.project', [
            'project' => $project,
            'projectTools' => $projectTools,
            ...$this->navigation($project, Project::orderBy('sort_order')->get()),
            'activeNav' => 'proyek',
            'seo' => [
                'title' => $project->nama.' | Project Portfolio',
                'description' => $project->desk,
                'image' => $projectImage,
                'url' => route('project.show', $project),
                'type' => 'article',
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'CreativeWork',
                            'name' => $project->nama,
                            'headline' => $project->nama,
                            'description' => $project->full_desk ?? $project->desk,
                            'image' => $projectImage,
                            'url' => route('project.show', $project),
                            'keywords' => $projectTools->map->nama->implode(', '),
                            'author' => ['@type' => 'Person', 'name' => 'Adya Handika Putra AP'],
                        ],
                        [
                            '@type' => 'ImageObject',
                            'url' => $projectImage,
                            'contentUrl' => $projectImage,
                            'caption' => 'Project: '.$project->nama,
                        ],
                        [
                            '@type' => 'BreadcrumbList',
                            'itemListElement' => [
                                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('landing')],
                                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Projects', 'item' => route('landing').'#proyek'],
                                ['@type' => 'ListItem', 'position' => 3, 'name' => $project->nama, 'item' => route('project.show', $project)],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function showExperience(Experience $experience): View
    {
        $allTools = Tool::orderBy('sort_order')->get();

        $experienceSkills = collect($experience->skills ?? [])->map(
            fn ($item) => $allTools->firstWhere('id', $item)
                ?? $allTools->firstWhere('nama', $item)
                ?? $allTools->firstWhere(fn ($t) => strcasecmp($t->nama, (string) $item) === 0)
                ?? (object) ['nama' => (string) $item, 'gambar' => null]
        )->values();

        $expImage = $this->resolveImageUrl($experience->gambar);

        return view('landing.experience', [
            'experience' => $experience,
            'experienceSkills' => $experienceSkills,
            ...$this->navigation($experience, Experience::orderBy('sort_order')->get()),
            'activeNav' => 'experiences',
            'seo' => [
                'title' => $experience->role.' at '.$experience->company.' | Experience',
                'description' => $experience->desk,
                'image' => $expImage,
                'url' => route('experience.show', $experience),
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WorkExperience',
                            'name' => $experience->role,
                            'description' => $experience->desk,
                            'url' => route('experience.show', $experience),
                            'image' => $expImage,
                            'employee' => ['@type' => 'Person', 'name' => 'Adya Handika Putra AP'],
                            'hiringOrganization' => [
                                '@type' => 'Organization',
                                'name' => $experience->company,
                            ],
                            'datePosted' => $experience->duration,
                        ],
                        [
                            '@type' => 'ImageObject',
                            'url' => $expImage,
                            'contentUrl' => $expImage,
                            'caption' => $experience->company.' - '.$experience->role,
                        ],
                        [
                            '@type' => 'BreadcrumbList',
                            'itemListElement' => [
                                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('landing')],
                                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Experiences', 'item' => route('landing').'#experiences'],
                                ['@type' => 'ListItem', 'position' => 3, 'name' => $experience->role.' at '.$experience->company, 'item' => route('experience.show', $experience)],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function showCertificate(Certificate $certificate): View
    {
        $certImage = $this->resolveImageUrl($certificate->gambar);

        return view('landing.certificate', [
            'certificate' => $certificate,
            ...$this->navigation($certificate, Certificate::orderBy('sort_order')->get()),
            'activeNav' => 'certificates',
            'seo' => [
                'title' => $certificate->nama.' | Certificate',
                'description' => $certificate->desk
                    ?? 'Sertifikat '.$certificate->nama.' dari '.$certificate->penerbit,
                'image' => $certImage,
                'url' => route('certificate.show', $certificate),
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'EducationalOccupationalCredential',
                            'name' => $certificate->nama,
                            'description' => $certificate->desk,
                            'credentialCategory' => 'Certificate',
                            'recognizedBy' => $certificate->penerbit
                                ? ['@type' => 'Organization', 'name' => $certificate->penerbit]
                                : null,
                            'url' => route('certificate.show', $certificate),
                            'image' => $certImage,
                        ],
                        [
                            '@type' => 'ImageObject',
                            'url' => $certImage,
                            'contentUrl' => $certImage,
                            'caption' => 'Sertifikat: '.$certificate->nama,
                        ],
                        [
                            '@type' => 'BreadcrumbList',
                            'itemListElement' => [
                                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('landing')],
                                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Certificates', 'item' => route('landing').'#certificates'],
                                ['@type' => 'ListItem', 'position' => 3, 'name' => $certificate->nama, 'item' => route('certificate.show', $certificate)],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function sitemap(): Response
    {
        $profile = profile();

        $entries = [
            [
                'loc' => route('landing'),
                'priority' => '1.0',
                'lastmod' => $profile?->updated_at ?? now(),
                'image' => [
                    'loc' => $this->resolveImageUrl($profile?->hero_image),
                    'title' => ($profile?->name ?? 'Adya Handika Putra AP').' - Portfolio',
                    'caption' => $profile?->tagline ?? 'Full Stack Web Developer & UI Designer',
                ],
            ],
        ];

        foreach (Project::orderBy('sort_order')->get() as $project) {
            $entries[] = [
                'loc' => route('project.show', $project),
                'priority' => '0.8',
                'lastmod' => $project->updated_at,
                'image' => $project->gambar ? [
                    'loc' => $this->resolveImageUrl($project->gambar),
                    'title' => $project->nama,
                    'caption' => $project->desk,
                ] : null,
            ];
        }

        foreach (Experience::orderBy('sort_order')->get() as $experience) {
            $entries[] = [
                'loc' => route('experience.show', $experience),
                'priority' => '0.7',
                'lastmod' => $experience->updated_at,
                'image' => $experience->gambar ? [
                    'loc' => $this->resolveImageUrl($experience->gambar),
                    'title' => $experience->company.' - '.$experience->role,
                    'caption' => $experience->desk,
                ] : null,
            ];
        }

        foreach (Certificate::orderBy('sort_order')->get() as $certificate) {
            $entries[] = [
                'loc' => route('certificate.show', $certificate),
                'priority' => '0.7',
                'lastmod' => $certificate->updated_at,
                'image' => $certificate->gambar ? [
                    'loc' => $this->resolveImageUrl($certificate->gambar),
                    'title' => $certificate->nama,
                    'caption' => 'Sertifikat dari '.($certificate->penerbit ?? 'Adya Portfolio'),
                ] : null,
            ];
        }

        $courseIndexImg = $this->resolveImageUrl(null);
        $entries[] = [
            'loc' => route('course.index'),
            'priority' => '0.8',
            'lastmod' => Course::max('updated_at') ?? now(),
            'image' => $courseIndexImg ? [
                'loc' => $courseIndexImg,
                'title' => 'Course Programming - Tutorial Web Development',
                'caption' => 'Kumpulan tutorial programming dan web development.',
            ] : null,
        ];

        foreach (Course::orderBy('sort_order')->get() as $course) {
            $entries[] = [
                'loc' => route('course.show', $course),
                'priority' => '0.7',
                'lastmod' => $course->updated_at,
                'image' => $course->gambar ? [
                    'loc' => $this->resolveImageUrl($course->gambar),
                    'title' => $course->nama,
                    'caption' => $course->desk,
                ] : null,
            ];

            // Add subbab URLs
            $blocks = $course->konten ?? [];
            foreach ($blocks as $block) {
                if (($block['type'] ?? '') === 'subbab') {
                    $slug = $course->getSubbabSlugByIndex(array_search($block, $blocks, true));
                    if ($slug) {
                        $entries[] = [
                            'loc' => route('course.subbab', [$course, $slug]),
                            'priority' => '0.6',
                            'lastmod' => $course->updated_at,
                            'image' => $course->gambar ? [
                                'loc' => $this->resolveImageUrl($course->gambar),
                                'title' => ($block['judul'] ?? 'Subbab').' - '.$course->nama,
                                'caption' => $course->desk,
                            ] : null,
                        ];
                    }
                }
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'."\n"
            .'        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'."\n";

        foreach ($entries as $entry) {
            $lastmodStr = '';
            if (! empty($entry['lastmod'])) {
                try {
                    $dt = $entry['lastmod'] instanceof \DateTimeInterface
                        ? $entry['lastmod']
                        : Carbon::parse($entry['lastmod']);
                    $lastmodStr = '    <lastmod>'.$dt->format(\DateTimeInterface::ATOM).'</lastmod>'."\n";
                } catch (\Throwable $e) {
                }
            }

            $xml .= '  <url>'."\n"
                .'    <loc>'.e($entry['loc']).'</loc>'."\n"
                .$lastmodStr
                .'    <changefreq>weekly</changefreq>'."\n"
                .'    <priority>'.$entry['priority'].'</priority>'."\n";

            if (! empty($entry['image']) && ! empty($entry['image']['loc'])) {
                $xml .= '    <image:image>'."\n"
                    .'      <image:loc>'.e($entry['image']['loc']).'</image:loc>'."\n";
                if (! empty($entry['image']['title'])) {
                    $xml .= '      <image:title>'.e($entry['image']['title']).'</image:title>'."\n";
                }
                if (! empty($entry['image']['caption'])) {
                    $xml .= '      <image:caption>'.e($entry['image']['caption']).'</image:caption>'."\n";
                }
                $xml .= '    </image:image>'."\n";
            }

            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    private function resolveImageUrl(?string $path): ?string
    {
        if (empty($path)) {
            $hero = profile()?->hero_image;
            if (empty($hero)) {
                return null;
            }
            $path = $hero;
        }

        $url = img_url($path);
        if (str_starts_with($url, '//')) {
            return 'https:'.$url;
        }

        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            return url($url);
        }

        return $url;
    }

    /**
     * @param  Collection<int, mixed>  $ordered
     * @return array{prev: mixed, next: mixed}
     */
    private function navigation(object $current, Collection $ordered): array
    {
        $index = $ordered->search(fn ($item) => $item->id === $current->id);

        return [
            'prev' => $index !== false && $index > 0 ? $ordered[$index - 1] : null,
            'next' => $index !== false && $index < $ordered->count() - 1 ? $ordered[$index + 1] : null,
        ];
    }

    public function githubContributions(string $year = 'last'): JsonResponse
    {
        $year = in_array($year, ['last', '2024', '2025', '2026', '2027']) ? $year : 'last';
        $profile = profile();
        $githubUsername = 'Adya30';
        if (! empty($profile->github)) {
            $parsedPath = parse_url($profile->github, PHP_URL_PATH);
            $trimmed = trim((string) $parsedPath, '/');
            if (! empty($trimmed)) {
                $githubUsername = $trimmed;
            }
        }

        $cacheKey = "github_contributions_{$githubUsername}_{$year}";
        $data = Cache::remember($cacheKey, 7200, function () use ($githubUsername, $year) {
            try {
                $url = "https://github-contributions-api.jogruber.de/v4/{$githubUsername}?y={$year}";
                $response = Http::timeout(5)->get($url);
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                //
            }

            return null;
        });

        return response()->json($data ?? ['total' => [], 'contributions' => []]);
    }
}
