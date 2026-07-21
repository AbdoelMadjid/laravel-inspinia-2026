<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\View\Composers\SidebarComposer;
use App\View\Composers\TopbarComposer;
use Illuminate\Support\Facades\View;

use App\Listeners\LogSuccessfulLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();
        View::composer('layouts.partials.sidebar', SidebarComposer::class);
        View::composer('layouts.partials.topbar', TopbarComposer::class);
    }
}
