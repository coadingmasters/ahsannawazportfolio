<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public const CV_PATH = 'cv_path';
    public const CV_NAME = 'cv_original_name';
    public const CV_SIZE = 'cv_size';
    public const CV_UPLOADED_AT = 'cv_uploaded_at';

    public function index()
    {
        return view('admin.settings.index', [
            'cvPath'       => Setting::get(self::CV_PATH),
            'cvName'       => Setting::get(self::CV_NAME),
            'cvSize'       => Setting::get(self::CV_SIZE),
            'cvUploadedAt' => Setting::get(self::CV_UPLOADED_AT),
        ]);
    }

    public function uploadCv(Request $request)
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf|max:5120',
        ], [
            'cv.required' => 'Choose a PDF file to upload.',
            'cv.mimes'    => 'The CV must be a PDF file.',
            'cv.max'      => 'The CV may not be larger than 5 MB.',
        ]);

        // Replace any previous file so old CVs don't pile up on disk.
        $old = Setting::get(self::CV_PATH);
        if ($old) {
            Storage::disk('public')->delete($old);
        }

        $file = $request->file('cv');
        $path = $file->store('cv', 'public');

        Setting::put(self::CV_PATH, $path);
        Setting::put(self::CV_NAME, $file->getClientOriginalName());
        Setting::put(self::CV_SIZE, (string) $file->getSize());
        Setting::put(self::CV_UPLOADED_AT, now()->toDateTimeString());

        return redirect()->route('admin.settings.index')
            ->with('success', 'CV uploaded successfully! The Download CV buttons are now live.');
    }

    public function deleteCv()
    {
        $path = Setting::get(self::CV_PATH);

        if ($path) {
            Storage::disk('public')->delete($path);
        }

        foreach ([self::CV_PATH, self::CV_NAME, self::CV_SIZE, self::CV_UPLOADED_AT] as $key) {
            Setting::forget($key);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'CV removed. The Download CV buttons are hidden again.');
    }
}
