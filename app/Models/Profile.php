<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'role_title',
    'role_title_idn',
    'tagline',
    'tagline_idn',
    'about_1',
    'about_1_idn',
    'about_2',
    'about_2_idn',
    'email',
    'cv_url',
    'hero_image',
    'github',
    'instagram',
    'youtube',
    'linkedin',
])]
class Profile extends Model {}
