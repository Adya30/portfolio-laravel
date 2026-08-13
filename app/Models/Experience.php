<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['role', 'company', 'duration', 'location', 'desk', 'practicum_desc', 'gambar', 'responsibilities', 'skills', 'sort_order'])]
class Experience extends Model
{
    protected function casts(): array
    {
        return [
            'responsibilities' => 'array',
            'skills' => 'array',
        ];
    }
}
