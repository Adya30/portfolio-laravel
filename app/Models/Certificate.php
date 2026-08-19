<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Fillable(['slug', 'nama', 'nama_idn', 'penerbit', 'tanggal', 'desk', 'desk_idn', 'gambar', 'link', 'sort_order'])]
class Certificate extends Model
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getRouteKey(): string|int
    {
        $slug = $this->getAttribute('slug');

        if (!empty($slug)) {
            return $slug;
        }

        $generatedSlug = $this->generateUniqueSlug($this->nama ?? 'certificate', $this->id);

        if (!empty($generatedSlug)) {
            $this->slug = $generatedSlug;
            if ($this->exists && !empty($this->id)) {
                DB::table('certificates')->where('id', $this->id)->update(['slug' => $generatedSlug]);
            }

            return $generatedSlug;
        }

        return $this->id ?? '';
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where($field ?? $this->getRouteKeyName(), $value)
            ->orWhere('id', $value)
            ->first();
    }

    protected static function booted(): void
    {
        static::saving(function (Certificate $model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($model->nama ?? 'certificate', $model->id);
            } elseif ($model->isDirty('nama') && !$model->isDirty('slug')) {
                $model->slug = $model->generateUniqueSlug($model->nama, $model->id);
            }
        });
    }

    public function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name) ?: 'certificate';
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
