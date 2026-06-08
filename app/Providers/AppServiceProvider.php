<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\KategoriRepositoryInterface;
use App\Repositories\Contracts\KendaraanRepositoryInterface;
use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Repositories\Contracts\PembayaranRepositoryInterface;
use App\Repositories\Contracts\DetailRentalRepositoryInterface;

use App\Repositories\KategoriRepository;
use App\Repositories\KendaraanRepository;
use App\Repositories\RentalRepository;
use App\Repositories\PembayaranRepository;
use App\Repositories\DetailRentalRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            KategoriRepositoryInterface::class,
            KategoriRepository::class
        );

        $this->app->bind(
            KendaraanRepositoryInterface::class,
            KendaraanRepository::class
        );

        $this->app->bind(
            RentalRepositoryInterface::class,
            RentalRepository::class
        );

        $this->app->bind(
            PembayaranRepositoryInterface::class,
            PembayaranRepository::class
        );

        $this->app->bind(
            DetailRentalRepositoryInterface::class,
            DetailRentalRepository::class
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