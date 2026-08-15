<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
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
        $profile = Profile::first();
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
                            'name' => $name,
                            'url' => route('landing'),
                        ],
                        [
                            '@type' => 'Person',
                            'name' => $name,
                            'jobTitle' => $roleTitle,
                            'url' => route('landing'),
                            'image' => $profile?->hero_image ? url(img_url($profile->hero_image)) : null,
                            'sameAs' => array_values($socials),
                        ],
                    ],
                ],
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
                    '@type' => 'CreativeWork',
                    'name' => $project->nama,
                    'headline' => $project->nama,
                    'description' => $project->full_desk ?? $project->desk,
                    'image' => $project->gambar ? url(img_url($project->gambar)) : null,
                    'url' => route('project.show', $project),
                    'keywords' => $projectTools->map->nama->implode(', '),
                    'author' => ['@type' => 'Person', 'name' => 'Adya Handika Putra AP'],
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
                'url' => route('experience.show', $experience),
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
            ],
        ]);
    }

    public function sitemap(): Response
    {
        $entries = [
            ['loc' => route('landing'), 'priority' => '1.0'],
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
