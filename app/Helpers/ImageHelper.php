<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    public static function uploadImage($image, $folder = 'posts')
    {
        $filename = uniqid().'.'.$image->getClientOriginalExtension();
        $path = "$folder/$filename";
        $thumbnailPath = "$folder/thumbnails/$filename";

        // Ensure directories exist (optional with disk usage)
        Storage::disk('public')->makeDirectory($folder);
        Storage::disk('public')->makeDirectory("$folder/thumbnails");

        // Save original image
        Storage::disk('public')->put($path, file_get_contents($image));

        // Create and save thumbnail
        $thumbnail = Image::make($image)->fit(300, 200)->encode();
        Storage::disk('public')->put($thumbnailPath, $thumbnail);

        return [
            'image' => $path,
            'thumbnail' => $thumbnailPath
        ];
    }
}
