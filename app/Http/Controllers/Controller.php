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

                if (strtolower($file->getClientOriginalExtension()) !== 'svg') {
                    $options['format'] = 'webp';
                }

                $result = $cloudinary->uploadApi()->upload($file->getRealPath(), $options);

                return $result['secure_url'] ?? $result['url'];
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $this->storeLocally($file, $dir);
    }

    private function storeLocally(UploadedFile $file, string $dir): string
    {
        $name = time().'_'.Str::random(10);
        $ext = strtolower($file->getClientOriginalExtension());
        $targetDir = public_path('uploads/'.$dir);

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if ($ext !== 'svg' && function_exists('imagewebp')) {
            $image = @imagecreatefromstring((string) file_get_contents($file->getRealPath()));

            if ($image !== false) {
                $dest = $targetDir.'/'.$name.'.webp';

                imagealphablending($image, false);
                imagesavealpha($image, true);
                imagewebp($image, $dest, 85);
                imagedestroy($image);

                return 'uploads/'.$dir.'/'.$name.'.webp';
            }
        }

        $file->move($targetDir, $name.'.'.$ext);

        return 'uploads/'.$dir.'/'.$name.'.'.$ext;
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
            'confirmed' => ':attribute tidak cocok.',
            'current_password' => 'Password saat ini salah.',
            'password' => ':attribute minimal :min karakter.',
        ];
    }
}
