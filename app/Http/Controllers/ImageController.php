<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show($path)
    {
        $disk = Storage::disk('s3');
        
        if (!$disk->exists($path)) {
            abort(404);
        }

        $file = $disk->get($path);
        $mimeType = $disk->mimeType($path);

        return response($file, 200)->header('Content-Type', $mimeType);
    }
}
