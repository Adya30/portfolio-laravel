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

    /**
     * Get subbab index by slug
     */
    public function getSubbabIndexBySlug(string $slug): ?int
    {
        if (!$this->konten || !is_array($this->konten)) {
            return null;
        }

        foreach ($this->konten as $index => $block) {
            if (isset($block['type']) && $block['type'] === 'subbab' && isset($block['judul'])) {
                $blockSlug = Str::slug($block['judul']);
                if ($blockSlug === $slug) {
                    return $index;
                }
            }
        }

        return null;
    }

    /**
     * Get subbab slug by index
     */
    public function getSubbabSlugByIndex(int $index): ?string
    {
        if (!$this->konten || !is_array($this->konten)) {
            return null;
        }

        $block = $this->konten[$index] ?? null;
        
        if ($block && isset($block['type'], $block['judul']) && $block['type'] === 'subbab') {
            return Str::slug($block['judul']);
        }

        return null;
    }
}
