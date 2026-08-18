<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'nama_idn', 'desk', 'desk_idn', 'konten', 'gambar', 'sort_order'])]
class Course extends Model
{
    protected function casts(): array
    {
        return [
            'konten' => 'array',
        ];
    }
}
