<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;


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
        if ($this->app->environment('production')) {
            \Illuminate\Http\Request::setTrustedProxies(
                ['*'], // Todos los proxies de confianza
                SymfonyRequest::HEADER_X_FORWARDED_FOR 
                | SymfonyRequest::HEADER_X_FORWARDED_HOST 
                | SymfonyRequest::HEADER_X_FORWARDED_PROTO 
                | SymfonyRequest::HEADER_X_FORWARDED_PORT
                | SymfonyRequest::HEADER_X_FORWARDED_PREFIX
            );

            URL::forceScheme('https');
        }
    }
}
