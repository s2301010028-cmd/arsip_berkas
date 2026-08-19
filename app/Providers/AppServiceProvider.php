<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('layouts.navbar', function ($view) {
            $recentNotices = \App\Models\Notice::latest('created_at')->take(5)->get();
            $view->with('recentNotices', $recentNotices);
        });
    }
}
