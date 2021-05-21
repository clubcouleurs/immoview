<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dossier;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use App\Models\Visite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index()
    {
        for ($i=0; $i <= 2; $i++) { 
            $day = (Carbon::now())->addDays($i) ;
            $today[$i] = Dossier::where('isVente', false)->whereHas('delais', function (Builder $query) use ($day) {
                $query->whereDate('date', $day->toDateString());
            })->get()->count();            
        }


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

        $commerciaux = User::whereIn('role_id' , [2])->get()->pluck('name') ;
        $len = count($commerciaux);
        $len = $len - 1 ;
        $maxStatement = '' ;
        $i = 0;
        foreach ($commerciaux as $value)
        {
            $maxStatement .= "max(case when (Commercial='" .$value."') then nbrVentes else 0 end)
            as '" . $value . "'" ;
                if ($i !== $len)
                {
                    $maxStatement .= ","  ;
                }
            $i++;
        }
        //dd($maxStatement) ;
        $performanceCommercial = \DB::select("
                SELECT an, mois," .
                $maxStatement
                .
                "FROM
                (SELECT u.name as Commercial, YEAR (t1.date) as an, MONTH(t1.date) as mois , COUNT(*) as nbrVentes 
        from dossiers as t1
        LEFT JOIN users as u
        ON t1.user_id = u.id
        join
        (SELECT YEAR (dossiers.date) as an, MONTH(dossiers.date) as mois
        from dossiers
        group by YEAR (dossiers.date) ,MONTH(dossiers.date)
        Order by YEAR (dossiers.date) desc, MONTH(dossiers.date) desc
        limit 7
        ) as dt
        on dt.an=YEAR(t1.date) and dt.mois=MONTH(t1.date)
        Group by MONTH(t1.date), YEAR(t1.date), u.name
        Order by YEAR(t1.date) desc, MONTH(t1.date) desc
        ) AS tt
        GROUP BY an, mois
            
            ");
        
        //dd($performanceCommercial) ;

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

        $dossiersAll = Dossier::with('produit')->with('clients')->with('paiements')
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
                    return ($item->dossier->tauxPaiementV < 30) ? true : false  ;
                }
        });
         $dossiersOver30 = $dossiers->filter(function ($item, $key) {
                if (isset($item->dossier)) {
                    return ($item->dossier->tauxPaiementV > 30) ? true : false  ;
                }
        });

        ///// les dossiers moins de 20% de paiement entre 2018 et 31/08/2020
         $dossiersUnder20 = $dossiers->filter(function ($item, $key) {
                if (isset($item->dossier) && $item->constructible_type == 'lot' ) {
                    return ($item->dossier->tauxPaiementV < 20) ? true : false  ;
                }
        });
        $dateStart = date('Y-m-d', strtotime("01-01-2018"));
        $dateEnd = date('Y-m-d', strtotime("31-08-2020"));
        $dossiersUnder20 = $dossiersUnder20->whereBetween('dossier.date', [$dateStart, $dateEnd] ); 
        ///// fin filtre

        ///// les dossiers moins de 30% de paiement entre 01/09/2020 et now
         $dossiersUnder30In2020 = $dossiers->filter(function ($item, $key) {
                if (isset($item->dossier) && $item->constructible_type == 'lot' ) {
            return ($item->dossier->tauxPaiementV < 30 ) ? true : false  ;
                }
        });
        $dateStart = date('Y-m-d', strtotime("01-09-2020"));
        $dateEnd = date('Y-m-d');
        $dossiersUnder30In2020 = $dossiersUnder30In2020->whereBetween('dossier.date', [$dateStart, $dateEnd] ); 
        //// fin filtre




        $produitsParType = Produit::produitsParType()->mapWithKeys(function ($item) {
            return [$item->constructible_type.'s' => $item->nombre];
        });

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
            'dossiersToday'         => $today[0] ,
            'dossiersTomorrow' => $today[1],
            'dossiersAfterTomorrow' =>  $today[2],
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
            'performanceCommercial' => $performanceCommercial ,
            'perfKeys' => array_keys(json_decode(json_encode($performanceCommercial), true)),
            'commerciaux' => $commerciaux ,
	        'mois' => $mois,
            'paiements' => numberFormat($paiements) ,
            'paiementsV' => numberFormat($paiementsV) ,
            'paiementsN' => numberFormat($paiementsN) ,
            'CA'        => numberFormat($CA),
            'reliquat' => numberFormat($reliquat), 
            'dossiersUnder30' => $dossiersUnder30->count(),
            'dossiersOver30' => $dossiersOver30->count(),
            'dossiersUnder20' => $dossiersUnder20->count(),
            'dossiersUnder30In2020' => $dossiersUnder30In2020->count(),
            'nombreVentes' => $nombreVentes,
            'nombreVentesParMois' => $nombreVentesParMois,
            'totalVisites'  => Visite::all(),
            'visitesDay'    => Visite::visitesDay()[0],
            'visitesMonth'  => Visite::visitesMonth()[0],
            'visitesYear'   => Visite::visitesYear()[0],
            'visitesWeek'   => Visite::visitesWeek()[0],

            'appelsDay'    => Visite::visitesDay()[1],
            'appelsMonth'  => Visite::visitesMonth()[1],
            'appelsYear'   => Visite::visitesYear()[1],
            'appelsWeek'   => Visite::visitesWeek()[1],
            'dossiersLitige' => Dossier::litige() ,
                        
        ], $dossiersParType->all() + $produitsParType->all() + $groupedDossiers->all(),
    ) ;
    }
}


