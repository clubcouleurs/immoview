<?php

namespace App\Http\Controllers;

use App\Http\Traits\PaginateTrait;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use PaginateTrait ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activer = (isset($request['activer'])) ? $request['activer'] : 1 ;

        $clientsAll = Client::with('dossiers')
                            ->where('activer', '=', $activer )
                            ->orderby('created_at', 'desc')
                            ->get();

        //$lotsReserved = $lotsAll->where('etiquette_id', 3)->count() ;
        //$lotsStocked = $lotsAll->where('etiquette_id', 2)->count() ;
        //$lotsBlocked = $lotsAll->whereNotIn('etiquette_id', [3,2])->count() ;                            
        //selectionner les lots 
        //$lotsAll = $lotsAll->whereNotNull('lot.id' ); 
/*
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
                return $total = $total + $item->totalIndicatif;
        });*/



        return view('clients.index', [
            'clients'              => $this->paginate($clientsAll),
            'totalClients'         => $clientsAll->count(),
            'activer'          => $activer,
            'SearchByClient'   => '', // $request['tranche'] ,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create') ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//dd($request['idProduit']) ;
        $request->validate([
            'nom'       => 'required|string',
            'prenom'    => 'required|string',
            'mobile'    => 'required|numeric|unique:clients,mobile',
            'cin'    => 'required|alpha_num|unique:clients,cin',
            'idProduit' => 'numeric|nullable',
            'adresse' => 'required|string',
        ]);

        $client = new Client() ;
        $client->nom    = $request['nom'];
        $client->prenom = $request['prenom'];
        $client->mobile = $request['mobile'];
        $client->cin = $request['cin'];
        $client->adresse = $request['adresse'];

        $client->activer = 1 ;
        $client->save();

        if(isset($request['idProduit']) && $request['idProduit'] != null)
        {
            $id = $request['idProduit'] ;
            return redirect('/produits/'. $id . '/clients/' . $client->id . '/dossiers/create')
            ->with('message','Fiche client créée, merci de remplir le dossier') ;
        }

        return redirect()->action([ClientController::class, 'index'])
            ->with('message','Fiche client créée') ;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit', ['client' => $client]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'cin'    => 'required|alpha_num|unique:clients,cin,' . $client->id,
            'nom'       => 'required|string',
            'prenom'    => 'required|string',
            'mobile'    => 'required|numeric|unique:clients,mobile,' . $client->id,
            'adresse' => 'required|string',
        ]);

        $client->nom        = $request['nom'];
        $client->prenom     = $request['prenom'];
        $client->mobile     = $request['mobile'];
        $client->cin        = $request['cin'];
        $client->adresse    = $request['adresse'];
        $client->activer    = 1 ;
        $client->update();

        return redirect()->action([ClientController::class, 'index'])
            ->with('message','Fiche client modifiée') ;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if (!$client->dossiers->isEmpty()) {
            return redirect()->action([ClientController::class, 'index'])
            ->with('error','Impossible de supprimer ce client, il a un dossier');
        }

        $client->delete() ;

        if ($client->activer) {
            return redirect()->action([ClientController::class, 'index'])
                    ->with('message', 'Fiche client supprimée') ;
        }
            return redirect()->route('prospectsRoute', ['activer' => 0 ])
                    ->with('message', 'Fiche prospect supprimée');

            

    }
}
