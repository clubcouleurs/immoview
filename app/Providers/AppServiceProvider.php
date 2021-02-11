<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Relation::morphMap([
            'lot' => 'App\Models\Lot',
            'appartement' => 'App\Models\Appartement',
            'magasin' => 'App\Models\Magasin',
            'bureau' => 'App\Models\Bureau',
            'box' => 'App\Models\Box',
        ]);
    }
}
