<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dossier;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Projet;
use App\Models\User;
use App\Models\Visite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;

class DashboardController extends Controller
{
    public function index(Projet $projet)
    {
        $inflector = InflectorFactory::createForLanguage(Language::FRENCH)->build();

        $projet_id = session('projet_id');

        if($projet->id == null && $projet_id == null){
            $projet = Projet::where('default' , true)->limit(1)->first() ;
        }
        if($projet_id != null && $projet->id == null)
        {
            $projet = Projet::where('id' , $projet_id)->limit(1)->first() ;
        }
        session(['projet_id' => $projet->id]);
        session(['entreprise_id' => $projet->entreprise->id]);

        session(['projetConstructibles' => $projet->type_constructible]);

        
    	$mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'September', 'October', 'November','Décembre'] ;

    	$nombreVisites = \DB::select("
                    SELECT * FROM (
                    SELECT YEAR (visites.date) as an, MONTH(visites.date) as mois , COUNT(*) as nombreVisites
                    from visites
                        LEFT JOIN projets
                        ON visites.projet_id = projets.id
                        WHERE projets.id = ?                    
                    group by MONTH(visites.date), YEAR(visites.date)
                    Order by YEAR(visites.date) desc, MONTH(visites.date) desc
                    limit 7
                    ) as sub
                    ORDER BY an asc, mois asc            
                    ",[$projet_id]);

        $nombreVentes = \DB::select("
SELECT an, mois,
    max(case when (constructible_type='lot') then nombreVentes else 0 end) as 'lot',
    max(case when (constructible_type='magasin') then nombreVentes else 0 end) as 'magasin',
    max(case when (constructible_type='appartement') then nombreVentes else 0 end) as 'appartement',
    max(case when (constructible_type='bureau') then nombreVentes else 0 end) as 'bureau',
    max(case when (constructible_type='place') then nombreVentes else 0 end) as 'place'
FROM
(
    SELECT produits.constructible_type as constructible_type, YEAR (dossiers.date) as an, MONTH(dossiers.date) as mois , COUNT(*) as nombreVentes
    from dossiers
    LEFT JOIN produits
    ON dossiers.produit_id = produits.id
    LEFT JOIN projets
    ON produits.projet_id = projets.id
    WHERE produits.projet_id = ?
    group by MONTH(dossiers.date), YEAR(dossiers.date), produits.constructible_type
    Order by YEAR(dossiers.date) desc, MONTH(dossiers.date) desc
    Limit 7
    ) AS T
    GROUP BY an, mois
    Limit 7" , [$projet_id]);


        $commerciaux = User::get()->pluck('name') ;
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
        // $performanceCommercial = \DB::select("
        //         SELECT an, mois," .
        //         $maxStatement
        //         .
        //         "FROM
        //         (SELECT u.name as Commercial, YEAR (t1.date) as an, MONTH(t1.date) as mois , COUNT(*) as nbrVentes 
        // from dossiers as t1
        // LEFT JOIN users as u
        // ON t1.user_id = u.id
        // join
        // (SELECT YEAR (dossiers.date) as an, MONTH(dossiers.date) as mois
        // from dossiers
        // group by YEAR (dossiers.date) ,MONTH(dossiers.date)
        // Order by YEAR (dossiers.date) desc, MONTH(dossiers.date) desc
        // limit 7
        // ) as dt
        // on dt.an=YEAR(t1.date) and dt.mois=MONTH(t1.date)
        // Group by MONTH(t1.date), YEAR(t1.date), u.name
        // Order by YEAR(t1.date) desc, MONTH(t1.date) desc
        // ) AS tt
        // GROUP BY an, mois
            
        //     ");
        
// 1. Récupérer les données brutes
$data = DB::table('dossiers')
    ->join('produits', 'dossiers.produit_id', '=', 'produits.id')
    ->join('users', 'dossiers.user_id', '=', 'users.id') // Remplacez user_id par votre clé étrangère
    ->select(
        DB::raw('YEAR(dossiers.date) as an'),
        DB::raw('MONTH(dossiers.date) as mois'),
        'users.name as user_name',
        DB::raw('COUNT(*) as total')
    )
    ->where('produits.projet_id', $projet_id)
    ->where('dossiers.date', '>=', Carbon::now()->subMonths(7)->startOfMonth())
    ->groupBy('an', 'mois', 'user_name')
    ->orderBy('an', 'desc')
    ->orderBy('mois', 'desc')
    ->get();

// Récupérer la liste des noms de tous les commerciaux du projet au préalable
$nomsCommerciaux = $data->pluck('user_name')->unique();

$performanceCommercial = $data->groupBy(function($item) {
    return $item->an . '-' . $item->mois;
})->map(function ($group) use ($nomsCommerciaux) {
    $first = $group->first();
    
    // 1. Initialiser l'objet avec an, mois et tous les users à 0
    $result = [
        'an' => $first->an,
        'mois' => $first->mois,
    ];
    foreach ($nomsCommerciaux as $nom) {
        $result[$nom] = 0;
    }

    // 2. Remplir avec les vraies valeurs
    foreach ($group as $row) {
        $result[$row->user_name] = $row->total;
    }

    return (object) $result;
})->values()->take(7)->toArray();


$nombreVentesParMois = \DB::select("
    SELECT * FROM (
        SELECT 
            YEAR(dossiers.date) as an, 
            MONTH(dossiers.date) as mois, 
            COUNT(*) as nombreVentes
        FROM dossiers
        LEFT JOIN produits ON dossiers.produit_id = produits.id
        LEFT JOIN projets ON produits.projet_id = projets.id
        WHERE projets.id = ?
        GROUP BY YEAR(dossiers.date), MONTH(dossiers.date)
        ORDER BY an DESC, mois DESC
        LIMIT 7
        ) as sub
        ORDER BY an ASC, mois ASC
    ", [$projet_id]);



        // pour compter les taux d'avances 30%
        $dossiers = Projet::getAllDossiersOfThisProjet($projet->id);

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


        // adding project update 26/08/23
        //new
        $produitsParType = Produit::produitsParTypeParProjet($projet)->mapWithKeys(function ($item)  use ($inflector){
            return [$inflector->pluralize($item->constructible_type) => $item->nombre];
        });        

        $dossiersParType = Dossier::dossiersParType($projet->id)->mapWithKeys(function ($item){
            return [$item->constructible_type => $item->nombre];
        });

//dd(Projet::getFinancesOfThisProjet($projet->id)->all());
        //dd($performanceCommercial) ;
        // dd($commerciaux) ;

        return view('dashboard',[
            'paiementsDueNbr' => Paiement::getNbrPaiementsDueToday($projet->id, [0,2], 0),
            'paiementsUnpaidNbr' => Paiement::getNbrPaiementsDueToday($projet->id, 2 ),
            'paiementsDueUntilNbr' => Paiement::getNbrPaiementsDueUntilToday($projet->id, [0,2], Carbon::now()->toDateString()),

            'dossiersToday' => Dossier::getDossierArelancerToday($projet->id),
            'interets'      => Visite::interets(),
            'tauxConversion' => Client::tauxConversion() . ' %', 
            'projets' => Projet::all(),
            'today' => Carbon::now()->toDateString(),

            //'valeurTotalLots' => $prixTotalLots->sum(),
            // 'valeurTotalAppartements' => $prixTotalappartements->sum(),
            // 'valeurTotalBureaux' => $prixTotalbureaux->sum(),
            //'valeurTotalMagasins' => $prixTotalmagasins->sum(),
            //'valeurTotalplaces' => $prixTotalplaces->sum(),
            'dossiers' => Dossier::getAllDossiersProjet($projet->id),

	        'nombreVisites' => $nombreVisites,
            'performanceCommercial' => $performanceCommercial ,
            'perfKeys' => array_keys(json_decode(json_encode($performanceCommercial), true)),
            'commerciaux' => $commerciaux ,
	        'mois' => $mois,

            'dossiersUnder30' => $dossiersUnder30->count(),
            'dossiersOver30' => $dossiersOver30->count(),
            'dossiersUnder20' => $dossiersUnder20->count(),
            'dossiersUnder30In2020' => $dossiersUnder30In2020->count(),
            'nombreVentes' => $nombreVentes,
            'nombreVentesParMois' => $nombreVentesParMois,
            'totalVisites'  => Visite::all(),
            'visitesDay'    => Visite::visitesDay()[1],
            'visitesMonth'  => Visite::visitesMonth()[1],
            'visitesYear'   => Visite::visitesYear()[1],
            'visitesWeek'   => Visite::visitesWeek()[1],

            'appelsDay'    => Visite::visitesDay()[0],
            'appelsMonth'  => Visite::visitesMonth()[0],
            'appelsYear'   => Visite::visitesYear()[0],
            'appelsWeek'   => Visite::visitesWeek()[0],
            'dossiersLitige' => Dossier::litige() ,
                        
        ],      Produit::getEtatProduitsProjet($projet, $inflector)->all()
            +   $dossiersParType->all()
            +   $produitsParType->all()
            +   Projet::getFinancesOfThisProjet($projet->id)->all(),
    ) ;
    }
}


