<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Debugbar', Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //URL::forceRootUrl(config('app.url'));

        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Gate::define('viewLogViewer', [UserPolicy::class, 'viewLogViewer']);

        Route::pattern('user', '[0-9]+');
        Route::pattern('webinar', '[0-9]+');
        Route::pattern('worksheet', '[0-9]+');
        Route::pattern('specialist', '[0-9]+');
        Route::pattern('center', '[0-9]+');
        Route::pattern('payment', '[0-9]+');
        Route::pattern('conference', '[0-9]+');
        Route::pattern('bulletin', '[0-9]+');
        Route::pattern('file', '[0-9]+');

        RateLimiter::for('smtp.bz', function (object $job) {
            return Limit::perHour(100);
        });
    }
}
