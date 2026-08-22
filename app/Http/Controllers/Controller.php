<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use RuntimeException;

abstract class Controller
{
    protected function uploadImage(UploadedFile $file, string $dir): string
    {
        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        $apiSecret = config('cloudinary.api_secret');

        if (! $cloudName || ! $apiKey || ! $apiSecret) {
            throw new RuntimeException('Cloudinary belum terkonfigurasi. Silakan isi CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, dan CLOUDINARY_API_SECRET di .env.');
        }

        $isSvg = strtolower($file->getClientOriginalExtension()) === 'svg';
        $svgContent = $isSvg ? $this->compressSvg((string) file_get_contents($file->getRealPath())) : null;

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => $cloudName,
                'api_key' => $apiKey,
                'api_secret' => $apiSecret,
            ],
            'url' => [
                'secure' => config('cloudinary.secure', true),
            ],
        ]);

        $options = [
            'folder' => rtrim(config('cloudinary.folder', 'portfolio'), '/').'/'.$dir,
            'use_filename' => true,
            'unique_filename' => true,
            'overwrite' => false,
        ];

        if ($isSvg) {
            $result = $cloudinary->uploadApi()->upload(
                'data:image/svg+xml;base64,'.base64_encode($svgContent),
                $options
            );
        } else {
            $options['format'] = 'webp';
            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), $options);
        }

        return $result['secure_url'] ?? $result['url'];
    }

    private function compressSvg(string $svg): string
    {
        $minified = preg_replace('/<\?xml[^>]*\?>/i', '', $svg);
        $minified = preg_replace('/<!DOCTYPE[^>]*(?:\[[^\]]*\][^>]*)?>/i', '', $minified);
        $minified = preg_replace('/<!--.*?-->/s', '', $minified);
        $minified = preg_replace('/>\s+</', '><', $minified);
        $minified = preg_replace_callback('/<[^>]+>/', fn ($m) => preg_replace('/\s{2,}/', ' ', $m[0]), $minified);
        $minified = trim($minified);

        return $minified !== '' ? $minified : $svg;
    }

    protected function resolveImage(Request $request, string $dir, ?string $current = null): ?string
    {
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            return $this->uploadImage($request->file('gambar'), $dir);
        }

        if ($request->filled('gambar_url')) {
            return $request->input('gambar_url');
        }

        return $current;
    }

    protected function linesToArray(?string $text): array
    {
        if (! $text) {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', preg_split('/\r\n|\r|\n/', $text) ?: []),
            fn ($line) => $line !== ''
        ));
    }

    protected function validationMessages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'email' => ':attribute harus berupa alamat email yang valid.',
            'url' => ':attribute harus berupa URL yang valid.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus berformat: :values.',
            'max.string' => ':attribute maksimal :max karakter.',
            'max.numeric' => ':attribute maksimal :max.',
            'max.file' => ':attribute maksimal :max KB.',
            'min.numeric' => ':attribute minimal :min.',
            'integer' => ':attribute harus berupa angka.',
            'array' => ':attribute harus berupa daftar pilihan.',
            'exists' => ':attribute tidak valid.',
            'confirmed' => ':attribute tidak cocok.',
            'current_password' => 'Password saat ini salah.',
            'password' => ':attribute minimal :min karakter.',
        ];
    }
}
