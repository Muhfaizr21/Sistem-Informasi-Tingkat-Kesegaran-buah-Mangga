<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Convert and store an image as WebP.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @param int $quality
     * @return string Path to the stored WebP image
     */
    public static function uploadAsWebp($file, $directory = 'uploads', $quality = 80)
    {
        // Check if it's an image
        if (!Str::startsWith($file->getMimeType(), 'image/')) {
            return $file->store($directory, 'public');
        }

        // Create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // Create a unique filename
        $filename = Str::random(40) . '.webp';
        $path = $directory . '/' . $filename;

        // Read and encode image to WebP
        $image = $manager->read($file);
        $encoded = $image->toWebp($quality);

        // Store the encoded image
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Convert and store a base64 image as WebP.
     *
     * @param string $base64String
     * @param string $directory
     * @param int $quality
     * @return string Path to the stored WebP image
     */
    public static function base64ToWebp($base64String, $directory = 'uploads', $quality = 80)
    {
        // Remove data URI scheme if present
        $img = preg_replace('/^data:image\/\w+;base64,/', '', $base64String);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        // Create image manager
        $manager = new ImageManager(new Driver());

        // Create a unique filename
        $filename = Str::random(40) . '.webp';
        $path = $directory . '/' . $filename;

        // Read and encode image to WebP
        $image = $manager->read($data);
        $encoded = $image->toWebp($quality);

        // Store the encoded image
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Alias for uploadAsWebp
     */
    public static function uploadAndConvert($file, $directory = 'uploads', $quality = 80)
    {
        return self::uploadAsWebp($file, $directory, $quality);
    }
}
