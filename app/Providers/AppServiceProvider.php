<?php

namespace App\Providers;

use App\Media;
use App\Observers\MediaObserver;
use Illuminate\Support\ServiceProvider;
use App\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share errors variable across views
        View::share('errors', null);

        // Media event observer
        Media::observe(MediaObserver::class);
        // Order eventt observer
        Order::observe(OrderObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
