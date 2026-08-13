<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nama', 'desk', 'full_desk', 'link', 'tools', 'fitur', 'gambar', 'category_id', 'sort_order'])]
class Project extends Model
{
    protected function casts(): array
    {
        return [
            'tools' => 'array',
            'fitur' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
