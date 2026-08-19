<?php

namespace App\Models;

use App\Models\Concerns\HasSlugRouteKey;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['slug', 'nama', 'desk', 'desk_idn', 'full_desk', 'full_desk_idn', 'link', 'link_live', 'tools', 'fitur', 'fitur_idn', 'gambar', 'category_id', 'sort_order'])]
class Project extends Model
{
    use HasSlugRouteKey;

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
}
