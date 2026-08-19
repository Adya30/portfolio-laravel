<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Http\Response;
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

        return view('landing.landing', [
            'profile' => $profile,
            'categories' => $categories,
            'projects' => $projects,
            'tools' => $tools,
            'experiences' => $experiences,
            'certificates' => $certificates,
            'seo' => [
                'title' => $name.' | Web Developer & UI Designer Portfolio',
                'description' => $profile->tagline
                    ?? 'Design UI for website, building modular web applications with a focus on architecture and precise digital experiences.',
                'image' => $profile->hero_image ?? null,
                'url' => route('landing'),
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WebSite',
                            '@id' => route('landing').'#website',
                            'name' => $name,
                            'url' => route('landing'),
                        ],
                        [
                            '@type' => 'Person',
                            '@id' => route('landing').'#person',
                            'name' => $name,
                            'jobTitle' => $roleTitle,
                            'url' => route('landing'),
                            'image' => $profile?->hero_image ? img_url($profile->hero_image) : null,
                            'sameAs' => array_values($socials),
                        ],
                        [
                            '@type' => 'ProfilePage',
                            'name' => $name,
                            'url' => route('landing'),
                            'isPartOf' => ['@id' => route('landing').'#website'],
                            'about' => ['@id' => route('landing').'#person'],
                            'mainEntity' => ['@id' => route('landing').'#person'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function courseIndex(): View
    {
        $courses = Course::orderBy('sort_order')->get();

        return view('course.index', [
            'courses' => $courses,
            'activeNav' => 'course',
            'seo' => [
                'title' => 'Course Programming',
                'description' => 'Collection of Course Programming (materi) covering web development, programming, and UI design.',
                'url' => route('course.index'),
            ],
        ]);
    }

    public function showCourse(Course $course): View
    {
        $allCourses = Course::orderBy('sort_order')->get();
        $courseIndex = $allCourses->search(fn ($item) => $item->id === $course->id);

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
                'image' => $course->gambar ?? null,
                'url' => route('course.show', $course),
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'LearningResource',
                            'name' => $course->nama,
                            'description' => $course->desk,
                            'image' => $course->gambar ? img_url($course->gambar) : null,
                            'url' => route('course.show', $course),
                            'learningResourceType' => 'Course material',
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

    public function showSubbab(Course $course, int $index): View
    {
        $blocks = $course->konten ?? [];

        // Find all subbab indices
        $subbabIndices = [];
        foreach ($blocks as $i => $block) {
            if (($block['type'] ?? '') === 'subbab') {
                $subbabIndices[] = $i;
            }
        }

        if (empty($subbabIndices) || ! in_array($index, $subbabIndices, true)) {
            abort(404);
        }

        // Extract blocks for this subbab (from this subbab to the next subbab or end)
        $pos = array_search($index, $subbabIndices, true);
        $start = $index;
        $end = isset($subbabIndices[$pos + 1]) ? $subbabIndices[$pos + 1] : count($blocks);
        $subbabBlocks = array_slice($blocks, $start, $end - $start);

        // Build subbab list for navigation
        $subbabs = [];
        foreach ($subbabIndices as $si) {
            $subbabs[] = [
                'index' => $si,
                'judul' => $blocks[$si]['judul'] ?? '',
            ];
        }

        $subbabPos = $pos;

        $codeLangs = ['php', 'javascript', 'typescript', 'html', 'css', 'sql', 'python', 'bash', 'json', 'csharp', 'java'];

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
                'title' => ($blocks[$index]['judul'] ?? '').' | '.$course->nama,
                'description' => $course->desk ?? $course->nama,
                'url' => route('course.subbab', [$course, $index]),
            ],
        ]);
    }

    public function showProject(Project $project): View
    {
        $allTools = Tool::orderBy('sort_order')->get();

        // Resolve the project's tools (stored as tool ids, with a fallback for
        // legacy free-text names) so the detail page can render their icons.
        $projectTools = collect($project->tools ?? [])->map(
            fn ($item) => $allTools->firstWhere('id', $item)
                ?? $allTools->firstWhere('nama', $item)
                ?? (object) ['nama' => (string) $item, 'gambar' => null]
        )->values();

        return view('landing.project', [
            'project' => $project,
            'projectTools' => $projectTools,
            ...$this->navigation($project, Project::orderBy('sort_order')->get()),
            'activeNav' => 'proyek',
            'seo' => [
                'title' => $project->nama.' | Project Portfolio',
                'description' => $project->desk,
                'image' => $project->gambar ?? null,
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
                            'image' => $project->gambar ? img_url($project->gambar) : null,
                            'url' => route('project.show', $project),
                            'keywords' => $projectTools->map->nama->implode(', '),
                            'author' => ['@type' => 'Person', 'name' => 'Adya Handika Putra AP'],
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

        return view('landing.experience', [
            'experience' => $experience,
            'experienceSkills' => $experienceSkills,
            ...$this->navigation($experience, Experience::orderBy('sort_order')->get()),
            'activeNav' => 'experiences',
            'seo' => [
                'title' => $experience->role.' at '.$experience->company.' | Experience',
                'description' => $experience->desk,
                'image' => $experience->gambar ?? null,
                'url' => route('experience.show', $experience),
                'jsonld' => [
                    '@context' => 'https://schema.org',
                    '@graph' => [
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
        return view('landing.certificate', [
            'certificate' => $certificate,
            ...$this->navigation($certificate, Certificate::orderBy('sort_order')->get()),
            'activeNav' => 'certificates',
            'seo' => [
                'title' => $certificate->nama.' | Certificate',
                'description' => $certificate->desk
                    ?? 'Sertifikat '.$certificate->nama.' dari '.$certificate->penerbit,
                'image' => $certificate->gambar ?? null,
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
                            'image' => $certificate->gambar ? img_url($certificate->gambar) : null,
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
            ],
        ];

        foreach (Project::orderBy('sort_order')->get() as $project) {
            $entries[] = ['loc' => route('project.show', $project), 'priority' => '0.8', 'lastmod' => $project->updated_at];
        }

        foreach (Experience::orderBy('sort_order')->get() as $experience) {
            $entries[] = ['loc' => route('experience.show', $experience), 'priority' => '0.7', 'lastmod' => $experience->updated_at];
        }

        foreach (Certificate::orderBy('sort_order')->get() as $certificate) {
            $entries[] = ['loc' => route('certificate.show', $certificate), 'priority' => '0.7', 'lastmod' => $certificate->updated_at];
        }

        $entries[] = ['loc' => route('course.index'), 'priority' => '0.8', 'lastmod' => Course::max('updated_at') ?? now()];

        foreach (Course::orderBy('sort_order')->get() as $course) {
            $entries[] = ['loc' => route('course.show', $course), 'priority' => '0.7', 'lastmod' => $course->updated_at];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($entries as $entry) {
            $xml .= '  <url>'
                .'<loc>'.e($entry['loc']).'</loc>'
                .(isset($entry['lastmod']) && $entry['lastmod'] ? '<lastmod>'.$entry['lastmod']->toAtomString().'</lastmod>' : '')
                .'<changefreq>weekly</changefreq>'
                .'<priority>'.$entry['priority'].'</priority>'
                .'</url>'."\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    private function navigation($current, $ordered): array
    {
        $index = $ordered->search(fn ($item) => $item->id === $current->id);

        return [
            'prev' => $index !== false && $index > 0 ? $ordered[$index - 1] : null,
            'next' => $index !== false && $index < $ordered->count() - 1 ? $ordered[$index + 1] : null,
        ];
    }
}
