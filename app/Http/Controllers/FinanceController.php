<?php

namespace App\Http\Controllers;

use App\Exports\FinancesExport;
use App\Models\Appartement;
use App\Models\Dossier;
use App\Models\Lot;
use App\Models\Paiement;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //créer un tableau contenant tout les types de constructibles
        $constructibleArray = ['appartement' ,'lot',  'bureau' , 'magasin' , 'box', 'showroom','standing'] ;
        //une boucle pour collecter la data selon le type de constructible
        foreach ($constructibleArray as $constructible) {
        if ($constructible == 'showroom') {  
            ${$constructible . 'Dossiers'} = Produit::where('constructible_type', 'lot')
                            ->with('dossier')
                            ->with('constructible')
                            ->whereHasMorph(
                                    'constructible',
                                    [Lot::class],
                                    function (Builder $query) {
                                        $query->where('type', '=', 'showroom');
                                    }
                                )
                            ->with('paiements')
                            ->get();           
        }elseif($constructible == 'standing')
        {
            ${$constructible . 'Dossiers'} = Produit::where('constructible_type', 'appartement')
                            ->with('dossier')
                            ->with('constructible')
                            ->whereHasMorph(
                                    'constructible',
                                    [Appartement::class],
                                    function (Builder $query) {
                                        $query->where('type','Standing');
                                    }
                                )
                            ->with('paiements')
                            ->get();
        }
        elseif($constructible == 'appartement')
        {
            ${$constructible . 'Dossiers'} = Produit::where('constructible_type', 'appartement')
                            ->with('dossier')
                            ->with('constructible')
                            ->whereHasMorph(
                                    'constructible',
                                    [Appartement::class],
                                    function (Builder $query) {
                                        $query->where('type','Economique');
                                    }
                                )
                            ->with('paiements')
                            ->get();
        }        
        elseif($constructible == 'lot')
        {
            ${$constructible . 'Dossiers'} = Produit::where('constructible_type', $constructible)
                            ->with('dossier')
                            ->with('constructible')
                            ->whereHasMorph(
                                    'constructible',
                                    [Lot::class],
                                    function (Builder $query) {
                                        $query->where('type', '=', 'commercial');
                                    }
                                )
                            ->with('paiements')
                            ->get();
        }else
        {
            ${$constructible . 'Dossiers'} = Produit::where('constructible_type', $constructible)
                            ->with('dossier')
                            ->with('constructible')
                            ->with('paiements')
                            ->get();
        }
        // faire un groupement par tranche selon le type de constructible
            switch ($constructible)
            {
                 case 'lot':
                 case 'showroom':
                    ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                            ->groupBy('constructible.tranche_id');
                     break;
                 case 'appartement':
                 case 'magasin':
                 case 'box':
                    ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                            ->groupBy('constructible.immeuble.tranche_id');
                     break;
                 case 'standing':
                    ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                            ->groupBy('constructible.immeuble.num');
                     break;                     
                 case 'bureau':
                    ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                            ->groupBy('constructible.situable.immeuble.tranche_id');
                     break;                      
                 default:
                     break;
             }


        ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                        ->map(function ($item, $key) use ($constructible){
            return $item->map(function ($item, $key) use ($constructible){
                    return
                    [
               'totalCA' . $constructible => $item->totalIndicatif ,//$item->totalDefinitif , 
               'total' . $constructible   => 1 ,
               'totalSurface'. $constructible => $item->constructible->surface ,
               'totalSurfaceReserve'. $constructible
                            => ($item->dossier !=null && ($item->dossier != null && $item->dossier->isVente == 1) ) ? $item->constructible->surface : 0 ,
               'nbrVendus'. $constructible
                            => ($item->dossier !=null && ($item->dossier != null && $item->dossier->isVente == 1) ) ? 1 : 0 ,       
               'CaReserve'. $constructible
                            => ($item->dossier !=null && ($item->dossier != null && $item->dossier->isVente == 1) ) ? $item->totalDefinitif : 0 ,
               'totalPaiementsV'. $constructible
                            => ($item->dossier !=null && ($item->dossier != null && $item->dossier->isVente == 1) ) ? $item->dossier->totalPaiementsV : 0,
               'totalPaiementsNV'. $constructible
                            => ($item->dossier !=null && ($item->dossier != null && $item->dossier->isVente == 1) ) ? ($item->dossier->totalPaiements - $item->dossier->totalPaiementsV) : 0 ,
               'tauxPaiement'. $constructible
                            => ($item->dossier !=null && ($item->dossier != null && $item->dossier->isVente == 1) ) ? $item->dossier->tauxPaiementV : 0 ,
               'reliquat'. $constructible
                            => ($item->dossier !=null && ($item->dossier != null && $item->dossier->isVente == 1) ) ? $item->dossier->reliquat : 0 ,
               'reliquatDu30Pourcent'. $constructible
                            => ($item->dossier !=null && ($item->dossier != null && $item->dossier->isVente == 1) ) ? $item->dossier->avanceNonEnc : 0 ,                            
                    ];
            });
        });
        ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}->map(function ($item, $key) 
            use ($constructible){
                return
                [
                'totalCA'  => $item->sum('totalCA' . $constructible) ,
                'total' 
                    => $item->sum('total'. $constructible) ,
                'totalSurface' 
                    => $item->sum('totalSurface'. $constructible) ,
                'nbrVendus'
                    => $item->sum('nbrVendus'. $constructible) ,
                'tauxReservation'
                    => round(($item->sum('nbrVendus'. $constructible) / $item->sum('total'. $constructible)) * 100 , 2 )  ,
               'totalSurfaceReserve'
                    => $item->sum('totalSurfaceReserve'. $constructible) ,
                'CaReserve'
                    => $item->sum('CaReserve'. $constructible),

                'tauxRealisationCA' => round($item->sum('CaReserve'. $constructible) /
                $item->sum('totalCA' . $constructible) * 100 , 2 ) , 

                'totalPaiementsV'
                    => $item->sum('totalPaiementsV'. $constructible),
                'totalPaiementsNV'
                    => $item->sum('totalPaiementsNV'. $constructible),
                'tauxPaiement'
                    => round($item->sum('tauxPaiement'. $constructible) / 
                        (
                            ( $item->sum('nbrVendus'. $constructible) != 0 ) ? $item->sum('nbrVendus'. $constructible) : 1 
                        )
                        , 2),
                'avance30' => (($item->sum('CaReserve'. $constructible) * 30) / 100)   ,
                'reliquat'
                    => $item->sum('reliquat'. $constructible),
                'reliquatDu30Pourcent'
                    => $item->sum('reliquatDu30Pourcent'. $constructible),
                'reliquat70Pourcent'
                    => $item->sum('totalCA'. $constructible) * 0.7 ,                
                ]  ;    
           
        });
                        $total  = 0 ;
                        $nbrVendus = 0 ;
                        $totalSurface = 0 ;
                        $totalSurfaceReserve = 0 ;
                        $tauxReservation = 0 ;
                        $totalCA = 0 ;
                        $CaReserve = 0 ;
                        $tauxRealisationCA = 0 ;
                        $totalPaiementsV = 0 ;
                        $avance30 = 0 ;
                        $tauxPaiement = 0 ;
                        $reliquatDu30Pourcent = 0 ;
                        $reliquat = 0 ;
                        $reliquat70Pourcent = 0 ;

        foreach (${$constructible. 'Dossiers'} as $data) {
                                    $total  += $data['total'] ;
                                    $nbrVendus += $data['nbrVendus']  ;
                                      $totalSurface += $data['totalSurface']  ;
                                      $totalSurfaceReserve += $data['totalSurfaceReserve']  ;
                                      //$tauxReservation += $data['tauxReservation']  ;
                                      $totalCA += $data['totalCA']  ;
                                      $CaReserve += $data['CaReserve']  ;
                                      $tauxRealisationCA += $data['tauxRealisationCA']  ;
                                      $totalPaiementsV += $data['totalPaiementsV']  ;
                                      $avance30 += $data['avance30']  ;
                                      $tauxPaiement += $data['tauxPaiement']  ;
                                      $reliquatDu30Pourcent += $data['reliquatDu30Pourcent']  ;
                                      $reliquat += $data['reliquat']  ;
                                      $reliquat70Pourcent += $data['reliquat70Pourcent'] ;
                                  }  

        ${$constructible. 's' . 'Dossiers'} = collect(
            ['total' => $total,'nbrVendus' => $nbrVendus,'totalSurface'=>$totalSurface,
            'totalSurfaceReserve'=>$totalSurfaceReserve,
                'tauxReservation' => round(($nbrVendus/(($total === 0)? 1:$total) )  * 100 , 2) ,
             'totalCA'=> $totalCA, 'CaReserve'=> $CaReserve,
             'tauxRealisationCA' => round(($CaReserve/(($totalCA === 0)? 1:$totalCA) )  * 100 , 2) ,
             'totalPaiementsV'=>$totalPaiementsV, 'avance30' => $avance30,
             'tauxPaiement' => round(($totalPaiementsV/(($CaReserve == 0)? 1:$CaReserve) )  * 100 , 2) ,
             'reliquatDu30Pourcent' => $reliquatDu30Pourcent, 'reliquat' => $reliquat, 'reliquat70Pourcent' => $reliquat70Pourcent]) ; 

        //dd(${$constructible. 's' . 'Dossiers'}) ;
        if (!in_array($constructible, ['showroom', 'standing']))
        {
            ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}->mapWithKeys(function ($item, $key) {
                return ['Tranche '.$key => $item];
            });
            
        }else
        {
            if($constructible == 'showroom')
            {
            ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}->mapWithKeys(function ($item, $key) {
                return ['Showroom' => $item];
            });
            }
            elseif($constructible == 'standing')
            {
            ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}->mapWithKeys(function ($item, $key) {
                return [$key => $item];
            });
            }
        }            
        }


        $lotsDossiers = $lotsDossiers->map(function ($item1, $key1) use ($showroomsDossiers){
            foreach ($showroomsDossiers as $key => $value) {
                if ($key == $key1) {
                    $a = 0 ;
                    $a = ($item1 + $value) ;
                }
            }
            return $a ;            
        });

        $lotDossiers = $lotDossiers->merge($showroomDossiers);
        //$lotsD = collect($lotsDossiers],[$showroomsDossiers] ) ;

        //dd($lotsD) ;


        return view('finances.index',

            ['color' => [ 'green' ,'purple','blue' , 'red' , 'yellow','indigo', 'orange'], 
                'constructibles' => [
                'Lots' => 'lot',
                'Appartements'=>'appartement',
                'Bureaux' => 'bureau',
                'Magasins' =>'magasin',
                'Boxes' => 'box',
                'Standings' => 'standing'
                //'Showrooms' => 'showroom'
            ]
            ] +
            ['appartement' => $appartementDossiers] +
            ['Appartements' => $appartementsDossiers] +
                                    ['lot' => $lotDossiers] +
                                    ['Lots' => $lotsDossiers] +

                                    ['magasin' => $magasinDossiers] + 
                                    ['Magasins' => $magasinsDossiers] +

                                    ['box' => $boxDossiers] + 
                                    ['Boxes' => $boxsDossiers] +

                                    ['bureau' => $bureauDossiers] +
                                    ['Bureaux' => $bureausDossiers]+
                                    ['standing' => $standingDossiers] +
                                    ['Standings' => $standingsDossiers]                                    

        ) ;
    }

    public function export() 
    {
        return Excel::download(new FinancesExport, 'Récap-finances-DSD.xlsx');
    }

}
