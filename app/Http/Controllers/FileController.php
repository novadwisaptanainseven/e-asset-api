<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    // Get Image
    public function getImage($filename)
    {
        $fullpath = "/app/images/$filename";
        $message = "Data Gambar Tidak Ditemukan";

        return $this->downloads($fullpath, $message, $filename);
    }

    // Get Document
    public function getDocument($filename)
    {
        $fullpath = "/app/documents/$filename";
        $message = "Data Dokumen Tidak Ditemukan";

        return $this->downloads($fullpath, $message, $filename);
    }

    public function downloads($fullpath, $message, $filename)
    {
        if (file_exists(storage_path($fullpath))) {
            return response()->file(storage_path($fullpath), [
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ], 200);
        } else {
            return response()->json([
                "message" => $message
            ], 404);
        }
    }
}
