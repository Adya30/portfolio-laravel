<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Fillable(['slug', 'role', 'role_idn', 'company', 'duration', 'location', 'desk', 'desk_idn', 'practicum_desc', 'practicum_desc_idn', 'gambar', 'responsibilities', 'responsibilities_idn', 'skills', 'sort_order'])]
class Experience extends Model
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

        $name = trim(($this->role ?? '') . ' ' . ($this->company ?? '')) ?: 'experience';
        $generatedSlug = $this->generateUniqueSlug($name, $this->id);

        if (!empty($generatedSlug)) {
            $this->slug = $generatedSlug;
            if ($this->exists && !empty($this->id)) {
                DB::table('experiences')->where('id', $this->id)->update(['slug' => $generatedSlug]);
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
        static::saving(function (Experience $model) {
            $name = trim(($model->role ?? '') . ' ' . ($model->company ?? '')) ?: 'experience';
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($name, $model->id);
            } elseif (($model->isDirty('role') || $model->isDirty('company')) && !$model->isDirty('slug')) {
                $model->slug = $model->generateUniqueSlug($name, $model->id);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'responsibilities' => 'array',
            'responsibilities_idn' => 'array',
            'skills' => 'array',
        ];
    }

    public function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name) ?: 'experience';
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
