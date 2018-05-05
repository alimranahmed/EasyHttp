<?php

namespace Alimranahmed\EasyHttp;

use Alimranahmed\EasyHttp\Services\HttpCallable;
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
        $this->publishes([
            __DIR__ . '/../config/easy_http.php' => config_path('easy_http.php'),
        ]);

        $this->app->singleton(HttpCallable::class, function(){return $this->resolvedClientClass();});

        $this->app->singleton('Http', function(){return $this->resolvedClientClass();});
    }

    private function resolvedClientClass(){
        $namespace = 'Alimranahmed\EasyHttp\Services';
        $client = config('easy_http.client', 'guzzle');
        $clientClass = ucfirst($client).'Http';
        $fullClassPath = "$namespace\\$clientClass";
        return new $fullClassPath();
    }
}
