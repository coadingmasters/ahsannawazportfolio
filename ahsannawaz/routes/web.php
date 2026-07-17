<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
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

        // Skills CRUD (no show() on the controller — index is the detail view)
        Route::resource('skills', SkillController::class)->except('show');
        Route::post('skills/{skill}/toggle', [SkillController::class, 'toggleActive'])->name('skills.toggle');

        // Projects CRUD (no show() on the controller — index is the detail view)
        Route::resource('projects', ProjectController::class)->except('show');
        Route::post('projects/{project}/toggle', [ProjectController::class, 'toggleActive'])->name('projects.toggle');
    });
});
