<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use App\Helpers\LogHelper;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(Logout::class, function ($event) {
        if ($event->user) {
            LogHelper::add('Logout dari sistem');
        }
    });
    }
}