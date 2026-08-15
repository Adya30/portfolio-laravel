<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['role', 'role_idn', 'company', 'duration', 'location', 'desk', 'desk_idn', 'practicum_desc', 'practicum_desc_idn', 'gambar', 'responsibilities', 'responsibilities_idn', 'skills', 'sort_order'])]
class Experience extends Model
{
    protected function casts(): array
    {
        return [
            'responsibilities' => 'array',
            'responsibilities_idn' => 'array',
            'skills' => 'array',
        ];
    }
}
