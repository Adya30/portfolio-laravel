<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Fillable(['slug', 'nama', 'desk', 'desk_idn', 'full_desk', 'full_desk_idn', 'link', 'link_live', 'tools', 'fitur', 'fitur_idn', 'gambar', 'category_id', 'sort_order'])]
class Project extends Model
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

        $generatedSlug = $this->generateUniqueSlug($this->nama ?? 'project', $this->id);

        if (!empty($generatedSlug)) {
            $this->slug = $generatedSlug;
            if ($this->exists && !empty($this->id)) {
                DB::table('projects')->where('id', $this->id)->update(['slug' => $generatedSlug]);
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
        static::saving(function (Project $model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($model->nama ?? 'project', $model->id);
            } elseif ($model->isDirty('nama') && !$model->isDirty('slug')) {
                $model->slug = $model->generateUniqueSlug($model->nama, $model->id);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'tools' => 'array',
            'fitur' => 'array',
            'fitur_idn' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name) ?: 'project';
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
