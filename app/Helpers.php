<?php

use Illuminate\Support\Str;

if (! function_exists('profile')) {
    /**
     * Ambil profil utama — hasilnya di-memoize sekali per request
     * (via once()), jadi pemanggilan dari controller, footer, dll.
     * hanya menjalankan SATU query dalam satu request.
     */
    function profile(): ?\App\Models\Profile
    {
        return once(fn () => \App\Models\Profile::first(), 'app.profile');
    }
}

if (! function_exists('img_url')) {
    /**
     * Resolve a stored image path into a public URL.
     * Accepts full URLs, root-relative paths (/assets/...), and storage paths.
     */
    function img_url(?string $path): string
    {
        if (! $path) {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', '/'])) {
            return $path;
        }

        return asset($path);
    }
}

if (! function_exists('tool_icon_url')) {
    /**
     * Get the icon URL for a tool/skill name, falling back to real tech SVGs or SVG badges.
     */
    function tool_icon_url(?string $nama, ?string $gambar = null): string
    {
        if ($gambar) {
            return img_url($gambar);
        }

        if (! $nama) {
            return '';
        }

        $nameLower = strtolower(trim($nama));

        $knownIcons = [
            'laravel' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg',
            'php' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg',
            'python' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg',
            'javascript' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg',
            'js' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg',
            'typescript' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/typescript/typescript-original.svg',
            'html 5' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg',
            'html5' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg',
            'html' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg',
            'css 3' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg',
            'css3' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg',
            'css' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg',
            'tailwind' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg',
            'bootstrap' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg',
            'react' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg',
            'mysql' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg',
            'postgre' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg',
            'postgres' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg',
            'c#' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/csharp/csharp-original.svg',
            'csharp' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/csharp/csharp-original.svg',
            '.net' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/dot-net/dot-net-original.svg',
            'git' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg',
            'github' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg',
            'figma' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/figma/figma-original.svg',
            'canva' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/canva/canva-original.svg',
            'studio code' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vscode/vscode-original.svg',
            'vscode' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vscode/vscode-original.svg',
            'node' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nodejs/nodejs-original.svg',
            'blogger' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/blogger/blogger-original.svg',
            'database' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/sqldeveloper/sqldeveloper-original.svg',
            'algorithm' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/c/c-original.svg',
            'c programming' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/c/c-original.svg',
            'web' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg',
        ];

        foreach ($knownIcons as $key => $url) {
            if (str_contains($nameLower, $key)) {
                return $url;
            }
        }

        $letter = strtoupper(substr($nama, 0, 1));
        return 'data:image/svg+xml;utf8,' . rawurlencode(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40">'
            . '<rect width="100%" height="100%" rx="10" fill="#3b82f6" fill-opacity="0.15"/>'
            . '<text x="50%" y="58%" font-family="sans-serif" font-size="20" font-weight="bold" fill="#3b82f6" text-anchor="middle" dominant-baseline="middle">'
            . $letter
            . '</text></svg>'
        );
    }
}
