<?php

namespace App\Providers;

use App\Media;
use App\Category;
use App\Observers\MediaObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Order;
use App\Observers\OrderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
