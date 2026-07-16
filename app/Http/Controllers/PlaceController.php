<?php

namespace App\Http\Controllers;

use App\Exports\placesExport;
use App\Http\Requests\ProduitRequest;
use App\Http\Traits\PaginateTrait;
use App\Models\place;
use App\Models\Client;
use App\Models\Etiquette;
use App\Models\Immeuble;
use App\Models\Produit;
use App\Models\Tranche;
use App\Models\Type;
use App\Models\Voie;
use App\Rules\oneLotPerProjet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;


class PlaceController extends Controller
{
    use PaginateTrait ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $typeApp = "")
    {


        if (! Gate::allows('voir places') ) {
                abort(403);
        }

        if (! Gate::allows('voir places')){
                abort(403);
        }
            $placesAll = Produit::with('constructible')
                                ->where('constructible_type','place')                                
                                ->with('etiquette')
                                ->withCount('voies')
                                ->orderByDesc('created_at')
                                ->get();

        $placesAll = $placesAll->sortBy('constructible.num') ;
        $placesReserved = $placesAll->where('etiquette_id', 3)->count() ;
        $placesStocked = $placesAll->where('etiquette_id', 2)->count() ;
        $placesR = $placesAll->where('etiquette_id', 9)->count() ;
        $placesBlocked = $placesAll->whereNotIn('etiquette_id', [3,2,9])->count() ;

        //selectionner les places 
        //$placesAll = $placesAll->whereNotNull('place.id' ); 

        $maxPrix = $placesAll->max('prixM2Indicatif');
        $minPrix = $placesAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des place
        if (isset($request['numsplace']) && $request['numsplace'] != '' ) {
            $numsplace = preg_split("/[\s,\.]+/", $request['numsplace']);
            $numsplace = array_map('trim', $numsplace);
            $placesAll = $placesAll->whereIn('constructible.num', $numsplace);
        }

        //recherche par prix
        if (isset($request['minPrix']) && $request['minPrix'] != '' ) {
            $minPrix = intval($request['minPrix']) ;
        }

        //recherche par prix
        if (isset($request['maxPrix']) && $request['maxPrix'] != '' ) {
            $maxPrix = floatval($request['maxPrix']) ;
            $placesAll = $placesAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 

        }



        //recherche par tranche
        if (isset($request['tranche']) && $request['tranche'] != '-' ) {
            $tr = $request['tranche'] ;

            $placesAll = $placesAll->filter(function ($item) use ($tr)  {
                // foreach ($item->constructible as $place) {
                // $clientSearch .= strtolower(trim($client->cin . ' ' . $client->nom . ' ' . $client->prenom . ' ' ));
                // }

                    if ($item->constructible->immeuble->tranche_id == $tr) {
                        return true;
                    }
                        return false;
            });

            //$placesAll = $placesAll->where('constructible.immeuble_id', $tr); 
        }

        //recherche par immeuble
        if (isset($request['immeuble']) && $request['immeuble'] != '-' ) {
            $imm = $request['immeuble'] ;
            $placesAll = $placesAll->where('constructible.immeuble_id', $imm); 
        }

        //recherche par nombre de façades
        if (isset($request['nombreFacadesplace']) && $request['nombreFacadesplace'] != '-' ) {
            $fa = $request['nombreFacadesplace'] ;
            $placesAll = $placesAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($request['etage']) && $request['etage'] != '-' ) {
            $et = $request['etage'] ;
            $placesAll = $placesAll->where('constructible.etage', $et); 
        }  

        //recherche par type de place
        if (isset($request['type']) && $request['type'] != '-' ) {
            $ty = $request['type'] ;
            $placesAll = $placesAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du place
        if (isset($request['etatProduit']) && $request['etatProduit'] != '-' ) {
            $etat = $request['etatProduit'] ;
            $placesAll = $placesAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalplaces = $placesAll->map(function ($item, $key) use ($total) {
               //return $item->constructible->surfaceTerrasse;
               return $total = $total + $item->totalIndicatif;
        });

           $placesParPage = $this->paginate($placesAll) ;
           $placesParPage->withPath('/places');
           $placesParPage->withQueryString() ;

           $urlWithQueryString = $request->fullUrl();
           $urlWithQueryString = substr($urlWithQueryString, strlen($request->url())) ;           

        return view('places.index', [
            'types' => Type::distinct()->pluck('type'),
            'places'              => $placesParPage ,
            'totalplaces'         => $placesAll->count(),
            'immeubles' => Immeuble::with('tranche')
                                ->whereHas('tranche', function (Builder $query) {
                                    $query->where('projet_id', session('projet_id'));
                                })  
                                ->get(),
            'etiquettes'                =>Etiquette::all(),
            'tranches' => Tranche::where('projet_id' , session('projet_id'))->orderBy('num')->get(),

            'valeurTotal'               => $prixTotalplaces->sum(),

            'placesReserved'      => $placesReserved,
            'placesBlocked'       => $placesBlocked,
            'placesStocked'       => $placesStocked,
            'placesR'            => $placesR,

            'SearchByTr'           => $request['tranche'] ,

            'SearchByImm'           => $request['immeuble'] ,
            'SearchByFacade'        => $request['nombreFacadesplace'] ,
            'SearchByEtage'     => $request['etage'] ,
            'SearchByEtat'     => $request['etatProduit'] ,
            'SearchByType'     => $request['type'] ,
            'SearchByMin'     => $request['minPrix'] ,
            'SearchByMax'     => $request['maxPrix'] ,
            'SearchByNum' => $request['numsplace'] ,
            'standing' => $request['standing'] ,
            'urlWithQueryString' => $urlWithQueryString

        ]);
    }

    public function export(Request $request) 
    {
        return Excel::download(new placesExport($request), 'Etats-places.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('editer places') ) {
                abort(403);
        }          
        return view('places.create', [
            // 'voies' => Voie::where('projet_id' , session('projet_id'))->orderBy('id')->get(),
            'immeubles' => Immeuble::whereHas('tranche')->get(),
            'etiquettes' => Etiquette::whereNotIn('label', ['Vendu'])->get(),
        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProduitRequest $request)
    {
        if (! Gate::allows('editer places')) {
                abort(403);
        }         
            $request->validate(
                [
                    'num' => [
                    'required',
                    new oneLotPerProjet('','places.num', 'places', 'place'),
                    ],
                ]
            );        
        $immeuble = Immeuble::findOrFail($request['immeuble']) ;
        $etiquette = Etiquette::findOrFail($request['etatProduit']) ;
        $place = new place() ;
        $place->num               = $request['num'];
        $place->surface        = $request['surface'];
        $place->etage             = $request['etage'];
        $place->description       = $request['descriptionApp'];

        $place->save();
        $immeuble->places()->save($place) ;

        $produit = new Produit([
        'etatProduit'       => $request['etatProduit'] ,
        'prixM2Indicatif'   => $request['prixM2Indicatif'] ,
        'prixM2Definitif'   => $request['prixM2Definitif'],
        'etiquette_id'      => $etiquette->id,
        ]) ;
        $place->produit()->save($produit) ;
        //$etiquette->produits()->save($produit) ;
        $produit->voies()->attach($request['voies']) ;


        return redirect()->action([PlaceController::class, 'index'])
        ->with('message','place ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(place $place)
    {
        if (! Gate::allows('editer places') ) {
                abort(403);
        }           
        return view('places.edit', [
            'place'           => $place, 
            'etiquettes'    => Etiquette::whereNotIn('label', ['Vendu'])->get(),
            'immeubles'      => Immeuble::whereHas('tranche')->get(),

        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(ProduitRequest $request, place $place)
    {
        if (! Gate::allows('editer places') ) {
                abort(403);
        }          
        if ($place->produit->dossier == null) {
            
            $place->produit->etiquette_id = $request['etatProduit']; 
            
        }
        // controller si l'utilisateur a le droit de modifier le prix indicatif
        if (Gate::allows('editer prix produits'))
        {
            $place->produit->prixM2Indicatif  = $request['prixM2Indicatif'];
        }

        $place->produit->prixM2Definitif  = $request['prixM2Definitif'];
        $place->produit->update() ;
        $place->produit->voies()->detach() ; 
        $place->produit->voies()->attach($request['voies']) ;


        $immeuble = Immeuble::findOrFail($request['immeuble']) ;

        $place->num               = $request['num'];
        $place->surface        = $request['surface'];
        $place->etage             = $request['etage'];
        $place->description       = $request['description'];
        

        $place->update();

        $immeuble->places()->save($place) ;

        return redirect()->action([PlaceController::class,'index'])
        ->with('message','place modifié !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(place $place)
    {
        if (! Gate::allows('supprimer places') ) {
                abort(403);
        }     

        if ($place->produit->dossier != Null ) {
            return redirect()->back()
            ->with('error','Supression impossible. Déjà vendu.');
        }

        $place->immeuble()->dissociate() ;
        $place->delete() ;
        $place->produit()->delete() ;
        return redirect()->action([PlaceController::class, 'index'])
        ->with('message','place supprimé !');
    }
}
