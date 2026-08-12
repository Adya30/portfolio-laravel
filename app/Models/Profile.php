<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'role_title',
    'tagline',
    'about_1',
    'about_2',
    'email',
    'cv_url',
    'hero_image',
    'github',
    'instagram',
    'youtube',
    'linkedin',
])]
class Profile extends Model {}
