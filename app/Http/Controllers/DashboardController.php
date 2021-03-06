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

    	$nombreVisites = \DB::select("SELECT YEAR (date) as an, MONTH(date) as mois , COUNT(*) as nombreVisites from visites group by MONTH(date), YEAR(date) Order by YEAR(date) asc, MONTH(date) asc Limit 7");

        $lotsAll = Produit::with('etiquette')
        					->with('constructible')
                            ->where('constructible_type','lot')
                            ->get();
        $reserved = $lotsAll->where('etiquette.label', 'Réservé')->count(); 
        $stocked = $lotsAll->where('etiquette.label', 'En stock')->count(); 
        $blocked = $lotsAll->count() - ($stocked + $reserved); 

        $dossiersAll = Dossier::with('produit')->with('client')->with('paiements')->paginate(15);

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

        ], $dossiersParType->all() + $produitsParType->all(),
    ) ;
    }
}
