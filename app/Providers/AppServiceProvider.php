<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;


use Illuminate\Support\Facades\View;
use App\Models\Entreprise;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Services\ProjectModulesService::class, function () {
            return new \App\Services\ProjectModulesService();
        });
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
            'bureau' => 'App\Models\Office',
            'box' => 'App\Models\Box',
        ]);


        // On utilise un View Composer pour partager les infos sur toutes les vues (*)
        View::composer('*', function ($view) {
            
            // Sécurité : On vérifie que la table existe en BDD avant de faire la requête
            // (indispensable pour éviter les crashs pendant un "php artisan migrate")

                
                // On récupère l'entreprise maîtresse (par exemple via la colonne 'is_master')
                $entreprise = Entreprise::where('default', true)->first();

            if (!is_null($entreprise)) {
                // Si elle existe, on partage son logo et son nom, sinon on met des valeurs par défaut
                $view->with([
                    'logo_entreprise' => $entreprise->logo ?? 'logo_entreprise.jpg',
                    'nom_entreprise' => $entreprise->nom ?? 'Immoview',
                    'master_entreprise' => $entreprise // Optionnel : pour avoir accès à tout l'objet si besoin
                ]);
                
            } else {
                // Valeurs de secours si la table n'existe pas encore
                $view->with([
                    'logo_entreprise' => 'logo_entreprise.jpg',
                    'nom_entreprise' => 'Immoview',
                    'master_entreprise' => null
                ]);
            }
        });


    }
}
