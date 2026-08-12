<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'penerbit', 'tanggal', 'desk', 'gambar', 'icon', 'sort_order'])]
class Certificate extends Model {}
