<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'nama_idn', 'penerbit', 'tanggal', 'desk', 'desk_idn', 'gambar', 'icon', 'sort_order'])]
class Certificate extends Model {}
