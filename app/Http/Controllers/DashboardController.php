<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dossier;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Visite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index()
    {

    	$mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'September', 'October', 'November','Décembre'] ;

    	$nombreVisites = \DB::select("
                    SELECT * FROM (
                    SELECT YEAR (date) as an, MONTH(date) as mois , COUNT(*) as nombreVisites
                    from visites
                    group by MONTH(date), YEAR(date)
                    Order by YEAR(date) desc, MONTH(date) desc
                    limit 7
                    ) as sub
                    ORDER BY an asc, mois asc            
            ");

        $nombreVentes = \DB::select("
SELECT an, mois,
    max(case when (constructible_type='lot') then nombreVentes else 0 end) as 'lot',
    max(case when (constructible_type='magasin') then nombreVentes else 0 end) as 'magasin',
    max(case when (constructible_type='appartement') then nombreVentes else 0 end) as 'appartement',
    max(case when (constructible_type='bureau') then nombreVentes else 0 end) as 'bureau',
    max(case when (constructible_type='box') then nombreVentes else 0 end) as 'box'
FROM
(
    SELECT produits.constructible_type as constructible_type, YEAR (dossiers.date) as an, MONTH(dossiers.date) as mois , COUNT(*) as nombreVentes
    from dossiers
    LEFT JOIN produits
    ON dossiers.produit_id = produits.id
    group by MONTH(dossiers.date), YEAR(dossiers.date), produits.constructible_type
    Order by YEAR(dossiers.date) desc, MONTH(dossiers.date) desc
    Limit 7
) AS T
GROUP BY an, mois
Limit 7
            ");

         

        $nombreVentesParMois = \DB::select("
                    SELECT * FROM (
                    SELECT YEAR (date) as an, MONTH(date) as mois , COUNT(*) as nombreVentes
                    from dossiers
                    group by MONTH(date), YEAR(date)
                    Order by YEAR(date) desc, MONTH(date) desc
                    limit 7
                    ) as sub
                    ORDER BY an asc, mois asc            
            ");
        
        
        $lotsAll = Produit::with('etiquette')
        					->with('constructible')
                            ->where('constructible_type','lot')
                            ->get();
        $reserved = $lotsAll->where('etiquette.label', 'Réservé')->count(); 
        $stocked = $lotsAll->where('etiquette.label', 'En stock')->count(); 
        $blocked = $lotsAll->count() - ($stocked + $reserved); 

        $dossiersAll = Dossier::with('produit')->with('client')->with('paiements')
        ->orderByDesc('created_at')->paginate(15);

        // pour compter les taux d'avances 30%

        $dossiers = Produit::with('dossier')->with('constructible')->with('paiements')->get();
        //dd($dossiers) ;
         $dossiersUnder30 = $dossiers->filter(function ($item, $key) {
                if (isset($item->dossier)) {
                    return ($item->dossier->tauxPaiement < 30) ? true : false  ;
                }

        });
         $dossiersOver30 = $dossiers->filter(function ($item, $key) {
                if (isset($item->dossier)) {
                    return ($item->dossier->tauxPaiement > 30) ? true : false  ;
                }

        });

        $produitsParType = Produit::produitsParType()->mapWithKeys(function ($item) {
            return [$item->constructible_type.'s' => $item->nombre];
        });

        $dossiersParType = Dossier::dossiersParType()->mapWithKeys(function ($item) {
            return [$item->constructible_type => $item->nombre];
        });

        return view('dashboard', [
			'reserved' 	=> $reserved, 
	        'stocked' 	=> $stocked,
	        'blocked' 	=> $blocked,
	        'dossiers' => $dossiersAll,
	        'nombreVisites' => $nombreVisites,
	        'mois' => $mois,
            'paiements' => number_format(Paiement::sum('montant')) ,
            'dossiersUnder30' => $dossiersUnder30->count(),
            'dossiersOver30' => $dossiersOver30->count(),
            'nombreVentes' => $nombreVentes,
            'nombreVentesParMois' => $nombreVentesParMois
        ], $dossiersParType->all() + $produitsParType->all(),
    ) ;
    }
}


/*
select an, mois,
max(case when (constructible_type='lot') then nombreVentes else NULL end) as 'lot',
max(case when (constructible_type='magasin') then nombreVentes else NULL end) as 'magasin',
max(case when (constructible_type='appartement') then nombreVentes else NULL end) as 'appartement',
max(case when (constructible_type='bureau') then nombreVentes else NULL end) as 'bureau',
max(case when (constructible_type='box') then nombreVentes else NULL end) as 'box'
from
(
    SELECT produits.constructible_type as constructible_type, YEAR (dossiers.date) as an, MONTH(dossiers.date) as mois , COUNT(*) as nombreVentes
    from dossiers
    LEFT JOIN produits
    ON dossiers.produit_id = produits.id
    group by MONTH(dossiers.date), YEAR(dossiers.date), produits.constructible_type
    Order by YEAR(dossiers.date) asc, MONTH(dossiers.date) asc
) as T
group by an, mois*/