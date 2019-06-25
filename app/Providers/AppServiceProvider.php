<?php

namespace App\Providers;

use App\Media;
use App\Category;
use App\Observers\MediaObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Parent categories to browse product by its category
        $parentCategories = Category::where('parent', 1)->where('status', 1)->get();
        // Child categories of its parent category
        $childCategories = Category::where('parent', 0)->where('status', 1)->get();
        View::share([
            'parentCategories' => $parentCategories,
            'childCategories' => $childCategories,
            'errors' => null
        ]);

        // Media event observer
        Media::observe(MediaObserver::class);
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
