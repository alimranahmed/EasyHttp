<?php

namespace AlImranAhmed\EasyHttp;

use AlImranAhmed\EasyHttp\Services\HttpCallable;
use AlImranAhmed\EasyHttp\Services\HttpHandler;
use Illuminate\Support\ServiceProvider;

class EasyHttpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Http', HttpHandler::class);
    }
}
