<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['slug', 'nama', 'nama_idn', 'desk', 'desk_idn', 'konten', 'gambar', 'sort_order'])]
class Course extends Model
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Course $model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($model->nama);
            }
        });

        static::updating(function (Course $model) {
            if ($model->isDirty('nama') && !$model->isDirty('slug')) {
                $model->slug = $model->generateUniqueSlug($model->nama, $model->id);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'konten' => 'array',
        ];
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $baseSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
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
