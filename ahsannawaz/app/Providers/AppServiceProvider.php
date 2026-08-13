<?php

namespace App\Providers;

use App\Http\Controllers\Admin\SettingController;
use App\Models\Setting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Every view can ask whether a CV exists, so the Download CV buttons
        // can hide themselves until one is uploaded.
        View::composer('*', function ($view) {
            $hasCv = false;

            // Guard the table check: migrations run before this table exists.
            if (Schema::hasTable('settings')) {
                $hasCv = (bool) Setting::get(SettingController::CV_PATH);
            }

            $view->with('hasCv', $hasCv);
        });

        // @css('css/theme.css') — a stylesheet link stamped with the file's
        // mtime. Hostinger's CDN caches assets for 7 days, so without this a
        // deploy leaves visitors on the previous stylesheet until it expires.
        Blade::directive('css', function ($expression) {
            return "<?php \$__p = {$expression};
                \$__f = public_path(\$__p);
                echo '<link rel=\"stylesheet\" href=\"' . e(asset(\$__p))
                   . (is_file(\$__f) ? '?v=' . filemtime(\$__f) : '') . '\">'; ?>";
        });
    }
}
