<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\HomeController;
use App\Models\Post;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    // Skills come straight from the DB, so the admin panel drives this page.
    $skills = Skill::active()->ordered()->get()->groupBy('category');

    $stats = [
        'projects' => Project::active()->count(),
        'skills' => Skill::active()->count(),
    ];

    return view('about', compact('skills', 'stats'));
})->name('about');

Route::get('/skills', function () {
    $all = Skill::active()->ordered()->get();

    $stats = [
        'total' => $all->count(),
        'categories' => $all->groupBy('category')->count(),
        'expert' => $all->where('level', 'expert')->count(),
        'average' => (int) round($all->avg('percentage') ?? 0),
    ];

    // Filters built from what's actually in the DB, with live counts.
    $categories = $all->groupBy('category')->map->count();

    return view('skills', compact('all', 'categories', 'stats'));
})->name('skills');

Route::get('/projects', function () {
    $projects = Project::active()->ordered()->get();

    // The editorial spread takes the first featured project; the grid shows the rest.
    $featured = $projects->firstWhere('is_featured', true);
    $grid = $featured ? $projects->whereNotIn('id', [$featured->id]) : $projects;

    // Filters are built from what's actually in the DB, with live counts.
    $categories = $grid->groupBy('category')->map->count();

    return view('projects', compact('grid', 'featured', 'categories'));
})->name('projects');

Route::get('/blog', function () {
    return view('blog', [
        'posts' => Post::published()->latestFirst()->paginate(9),
    ]);
})->name('blog');

Route::get('/blog/{post}', function (Post $post) {
    abort_unless($post->is_published, 404);

    return view('post', [
        'post' => $post,
        'related' => Post::published()->latestFirst()
            ->where('id', '!=', $post->id)->take(3)->get(),
    ]);
})->name('post');

Route::get('/cv', [CvController::class, 'download'])->name('cv.download');

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

// Generated rather than a static file, so it never drifts from the routes.
Route::get('/sitemap.xml', function () {
    $pages = [
        ['loc' => url('/'), 'priority' => '1.0', 'freq' => 'weekly'],
        ['loc' => route('about'), 'priority' => '0.8', 'freq' => 'monthly'],
        ['loc' => route('skills'), 'priority' => '0.8', 'freq' => 'monthly'],
        ['loc' => route('projects'), 'priority' => '0.9', 'freq' => 'weekly'],
        ['loc' => route('contact'), 'priority' => '0.7', 'freq' => 'yearly'],
    ];

    // Every published article is its own entry.
    foreach (Post::published()->latestFirst()->get() as $post) {
        $pages[] = ['loc' => route('post', $post), 'priority' => '0.6', 'freq' => 'monthly'];
    }

    if (Post::published()->exists()) {
        $pages[] = ['loc' => route('blog'), 'priority' => '0.7', 'freq' => 'weekly'];
    }

    // Newest content date doubles as the site's lastmod.
    $lastmod = optional(Project::max('updated_at'))
        ? Carbon::parse(Project::max('updated_at'))->toAtomString()
        : now()->toAtomString();

    return response()
        ->view('sitemap', compact('pages', 'lastmod'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

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
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
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

        // Blog posts
        Route::resource('posts', PostController::class)->except('show');
        Route::post('posts/{post}/toggle', [PostController::class, 'toggleActive'])->name('posts.toggle');

        // Testimonials
        Route::resource('testimonials', TestimonialController::class)->except('show');
        Route::post('testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggleActive'])->name('testimonials.toggle');
    });
});
