<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SettingController;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CvController extends Controller
{
    /**
     * Stream the uploaded CV as a download.
     * Served through a route (not a raw asset link) so the filename stays
     * friendly and a missing file 404s cleanly instead of exposing the path.
     */
    public function download(): BinaryFileResponse
    {
        $path = Setting::get(SettingController::CV_PATH);

        abort_if(!$path || !Storage::disk('public')->exists($path), 404, 'No CV has been uploaded yet.');

        $name = Setting::get(SettingController::CV_NAME) ?: 'Ahsan-Nawaz-CV.pdf';

        return response()->download(Storage::disk('public')->path($path), $name);
    }
}
