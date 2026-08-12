<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Credentials
    |--------------------------------------------------------------------------
    |
    | Obtain these from the Cloudinary Console (Dashboard > API Keys):
    | https://cloudinary.com/console
    |
    */

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),

    'api_key' => env('CLOUDINARY_API_KEY'),

    'api_secret' => env('CLOUDINARY_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Secure URL
    |--------------------------------------------------------------------------
    |
    | Always generate HTTPS (secure) delivery URLs.
    |
    */

    'secure' => env('CLOUDINARY_SECURE', true),

    /*
    |--------------------------------------------------------------------------
    | Upload Folder
    |--------------------------------------------------------------------------
    |
    | Root folder inside Cloudinary where portfolio images are stored.
    |
    */

    'folder' => env('CLOUDINARY_FOLDER', 'portfolio'),
];
