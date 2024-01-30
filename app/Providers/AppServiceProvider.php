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

		$this->app->bind(
			\App\Http\Services\UserService::class,
			\App\Http\Services\Impl\UserServiceImpl::class
		);

		$this->app->bind(
			\App\Repositories\UserRepository::class,
			\App\Repositories\Impl\UserRepositoryImpl::class
		);

		$this->app->bind(
			\App\Repositories\OwnerRepository::class,
			\App\Repositories\Impl\OwnerRepositoryImpl::class
		);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
