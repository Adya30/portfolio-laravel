<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

abstract class Controller
{
    protected function uploadImage(UploadedFile $file, string $dir): string
    {
        $isSvg = strtolower($file->getClientOriginalExtension()) === 'svg';
        $svgContent = $isSvg ? $this->compressSvg((string) file_get_contents($file->getRealPath())) : null;

        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        $apiSecret = config('cloudinary.api_secret');

        if ($cloudName && $apiKey && $apiSecret) {
            try {
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
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $this->storeLocally($file, $dir, $svgContent);
    }

    private function storeLocally(UploadedFile $file, string $dir, ?string $svgContent = null): string
    {
        $name = time().'_'.Str::random(10);
        $ext = strtolower($file->getClientOriginalExtension());
        $targetDir = public_path('uploads/'.$dir);

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if ($ext === 'svg' && $svgContent) {

            file_put_contents($targetDir.'/'.$name.'.svg', $svgContent);

            return 'uploads/'.$dir.'/'.$name.'.svg';
        }

        if ($ext !== 'svg' && function_exists('imagewebp')) {
            $image = @imagecreatefromstring((string) file_get_contents($file->getRealPath()));

            if ($image !== false) {
                // imagewebp() rejects palette images (e.g. GIF) and would write
                // a 0-byte file, so convert them to truecolor first.
                if (! imageistruecolor($image)) {
                    $truecolor = imagecreatetruecolor(imagesx($image), imagesy($image));

                    if ($truecolor !== false) {
                        imagealphablending($truecolor, false);
                        imagesavealpha($truecolor, true);
                        imagecopy($truecolor, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                        imagedestroy($image);
                        $image = $truecolor;
                    }
                }

                $dest = $targetDir.'/'.$name.'.webp';

                imagealphablending($image, false);
                imagesavealpha($image, true);

                $converted = @imagewebp($image, $dest, 85);
                imagedestroy($image);

                if ($converted && file_exists($dest) && filesize($dest) > 0) {
                    return 'uploads/'.$dir.'/'.$name.'.webp';
                }
            }
        }

        $file->move($targetDir, $name.'.'.$ext);

        return 'uploads/'.$dir.'/'.$name.'.'.$ext;
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
