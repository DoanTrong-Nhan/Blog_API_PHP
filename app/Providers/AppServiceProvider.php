<?php

namespace App\Providers;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Post\PostService;
use App\Services\Post\PostServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         // Bind Service
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);

        // Bind Repository
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
