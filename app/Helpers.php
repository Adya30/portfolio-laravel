<?php

use Illuminate\Support\Str;

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
