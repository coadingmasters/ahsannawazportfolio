<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ProjectController;
use App\Models\Skill;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Public Frontend
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $skills   = Skill::active()->ordered()->get()->groupBy('category');
    $projects = Project::active()->ordered()->get();
    return view('welcome', compact('skills', 'projects'));
});

Route::get('/about', function () {
    // Skills come straight from the DB, so the admin panel drives this page.
    $skills = Skill::active()->ordered()->get()->groupBy('category');

    $stats = [
        'projects' => Project::active()->count(),
        'skills'   => Skill::active()->count(),
    ];

    return view('about', compact('skills', 'stats'));
})->name('about');

Route::get('/skills', function () {
    $all = Skill::active()->ordered()->get();

    $stats = [
        'total'      => $all->count(),
        'categories' => $all->groupBy('category')->count(),
        'expert'     => $all->where('level', 'expert')->count(),
        'average'    => (int) round($all->avg('percentage') ?? 0),
    ];

    // Filters built from what's actually in the DB, with live counts.
    $categories = $all->groupBy('category')->map->count();

    return view('skills', compact('all', 'categories', 'stats'));
})->name('skills');

Route::get('/projects', function () {
    $projects = Project::active()->ordered()->get();

    // The editorial spread takes the first featured project; the grid shows the rest.
    $featured = $projects->firstWhere('is_featured', true);
    $grid     = $featured ? $projects->whereNotIn('id', [$featured->id]) : $projects;

    // Filters are built from what's actually in the DB, with live counts.
    $categories = $grid->groupBy('category')->map->count();

    return view('projects', compact('grid', 'featured', 'categories'));
})->name('projects');

Route::get('/cv', [CvController::class, 'download'])->name('cv.download');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Admin Auth
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest-only routes
    Route::middleware('guest')->group(function () {
        Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Site settings (CV upload)
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings/cv', [SettingController::class, 'uploadCv'])->name('settings.cv.upload');
        Route::delete('settings/cv', [SettingController::class, 'deleteCv'])->name('settings.cv.delete');

        // Skills CRUD (no show() on the controller — index is the detail view)
        // bulk-destroy must sit before the resource so it isn't caught by skills/{skill}
        Route::post('skills/bulk-destroy', [SkillController::class, 'bulkDestroy'])->name('skills.bulk-destroy');
        Route::resource('skills', SkillController::class)->except('show');
        Route::post('skills/{skill}/toggle', [SkillController::class, 'toggleActive'])->name('skills.toggle');

        // Projects CRUD (no show() on the controller — index is the detail view)
        // bulk-destroy must sit before the resource so it isn't caught by projects/{project}
        Route::post('projects/bulk-destroy', [ProjectController::class, 'bulkDestroy'])->name('projects.bulk-destroy');
        Route::resource('projects', ProjectController::class)->except('show');
        Route::post('projects/{project}/toggle', [ProjectController::class, 'toggleActive'])->name('projects.toggle');
    });
});
