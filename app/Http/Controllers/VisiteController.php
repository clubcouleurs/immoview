<?php

namespace App\Http\Controllers;

use App\Http\Traits\PaginateTrait;
use App\Models\Client;
use App\Models\Visite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisiteController extends Controller
{
    use PaginateTrait ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitesAll = Visite::with('client')
                            ->with('user')
                            ->get();
        /*                            
        //selectionner les lots 
        //$lotsAll = $lotsAll->whereNotNull('lot.id' ); 

        $maxPrix = $lotsAll->max('prixM2Indicatif');
        $minPrix = $lotsAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des lot
        if (isset($request['numsLot']) && $request['numsLot'] != '' ) {
            $numsLot = preg_split("/[\s,\.]+/", $request['numsLot']);
            $numsLot = array_map('trim', $numsLot);
            $lotsAll = $lotsAll->whereIn('constructible.num', $numsLot);
        }

        //recherche par prix
        if (isset($request['minPrix']) && $request['minPrix'] != '' ) {
            $minPrix = intval($request['minPrix']) ;
        }

        //recherche par prix
        if (isset($request['maxPrix']) && $request['maxPrix'] != '' ) {
            $maxPrix = floatval($request['maxPrix']) ;
        }

        $lotsAll = $lotsAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 

        //recherche par tranche
        if (isset($request['tranche']) && $request['tranche'] != '-' ) {
            $tr = $request['tranche'] ;
            $lotsAll = $lotsAll->where('constructible.tranche_id', $tr); 
        }

        //recherche par nombre de façades
        if (isset($request['nombreFacadesLot']) && $request['nombreFacadesLot'] != '-' ) {
            $fa = $request['nombreFacadesLot'] ;
            $lotsAll = $lotsAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($request['etage']) && $request['etage'] != '-' ) {
            $et = $request['etage'] ;
            $lotsAll = $lotsAll->where('constructible.etage', $et); 
        }  

        //recherche par type de lot
        if (isset($request['type']) && $request['type'] != '-' ) {
            $ty = $request['type'] ;
            $lotsAll = $lotsAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du lot
        if (isset($request['etatProduit']) && $request['etatProduit'] != '-' ) {
            $etat = $request['etatProduit'] ;
            $lotsAll = $lotsAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalLots = $lotsAll->map(function ($item, $key) use ($total) {
        return $total = $total + $item->constructible->surface * $item->prixM2Definitif;
        });

        */

        return view('visites.index', [
            'visites'              => $this->paginate($visitesAll),
            'totalVisites' => Visite::all(),
            'visitesDay'              => Visite::visitesDay(),
            'visitesMonth'              => Visite::visitesMonth(),
            'visitesYear'              => Visite::visitesYear(),
            'visitesWeek'              => Visite::visitesWeek(),

            'totalLots'         => $visitesAll->count(),
            'tranches'          => '' , //Tranche::all(),
            'etiquettes'        =>'' , //Etiquette::all(),
            'valeurTotal'       => 0 , //$prixTotalLots->sum(),
            'SearchByTranche'   => '' , //$request['tranche'] ,
            'SearchByFacade'    => '' , //$request['nombreFacadesLot'] ,
            'SearchByEtage'     => '' , //$request['etage'] ,
            'SearchByEtat'     => '' , //$request['etatProduit'] ,
            'SearchByType'     => '' , //$request['type'] ,
            'SearchByMin'     => '' , //$request['minPrix'] ,
            'SearchByMax'     => '' , //$request['maxPrix'] ,
            'SearchByNum' => '' , //$request['numsLot'] ,

        ]);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('visites.create', [

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
        //this is for updating clients
        //$mobile = (isset($this->lot->id)) ? $this->lot->id : Null ;
        //'mobile'   => 'required|numeric|unique:clients,mobile'.$mobile,

        $request->validate([
            'nom'      => 'required|string',
            'prenom'      => 'required|string',
            'mobile'   => 'required|numeric|unique:clients,mobile',
            'date'  => 'required|date',
            'interet' => 'required|string',
            'detail' => 'required|string'
        ]);

        $client = new Client() ;
        $client->nom                = $request['nom'];
        $client->prenom            = $request['prenom'];
        $client->mobile       = $request['mobile'];
        $client->save();

        $visite = new Visite([
        'date'       => $request['date'] ,
        'interet'    => $request['interet'] ,
        'detail'   => $request['detail'],
        'remarqueClient'   => $request['remarqueClient'],

        ]) ;
        $visite->client()->associate($client) ;
        $visite->user()->associate(Auth::user()) ;

        $visite->save() ;


        return redirect()->action([VisiteController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function show(Visite $visite)
    {
        return view('visites.show', ['visite' => $visite]) ;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function edit(Visite $visite)
    {
        return view('visites.edit', ['visite' => $visite]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visite $visite)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visite $visite)
    {
        $visite->delete() ;
        return redirect()->action([VisiteController::class, 'index']);

    }
}
