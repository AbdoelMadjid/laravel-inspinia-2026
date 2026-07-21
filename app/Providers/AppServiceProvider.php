<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;

use App\Listeners\LogSuccessfulLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;

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
        View::composer('layouts.partials.sidebar', SidebarComposer::class);
    }
}
