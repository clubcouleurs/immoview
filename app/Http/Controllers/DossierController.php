<?php

namespace App\Http\Controllers;

use App\Http\Traits\PaginateTrait;
use App\Models\Client;
use App\Models\Dossier;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DossierController extends Controller
{
    use PaginateTrait ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $dossiersAll = Dossier::with('produit')->with('client')->with('paiements')->get();

        //recherche par taux de paiement
        if (isset($request['sign']) && $request['sign'] != '' ) {

            if(isset($request['tauxComparateur']) && $request['tauxComparateur'] != '-' ) {

            $tauxComparateur = $request['tauxComparateur'] ;
            $sign = $request['sign'] ;
            $dossiersAll = $dossiersAll->filter(function ($dossier) use ($sign, $tauxComparateur)  {
            $taux = $dossier->paiements->sum('montant') * 100 /
                            ($dossier->produit->Total) ;
                switch ($sign) {
                    case '>':
                    if ($taux > $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '<':
                    if ($taux < $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '=>':
                    if ($taux >= $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '<=':
                    if ($taux <= $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;                                                                        

                }

            });                
            }
        }

        //dd($dossiersAll) ;



        //dd($dossiersAll) ;

        //selectionner les lots 
        //$lotsAll = $lotsAll->whereNotNull('lot.id' ); 

        //$maxPrix = $lotsAll->max('prixM2Indicatif');
        //$minPrix = $lotsAll->min('prixM2Indicatif');  
        $numsDossier = [];

        //recherche par numéro des dossiers
        if (isset($request['num']) && $request['num'] != '' ) {
            $numsDossier = preg_split("/[\s,\.]+/", $request['num']);
            $numsDossier = array_map('trim', $numsDossier);
            $dossiersAll = $dossiersAll->whereIn('produit.constructible.num', $numsDossier);
        }

        //recherche par nom, prénom ou CIN client
        if (isset($request['client']) && $request['client'] != '' ) {
            $value = strtolower($request['client']) ;

            $dossiersAll = $dossiersAll->filter(function ($item) use ($value)  {
            $client = strtolower(trim($item->client->cin . ' ' . $item->client->nom . ' ' . $item->client->prenom . ' ' ));

                    if (strpos($client , $value) !== false) {
                        return true;
                    }
                        return false;
            });                

        }        

        //recherche par prix
        if (isset($request['minPrix']) && $request['minPrix'] != '' ) {
            $minPrix = intval($request['minPrix']) ;
        }

        //recherche par prix
        if (isset($request['maxPrix']) && $request['maxPrix'] != '' ) {
            $maxPrix = floatval($request['maxPrix']) ;
        }

        //$lotsAll = $lotsAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 

        //recherche par tranche
        if (isset($request['tranche']) && $request['tranche'] != '-' ) {
            $tr = $request['tranche'] ;
            $lotsAll = $lotsAll->where('lot.tranche_id', $tr); 
        }

        //recherche par commercial
        if (isset($request['user']) && $request['user'] != '-' ) {
            $user = $request['user'] ;
            $dossiersAll = $dossiersAll->where('user_id', $user); 
        }

        //recherche par nombre d'etages
        if (isset($request['nombreEtagesLot']) && $request['nombreEtagesLot'] != '-' ) {
            $et = $request['nombreEtagesLot'] ;
            $lotsAll = $lotsAll->where('lot.nombreEtagesLot', $et); 
        }  

        //recherche par type de lot
        if (isset($request['typeLot']) && $request['typeLot'] != '-' ) {
            $ty = $request['typeLot'] ;
            $lotsAll = $lotsAll->where('lot.typeLot', $ty);  
        }           

        //recherche par etat du lot
        if (isset($request['etatProduit']) && $request['etatProduit'] != '-' ) {
            $etat = $request['etatProduit'] ;
            $lotsAll = $lotsAll->where('etiquette_id', $etat);  
        }           

            //$total = 0 ;
           //$totalPaiements = $dossiersAll->map(function ($item, $key) use ($total) {
           //     return $total = $total + $item->lot->surfaceLot * $item->prixM2Definitif;
           // });



        return view('dossiers.index', [
            'dossiers'              => $this->paginate($dossiersAll),
            'totalDossier'          => $dossiersAll->count(),
            'clients'               =>   Client::all(),
            'users'                 => User::all(),
            'tranches'              => '' ,
            'valeurTotal'           => 1000, //$prixTotalLots->sum(),
            'SearchByTranche'       => '',//$request['tranche'] ,
            'SearchByUser'          => $request['user'] ,
            'SearchBySign'         => $request['sign'] ,
            'SearchByTauxComparateur'          => $request['tauxComparateur'] ,
            'SearchByType'          => '',//$request['typeLot'] ,
            'SearchByMin'           => '',//$request['minPrix'] ,
            'SearchByMax'           => '',//$request['maxPrix'] ,
            'SearchByNum'           => implode(',' , $numsDossier) ,
            'SearchByClient'        => $request['client'] ,


        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Produit $produit)
    {
        if ($produit->constructible_type == 'lot') {
            $dataRecap = 
            'Qui concerne le Lot N° ' . $produit->constructible->num . 
            ', d\'une surface totale de : ' . $produit->constructible->surface . 'm2' .
            '. Vendu au prix total de : ' . number_format($produit->total) . ' Dhs'.
            ', du type : ' . $produit->constructible->type . ', constructible en R+' . $produit->constructible->etage .
            '. Ce lot est sur le tranche ' . $produit->constructible->tranche_id ;

        }
        elseif (isset($produit->appartement)) {
            $dataRecap = 'appartement' ;
        }
        elseif (isset($produit->magasin)) {
            $dataRecap = 'magasin' ;
        }   
        elseif (isset($produit->bureau)) {
            $dataRecap = 'bureau' ;
        }
        elseif (isset($produit->box)) {
            $dataRecap = 'box' ;
        }        

        return view('dossiers.create', [
            'clients'       => Client::where('activer', '=' , 1)->get(),
            'produit'       => $produit,
            'dataRecap'     => $dataRecap

        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dossier = new Dossier([
        'num'              => $request['num'] ,    
        'date'              => $request['date'] ,
        'frais'             => $request['frais'] ,
        'detail'            => $request['detail'],
        'client_id'         => $request['client'],
        'produit_id'        => $request['produit'],
        'user_id'           => Auth::id(),
        ]) ;
        $dossier->save();
        $dossier->produit->etiquette_id = 3 ;
        $dossier->produit->update() ;
        return redirect()->action([DossierController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function show(Dossier $dossier)
    {

        return view('dossiers.show', [
            'dossier'              => $dossier,


            'clients'               =>   Client::all(),
            'users'                 => User::all(),
            'tranches'              => '' ,
            'valeurTotal'           => 1000, //$prixTotalLots->sum(),
            'SearchByTranche'       => '',//$request['tranche'] ,
            'SearchByUser'          => '',//$request['user'] ,
            'SearchBySign'         => '',//$request['sign'] ,
            'SearchByTauxComparateur'          => '',//$request['tauxComparateur'] ,
            'SearchByType'          => '',//$request['typeLot'] ,
            'SearchByMin'           => '',//$request['minPrix'] ,
            'SearchByMax'           => '',//$request['maxPrix'] ,
            'SearchByNum'           =>  '',//implode(',' , $numsDossier) ,
            'SearchByClient'        => '',//$request['client'] ,


        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function edit(Dossier $dossier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dossier $dossier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dossier $dossier)
    {
        //
    }
}
