<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait HasSlugRouteKey
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getRouteKey(): string|int
    {
        try {
            $slug = $this->getAttribute('slug');

            if (!empty($slug)) {
                return (string) $slug;
            }

            $name = $this->getSlugBaseName();
            $generatedSlug = $this->generateUniqueSlug($name, $this->id);

            if (!empty($generatedSlug)) {
                $this->slug = $generatedSlug;
                if ($this->exists && !empty($this->id)) {
                    DB::table($this->getTable())->where('id', $this->id)->update(['slug' => $generatedSlug]);
                }

                return $generatedSlug;
            }
        } catch (\Throwable $e) {
            // Fallback if 'slug' column does not exist in DB table
        }

        return $this->id ?? '';
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        try {
            $found = $this->where($field ?? $this->getRouteKeyName(), $value)
                ->orWhere('id', $value)
                ->first();

            if ($found) {
                return $found;
            }
        } catch (\Throwable $e) {
            // Fallback if 'slug' column does not exist in DB table
        }

        return $this->where('id', $value)->first();
    }

    public function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name) ?: 'item';
        $baseSlug = $slug;
        $counter = 1;

        try {
            while (static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
        } catch (\Throwable $e) {
            return $baseSlug;
        }

        return $slug;
    }

    protected static function bootHasSlugRouteKey(): void
    {
        static::saving(function (Model $model) {
            try {
                $name = $model->getSlugBaseName();
                if (empty($model->slug)) {
                    $model->slug = $model->generateUniqueSlug($name, $model->id);
                } elseif ($model->isSlugNameDirty() && !$model->isDirty('slug')) {
                    $model->slug = $model->generateUniqueSlug($name, $model->id);
                }
            } catch (\Throwable $e) {
                // Ignore if column does not exist
            }
        });
    }

    public function getSlugBaseName(): string
    {
        if (isset($this->role) || isset($this->company)) {
            return trim(($this->role ?? '') . ' ' . ($this->company ?? '')) ?: 'experience';
        }

        return $this->nama ?? 'item';
    }

    public function isSlugNameDirty(): bool
    {
        if (isset($this->role) || isset($this->company)) {
            return $this->isDirty('role') || $this->isDirty('company');
        }

        return $this->isDirty('nama');
    }
}
