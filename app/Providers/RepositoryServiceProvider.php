<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\ApisConfigRepository::class, \App\Repositories\ApisConfigRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ApisConfigsRepository::class, \App\Repositories\ApisConfigsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TesteEmersonRepository::class, \App\Repositories\TesteEmersonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmersonTesteRepository::class, \App\Repositories\EmersonTesteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmersonTestesRepository::class, \App\Repositories\EmersonTestesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CustomerRepository::class, \App\Repositories\CustomerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MKategoriPekerjaanRepository::class, \App\Repositories\MKategoriPekerjaanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MSparepartRepository::class, \App\Repositories\MSparepartRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MMobilRepository::class, \App\Repositories\MMobilRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TPerbaikanRepository::class, \App\Repositories\TPerbaikanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TDetailPerbaikanRepository::class, \App\Repositories\TDetailPerbaikanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TPenerimaanBarangRepository::class, \App\Repositories\TPenerimaanBarangRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TPenerimaanBarangDetailRepository::class, \App\Repositories\TPenerimaanBarangDetailRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TPerbaikanJasaRepository::class, \App\Repositories\TPerbaikanJasaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MSupplierRepository::class, \App\Repositories\MSupplierRepositoryEloquent::class);
        //:end-bindings:
    }
}
