<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Convert and save image as WebP
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @param int $quality
     * @return string
     */
    public static function uploadAsWebp($file, $path, $quality = 80)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Ensure directory exists
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        $sourcePath = $file->getRealPath();
        $destinationPath = storage_path('app/public/' . $path . '/' . $filename);

        // Create image resource based on extension
        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'png':
                $image = imagecreatefrompng($sourcePath);
                // Preserve transparency
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'gif':
                $image = imagecreatefromgif($sourcePath);
                break;
            case 'webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                // Try generic string creation
                $image = imagecreatefromstring(file_get_contents($sourcePath));
        }

        if ($image) {
            imagewebp($image, $destinationPath, $quality);
            imagedestroy($image);
            return $path . '/' . $filename;
        }

        // Fallback to standard store if conversion fails
        return $file->store($path, 'public');
    }
}
