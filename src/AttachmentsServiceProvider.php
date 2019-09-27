<?php

namespace Envant\Attachments;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AttachmentsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadRoutes();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        // Attachment::observe(AttachmentObserver::class);
    }

    /**
     * Register routes
     *
     * @return void
     */
    public function loadRoutes()
    {
        if (config('attachments.routes.enabled') === true) {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
            Route::model('attachment', config('attachments.model'));
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/attachments.php', 'attachments');
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/attachments.php' => config_path('attachments.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
