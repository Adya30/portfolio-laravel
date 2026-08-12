<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'desk', 'full_desk', 'link', 'tools', 'fitur', 'gambar', 'sort_order'])]
class Project extends Model
{
    protected function casts(): array
    {
        return [
            'tools' => 'array',
            'fitur' => 'array',
        ];
    }
}
