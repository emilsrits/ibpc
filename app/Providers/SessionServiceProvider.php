<?php

namespace App\Providers;

use Illuminate\Session\SessionServiceProvider as BaseSessionServiceProvider;
use App\Http\Middleware\StartSession;

class SessionServiceProvider extends BaseSessionServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSessionManager();
        $this->registerSessionDriver();
        $this->app->singleton(StartSession::class);
    }
}
