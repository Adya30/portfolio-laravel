<?php

namespace App\Models;

use App\Models\Concerns\HasSlugRouteKey;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'nama', 'nama_idn', 'penerbit', 'tanggal', 'desk', 'desk_idn', 'gambar', 'link', 'sort_order'])]
class Certificate extends Model
{
    use HasSlugRouteKey;
}
