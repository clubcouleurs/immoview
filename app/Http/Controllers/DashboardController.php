<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Dossier;
use App\Models\Produit;
use App\Models\Visite;
use Carbon\Carbon;
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

        $countProduits = \DB::select("SELECT COUNT(constructible_type) as nbr from produits
GROUP BY constructible_type");  
//dd($countProduits[0])  ;


// end of 




        return view('dashboard', [
			'reserved' 	=> $reserved, 
	        'stocked' 	=> $stocked,
	        'blocked' 	=> $blocked,
	        'dossiers' => $dossiersAll,
	        'nombreVisites' => $nombreVisites,
	        'mois' => $mois,
        ]);
    }
}
