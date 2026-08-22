<?php

use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;

if (! function_exists('render_markdown')) {
    function render_markdown(?string $text): string
    {
        if ($text === null || $text === '') {
            return '';
        }

        $converter = once(function () {
            $env = new Environment([
                'html_input'         => 'strip',
                'allow_unsafe_links' => false,
                'max_nesting_level'  => 10,
            ]);
            $env->addExtension(new CommonMarkCoreExtension);
            $env->addExtension(new TableExtension);

            return new MarkdownConverter($env);
        });

        $html = $converter->convert($text)->getContent();

        $allowed = '<p><br><strong><em><u><s><del><ul><ol><li><blockquote><code><pre><a><hr><h1><h2><h3><h4><h5><h6><table><thead><tbody><tr><th><td>';

        $html = strip_tags($html, $allowed);

        $html = preg_replace_callback('/<h([1-6])>(.*?)<\/h\1>/', function ($m) {
            $level = $m[1];
            $inner = $m[2];
            $slug = Str::slug(strip_tags($inner));
            return '<h'.$level.' id="'.$slug.'">'.$inner.'</h'.$level.'>';
        }, $html);

        return $html;
    }
}

if (! function_exists('profile')) {
    function profile(): ?\App\Models\Profile
    {
        return once(fn () => \App\Models\Profile::first(), 'app.profile');
    }
}

if (! function_exists('img_url')) {
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
    function tool_icon_url(?string $nama, ?string $gambar = null): string
    {
        if ($gambar) {
            return img_url($gambar);
        }

        if (! $nama) {
            return '';
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
