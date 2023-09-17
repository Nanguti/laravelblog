<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TinyMCEUploadController extends Controller
{
    public function upload(Request $request)
    {

        $uploadedFile = $request->file('file');
        $originalFilename = $uploadedFile->getClientOriginalName();
        $path = $path = $uploadedFile->storeAs('uploads', $originalFilename . '.' . $uploadedFile->getClientOriginalExtension(), 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
            'id' => $path,
        ]);
    }
}
