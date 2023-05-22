<?php

namespace Hladenkyi\Editor;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('editor', __DIR__.'/../dist/js/field.js');
            Nova::style('editor', __DIR__.'/../dist/css/field.css');
        });

        $this->publishes([
            __DIR__.'/../config/tiny-editor.php' => config_path('tiny-editor.php'),
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tiny-editor.php', 'tiny-editor');
    }

    protected function routes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->prefix('nova-vendor/editor')
            ->group(__DIR__.'/../routes/api.php');
    }
}
