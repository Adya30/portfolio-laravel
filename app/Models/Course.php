<?php

namespace App\Models;

use App\Models\Concerns\HasSlugRouteKey;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['slug', 'nama', 'nama_idn', 'desk', 'desk_idn', 'konten', 'gambar', 'sort_order'])]
class Course extends Model
{
    use HasSlugRouteKey;

    protected function casts(): array
    {
        return [
            'konten' => 'array',
        ];
    }

    public function getSubbabIndexBySlug(string $slug): ?int
    {
        if (!$this->konten || !is_array($this->konten)) {
            return null;
        }

        foreach ($this->konten as $index => $block) {
            if (isset($block['type']) && $block['type'] === 'subbab') {
                $judul = $block['judul'] ?? '';
                $blockSlug = Str::slug($judul) ?: ('subbab-'.($index + 1));
                if ($blockSlug === $slug || Str::slug($judul) === $slug) {
                    return $index;
                }
            }
        }

        return null;
    }

    public function getSubbabSlugByIndex(int $index): ?string
    {
        if (!$this->konten || !is_array($this->konten)) {
            return null;
        }

        $block = $this->konten[$index] ?? null;

        if ($block && isset($block['type']) && $block['type'] === 'subbab') {
            $judul = $block['judul'] ?? '';
            return Str::slug($judul) ?: ('subbab-'.($index + 1));
        }

        return null;
    }
}
