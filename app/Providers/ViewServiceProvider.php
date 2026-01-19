<?php

namespace App\Providers;

use App\Models\Page;
use App\View\Composers\AdminNavigationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['components.public-nav', 'components.customer-nav'], function ($view) {
            $view->with('public_pages', Page::where('is_published', true)->get());
        });

        // For Admin Navigation Badge
        View::composer('layouts.navigation', AdminNavigationComposer::class);
    }
}
