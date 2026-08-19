<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['slug', 'nama', 'nama_idn', 'penerbit', 'tanggal', 'desk', 'desk_idn', 'gambar', 'link', 'sort_order'])]
class Certificate extends Model
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Certificate $model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($model->nama);
            }
        });

        static::updating(function (Certificate $model) {
            if ($model->isDirty('nama') && !$model->isDirty('slug')) {
                $model->slug = $model->generateUniqueSlug($model->nama, $model->id);
            }
        });
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
}
