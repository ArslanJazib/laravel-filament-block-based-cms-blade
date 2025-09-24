<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StreamingController extends Controller
{
    public function stream(Request $request, $filename)
    {
        $filePath = public_path('storage/courses/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, "Video not found");
        }

        $fileSize  = filesize($filePath);
        $start     = 0;
        $length    = $fileSize;
        $status    = 200;
        $headers   = [
            "Content-Type"  => "video/mp4",
            "Accept-Ranges" => "bytes",
        ];

        // Handle HTTP Range Requests
        if ($request->hasHeader('Range')) {
            $range = $request->header('Range');
            preg_match('/bytes=(\d*)-(\d*)/', $range, $matches);

            $start = $matches[1] !== "" ? intval($matches[1]) : 0;
            $end   = $matches[2] !== "" ? intval($matches[2]) : ($fileSize - 1);

            $length  = $end - $start + 1;
            $status  = 206; // Partial Content
            $headers["Content-Range"]  = "bytes {$start}-{$end}/{$fileSize}";
            $headers["Content-Length"] = $length;
        } else {
            $headers["Content-Length"] = $fileSize;
        }

        $stream = function () use ($filePath, $start, $length) {
            $handle = fopen($filePath, 'rb');
            fseek($handle, $start);

            $buffer = 1024 * 8; // 8KB chunks
            $bytesRemaining = $length;

            while ($bytesRemaining > 0 && !feof($handle)) {
                $read = ($bytesRemaining > $buffer) ? $buffer : $bytesRemaining;
                echo fread($handle, $read);
                $bytesRemaining -= $read;
                flush();
            }

            fclose($handle);
        };

        return response()->stream($stream, $status, $headers);
    }
}