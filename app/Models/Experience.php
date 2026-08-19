<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['slug', 'role', 'role_idn', 'company', 'duration', 'location', 'desk', 'desk_idn', 'practicum_desc', 'practicum_desc_idn', 'gambar', 'responsibilities', 'responsibilities_idn', 'skills', 'sort_order'])]
class Experience extends Model
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Experience $model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($model->role . '-' . $model->company);
            }
        });

        static::updating(function (Experience $model) {
            if (($model->isDirty('role') || $model->isDirty('company')) && !$model->isDirty('slug')) {
                $model->slug = $model->generateUniqueSlug($model->role . '-' . $model->company, $model->id);
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
