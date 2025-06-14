<?php

namespace App\Services\System;

use Fauzantaqiyuddin\LaravelMinio\Facades\Miniojan;

/**
 * Class UploadToMinioService.
 */
class UploadToMinioService
{
    public function handle($image, $folder)
    {
        $file = $image;
        $directory = 'conim/' . $folder;

        $path = $file->store('temp');
        $filePath = storage_path('app/' . $path);

        // Upload file ke MinIO
        $response = Miniojan::upload($directory, $filePath);
        unlink($filePath);
        return $response;
    }
}
