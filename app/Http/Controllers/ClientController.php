<?php

namespace App\Http\Controllers;

use App\Http\Traits\PaginateTrait;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
        if (! Gate::allows('voir clients')) {
                abort(403);
        }         
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

           $clientsParPage = $this->paginate($clientsAll) ;
           $clientsParPage->withPath('/clients');
           $clientsParPage->withQueryString() ;

        return view('clients.index', [
            'clients'              => $clientsParPage,
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
        if (! Gate::allows('editer clients')) {
                abort(403);
        }         
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
        if (! Gate::allows('editer clients')) {
                abort(403);
        } 
        $request->validate([
            'nom'       => 'required|string|max:50',
            'prenom'    => 'required|string|max:50',
            'prenomAr'    => 'string|max:50|nullable',
            'nomAr'    => 'string|max:50|nullable',
            'adresseAr'    => 'string|nullable',

            'mobile'    => 'numeric|unique:clients,mobile',
            'cin'    => 'required|alpha_num|unique:clients,cin',
            'idProduit' => 'numeric|nullable',
            'adresse' => 'required|string',
            'cinPj' => 'required|max:5000|mimetypes:application/pdf,image/png,image/jpeg,image/tiff,image/gif',
        ]);

        $client = new Client() ;
        $client->nom    = strtoupper($request['nom']);
        $client->prenom = strtoupper($request['prenom']);
        $client->mobile = $request['mobile'];
        $client->cin = strtoupper($request['cin']);
        $client->adresse = strtoupper($request['adresse']);
        $client->nomAr    = strtoupper($request['nomAr']);
        $client->prenomAr = strtoupper($request['prenomAr']);        
        $client->adresseAr = strtoupper($request['adresseAr']);

        $client->activer = 1 ;

        if($request->hasFile('cinPj'))
        {
            $infoClient = $client->nom . '-' . $client->prenom . '-' .$client->cin;

            $pjName = str_replace('.', '',  $infoClient ) . '-' 

            . str_replace(' ', '-', date('Y-m-d-His')) ;

            $pjExtension = $request->file('cinPj')->extension() ;                 

            $pdfPath = $request->file('cinPj')
            ->storeAs('public/cin', $pjName . '.' . $pjExtension) ;

            $client->cinPj = 'cin/' . $pjName . '.' . $pjExtension ;
        }

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
        if (! Gate::allows('editer clients')) {
                abort(403);
        }         
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
        //dd($request) ;

        if (! Gate::allows('editer clients')) {
                abort(403);
        }         
        $request->validate([
            'cin'    => 'required|alpha_num|unique:clients,cin,' . $client->id,
            'nom'       => 'required|string|max:50',
            'prenom'    => 'required|string|max:50',
            'mobile'    => 'numeric|unique:clients,mobile,' . $client->id,
            'adresse' => 'required|string',

            'prenomAr'    => 'string|max:50|nullable',
            'nomAr'    => 'string|max:50|nullable',
            'adresseAr'    => 'string|nullable',    
            'cinPj' => 'sometimes|required|max:5000|mimetypes:application/pdf,image/png,image/jpeg,image/tiff,image/gif',        
        ]);

        $client->nom        = strtoupper($request['nom']);
        $client->prenom     = strtoupper($request['prenom']);
        $client->mobile     = $request['mobile'];
        $client->cin        = strtoupper($request['cin']);
        $client->adresse    = strtoupper($request['adresse']);

        $client->nomAr    = strtoupper($request['nomAr']);
        $client->prenomAr = strtoupper($request['prenomAr']);        
        $client->adresseAr = strtoupper($request['adresseAr']);

        $client->activer    = 1 ;

        if($request->hasFile('cinPj'))
        {
            if ($client->cinPj != null) {
                Storage::delete('public/' . $client->cinPj);
            }
            $infoClient = $client->nom . '-' . $client->prenom . '-' .$client->cin;

            $pjName = str_replace('.', '',  $infoClient ) . '-' 

            . str_replace(' ', '-', date('Y-m-d-His')) ;

            $pjExtension = $request->file('cinPj')->extension() ;                 

            $pdfPath = $request->file('cinPj')
            ->storeAs('public/cin', $pjName . '.' . $pjExtension) ;

            $client->cinPj = 'cin/' . $pjName . '.' . $pjExtension ;
        }
        else
        {
            if ($client->cinPj != null) {
                Storage::delete('public/' . $client->cinPj);
            }

            $client->cinPj = null ;
        }

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
        if (! Gate::allows('supprimer clients')) {
                abort(403);
        } 

        if ($client->cinPj != null) {
            Storage::delete('public/' . $client->cinPj);
        }

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
