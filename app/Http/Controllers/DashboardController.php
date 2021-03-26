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
        //$dossiersARelancer = Dossier::with('delais')->get() ;

        $dossiersARelancer = Dossier::whereHas('delais', function (Builder $query) {
            $query->where('date', '>=', 'CURDATE()');
        })->get();

        //dd($dossiersARelancer) ;

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
        $reserved = $lotsAll->where('etiquette_id', 3)->count(); 
        $stocked = $lotsAll->where('etiquette_id', 2)->count(); 
        $promised = $lotsAll->where('etiquette_id', 9)->count(); 

        $blocked = $lotsAll->count() - ($stocked + $reserved + $promised); 

        $appartementsAll = Produit::with('constructible')
                            ->where('constructible_type','appartement')
                            ->with('etiquette')
                            ->get();
        $appartementsReserved = $appartementsAll->where('etiquette_id', 3)->count() ;
        $appartementsStocked = $appartementsAll->where('etiquette_id', 2)->count() ;
        $appartementsPromised = $appartementsAll->where('etiquette_id', 9)->count(); 
        $appartementsBlocked = $appartementsAll->whereNotIn('etiquette_id', [3,2,9])->count() ;

        $magasinsAll = Produit::with('constructible')
                            ->where('constructible_type','magasin')
                            ->with('etiquette')
                            ->get();
        $magasinsReserved = $magasinsAll->where('etiquette_id', 3)->count() ;
        $magasinsStocked = $magasinsAll->where('etiquette_id', 2)->count() ;
        $magasinsPromised = $magasinsAll->where('etiquette_id', 9)->count();         
        $magasinsBlocked = $magasinsAll->whereNotIn('etiquette_id', [3,2,9])->count() ;

        $bureauxAll = Produit::with('constructible')
                            ->where('constructible_type','bureau')
                            ->with('etiquette')
                            ->get();
        $bureauxReserved = $bureauxAll->where('etiquette_id', 3)->count() ;
        $bureauxStocked = $bureauxAll->where('etiquette_id', 2)->count() ;
        $bureauxPromised = $bureauxAll->where('etiquette_id', 9)->count();         
        $bureauxBlocked = $bureauxAll->whereNotIn('etiquette_id', [3,2,9])->count() ;

        $boxesAll = Produit::with('constructible')
                            ->where('constructible_type','box')
                            ->with('etiquette')
                            ->get();

        $boxesReserved = $boxesAll->where('etiquette_id', 3)->count() ;
        $boxesStocked = $boxesAll->where('etiquette_id', 2)->count() ;
        $boxesPromised = $boxesAll->where('etiquette_id', 9)->count();
        $boxesBlocked = $boxesAll->whereNotIn('etiquette_id', [3,2,9])->count() ;


        $dossiersAll = Dossier::with('produit')->with('client')->with('paiements')
        ->orderByDesc('created_at')->paginate(15);

        // pour compter les taux d'avances 30%

        $dossiers = Produit::with('dossier')->with('constructible')->with('paiements')->get();

        // sélectionner les produits vendus càd avec un dossier
        $groupedDossiers = $dossiers->filter(function ($item, $key) {
            if (isset($item->dossier)) {
               return true ;    
            }
        });


        $groupedDossiers = $groupedDossiers->groupBy('constructible_type');

        $groupedDossiers = $groupedDossiers->map(function ($item, $key) {
            return $item->map(function ($item, $key){
                    return
                    [
               'CaReserve' => $item->totalDefinitif,
               'totalPaiementsV' => $item->dossier->totalPaiementsV,
               'totalPaiementsNV' => ($item->dossier->totalPaiements - $item->dossier->totalPaiementsV),
               'tauxPaiement' => $item->dossier->tauxPaiementV,
               'reliquat' => $item->dossier->reliquat,
                    ];
            });
        });

        $groupedDossiers = $groupedDossiers->map(function ($item, $key) {
                return
                [
                'CaReserve' => $item->sum('CaReserve'),
                'totalPaiementsV' => $item->sum('totalPaiementsV'),
                'totalPaiementsNV' => $item->sum('totalPaiementsNV'),
                'tauxPaiement' => $item->sum('tauxPaiement') / $item->count(),
                'reliquat' => $item->sum('reliquat'),                    
                ]  ;    
           
        });

        $groupedDossiers = $groupedDossiers->mapWithKeys(function ($item, $key) {
            return [$key.'Finance' => $item];
        });



        $total = 0 ;
           $CAdossiers = $dossiers->map(function ($item, $key) use ($total) {
            if (isset($item->dossier)) {
               return $total = $total + $item->totalDefinitif;    
            }
        });


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
        // $produitsParTypeParEtat = Produit::produitsParTypeParEtat()->mapWithKeys(function ($item) {
        //     return [$item->constructible_type.'s' =>
        //     [$item->label => $item->nombre] ];
        // });        


        $dossiersParType = Dossier::dossiersParType()->mapWithKeys(function ($item) {
            return [$item->constructible_type => $item->nombre];
        });
        $paiements = Paiement::sum('montant') ;
        $paiementsV = Paiement::where('valider', 1)->sum('montant') ;
        $paiementsN = $paiements - $paiementsV ;
        $CA = $CAdossiers->sum() ;
        $reliquat = $CA - $paiementsV ; 

        $total = 0 ;
        $prixTotalLots = $lotsAll->map(function ($item, $key) use ($total) {
                return $total = $total + $item->totalIndicatif;
        });
        $total = 0 ;
        $prixTotalappartements = $appartementsAll->map(function ($item, $key) use ($total) {
               return $total = $total + $item->totalIndicatif;
        });           
        $total = 0 ;
        $prixTotalmagasins = $magasinsAll->map(function ($item, $key) use ($total) {
               return $total = $total + $item->totalIndicatif;
        }); 
        $total = 0 ;
        $prixTotalbureaux = $bureauxAll->map(function ($item, $key) use ($total) {
               return $total = $total + $item->totalIndicatif;
        }); 
        $total = 0 ;
        $prixTotalboxes = $boxesAll->map(function ($item, $key) use ($total) {
               return $total = $total + $item->totalIndicatif;
        }); 



        return view('dashboard', [
			'reserved' 	=> $reserved, 
	        'stocked' 	=> $stocked,
	        'blocked' 	=> $blocked,
            'promised'   => $promised,
            
            'interets'      => Visite::interets(),
            'tauxConversion' => Client::tauxConversion() . ' %', 
            'appartementsReserved' => $appartementsReserved,
            'appartementsStocked' => $appartementsStocked,
            'appartementsBlocked' => $appartementsBlocked,
            'appartementsPromised' => $appartementsPromised,

            'bureauxReserved' => $bureauxReserved,
            'bureauxStocked' => $bureauxStocked,
            'bureauxBlocked' => $bureauxBlocked,
            'bureauxPromised' => $bureauxPromised,

            'magasinsReserved' => $magasinsReserved,
            'magasinsStocked' => $magasinsStocked,
            'magasinsBlocked' => $magasinsBlocked,
            'magasinsPromised' => $magasinsPromised,

            'boxesReserved' => $boxesReserved,
            'boxesStocked' => $boxesStocked,
            'boxesBlocked' => $boxesBlocked,
            'boxesPromised' => $boxesPromised,

            'valeurTotalLots' => $prixTotalLots->sum(),
            'valeurTotalAppartements' => $prixTotalappartements->sum(),
            'valeurTotalBureaux' => $prixTotalbureaux->sum(),
            'valeurTotalMagasins' => $prixTotalmagasins->sum(),
            'valeurTotalBoxes' => $prixTotalboxes->sum(),

	        'dossiers' => $dossiersAll,
	        'nombreVisites' => $nombreVisites,
	        'mois' => $mois,
            'paiements' => number_format($paiements) ,
            'paiementsV' => number_format($paiementsV) ,
            'paiementsN' => number_format($paiementsN) ,
            'CA'        => number_format($CA),
            'reliquat' => number_format($reliquat), 
            'dossiersUnder30' => $dossiersUnder30->count(),
            'dossiersOver30' => $dossiersOver30->count(),
            'nombreVentes' => $nombreVentes,
            'nombreVentesParMois' => $nombreVentesParMois,
            'totalVisites'  => Visite::all(),
            'visitesDay'    => Visite::visitesDay(),
            'visitesMonth'  => Visite::visitesMonth(),
            'visitesYear'   => Visite::visitesYear(),
            'visitesWeek'   => Visite::visitesWeek(),
                        
        ], $dossiersParType->all() + $produitsParType->all() + $groupedDossiers->all(),
    ) ;
    }
}
