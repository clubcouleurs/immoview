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

        //recherche par nom, prénom ou CIN client
        if (isset($request['client']) && $request['client'] != '' ) {
            $value = strtolower($request['client']) ;

            $clientsAll = $clientsAll->filter(function ($item) use ($value)  {
            $client = strtolower(trim($item->cin . ' ' . $item->nom . ' ' . $item->prenom . ' ' ));

                    if (strpos($client , $value) !== false) {
                        return true;
                    }
                        return false;
            });                

        } 


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
