<?php

namespace App\Http\Controllers;

use App\Exports\AppartementsExport;
use App\Http\Requests\ProduitRequest;
use App\Http\Traits\PaginateTrait;
use App\Models\Appartement;
use App\Models\Etiquette;
use App\Models\Immeuble;
use App\Models\Produit;
use App\Models\Tranche;
use App\Models\Voie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;


class AppartementController extends Controller
{
    use PaginateTrait ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $typeApp = "")
    {
        if (! Gate::allows('voir appartements') && ! Gate::allows('voir appartements standing')) {
                abort(403);
        }

        if (! Gate::allows('voir appartements')
            && Gate::allows('voir appartements standing')
            && $request['standing'] != 1
        ){
                abort(403);
        }        
        if(isset($request['standing']) && $request['standing'] == 1 )
        {
            $appartementsAll = Produit::with('constructible')
                                ->where('constructible_type','appartement')
                                ->whereHasMorph(
                                    'constructible',
                                                [Appartement::class],
                                                function (Builder $qu) 
                                            {
                                                $qu->where('type', 'Standing');

                                            }
                                )
                                ->with('etiquette')
                                ->withCount('voies')
                                ->orderByDesc('created_at')
                                ->get();            
        }
        else
        {
            $appartementsAll = Produit::with('constructible')
                                ->where('constructible_type','appartement')
                                ->whereHasMorph(
                                    'constructible',
                                                [Appartement::class],
                                                function (Builder $qu) 
                                            {
                                                $qu->where('type', 'Economique');

                                            }
                                )                                
                                ->with('etiquette')
                                ->withCount('voies')
                                ->orderByDesc('created_at')
                                ->get();
        }
        $appartementsAll = $appartementsAll->sortBy('constructible.num') ;
        $appartementsReserved = $appartementsAll->where('etiquette_id', 3)->count() ;
        $appartementsStocked = $appartementsAll->where('etiquette_id', 2)->count() ;
        $appartementsR = $appartementsAll->where('etiquette_id', 9)->count() ;
        $appartementsBlocked = $appartementsAll->whereNotIn('etiquette_id', [3,2,9])->count() ;

        //selectionner les appartements 
        //$appartementsAll = $appartementsAll->whereNotNull('appartement.id' ); 

        $maxPrix = $appartementsAll->max('prixM2Indicatif');
        $minPrix = $appartementsAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des appartement
        if (isset($request['numsappartement']) && $request['numsappartement'] != '' ) {
            $numsappartement = preg_split("/[\s,\.]+/", $request['numsappartement']);
            $numsappartement = array_map('trim', $numsappartement);
            $appartementsAll = $appartementsAll->whereIn('constructible.num', $numsappartement);
        }

        //recherche par prix
        if (isset($request['minPrix']) && $request['minPrix'] != '' ) {
            $minPrix = intval($request['minPrix']) ;
        }

        //recherche par prix
        if (isset($request['maxPrix']) && $request['maxPrix'] != '' ) {
            $maxPrix = floatval($request['maxPrix']) ;
            $appartementsAll = $appartementsAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 

        }



        //recherche par tranche
        if (isset($request['tranche']) && $request['tranche'] != '-' ) {
            $tr = $request['tranche'] ;

            $appartementsAll = $appartementsAll->filter(function ($item) use ($tr)  {
                // foreach ($item->constructible as $appartement) {
                // $clientSearch .= strtolower(trim($client->cin . ' ' . $client->nom . ' ' . $client->prenom . ' ' ));
                // }

                    if ($item->constructible->immeuble->tranche_id == $tr) {
                        return true;
                    }
                        return false;
            });

            //$appartementsAll = $appartementsAll->where('constructible.immeuble_id', $tr); 
        }

        //recherche par immeuble
        if (isset($request['immeuble']) && $request['immeuble'] != '-' ) {
            $imm = $request['immeuble'] ;
            $appartementsAll = $appartementsAll->where('constructible.immeuble_id', $imm); 
        }

        //recherche par nombre de façades
        if (isset($request['nombreFacadesappartement']) && $request['nombreFacadesappartement'] != '-' ) {
            $fa = $request['nombreFacadesappartement'] ;
            $appartementsAll = $appartementsAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($request['etage']) && $request['etage'] != '-' ) {
            $et = $request['etage'] ;
            $appartementsAll = $appartementsAll->where('constructible.etage', $et); 
        }  

        //recherche par type de appartement
        if (isset($request['type']) && $request['type'] != '-' ) {
            $ty = $request['type'] ;
            $appartementsAll = $appartementsAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du appartement
        if (isset($request['etatProduit']) && $request['etatProduit'] != '-' ) {
            $etat = $request['etatProduit'] ;
            $appartementsAll = $appartementsAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalappartements = $appartementsAll->map(function ($item, $key) use ($total) {
               //return $item->constructible->surfaceTerrasse;
               return $total = $total + $item->totalIndicatif;
        });

           $appartementsParPage = $this->paginate($appartementsAll) ;
           $appartementsParPage->withPath('/appartements');
           $appartementsParPage->withQueryString() ;

           $urlWithQueryString = $request->fullUrl();
           $urlWithQueryString = substr($urlWithQueryString, strlen($request->url())) ;           

        return view('appartements.index', [
            'appartements'              => $appartementsParPage ,
            'totalappartements'         => $appartementsAll->count(),
            'immeubles'                 =>Immeuble::all(),
            'etiquettes'                =>Etiquette::all(),
            'tranches'                  =>Tranche::all(),
            'valeurTotal'               => $prixTotalappartements->sum(),

            'appartementsReserved'      => $appartementsReserved,
            'appartementsBlocked'       => $appartementsBlocked,
            'appartementsStocked'       => $appartementsStocked,
            'appartementsR'            => $appartementsR,

            'SearchByTr'           => $request['tranche'] ,

            'SearchByImm'           => $request['immeuble'] ,
            'SearchByFacade'        => $request['nombreFacadesappartement'] ,
            'SearchByEtage'     => $request['etage'] ,
            'SearchByEtat'     => $request['etatProduit'] ,
            'SearchByType'     => $request['type'] ,
            'SearchByMin'     => $request['minPrix'] ,
            'SearchByMax'     => $request['maxPrix'] ,
            'SearchByNum' => $request['numsappartement'] ,
            'standing' => $request['standing'] ,
            'urlWithQueryString' => $urlWithQueryString

        ]);
    }

    public function export(Request $request) 
    {
        return Excel::download(new AppartementsExport($request), 'Etats-Appartements-DSD.xlsx');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('editer appartements') && ! Gate::allows('editer appartements standing')) {
                abort(403);
        }          
        return view('appartements.create', [
            'voies' => Voie::all(),
            'immeubles' => Immeuble::all(),
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
        if (! Gate::allows('editer appartements') && ! Gate::allows('editer appartements standing')) {
                abort(403);
        }         
        $immeuble = Immeuble::findOrFail($request['immeuble']) ;
        $etiquette = Etiquette::findOrFail($request['etatProduit']) ;


        $Appartement = new Appartement() ;
        $Appartement->num               = $request['numApp'];
        $Appartement->surfaceApp        = $request['surfaceApp'];
        $Appartement->surfaceTerrasse   = $request['surfaceTerrasse'];
        $Appartement->type              = $request['type'];
        $Appartement->etage             = $request['etage'];
        $Appartement->description       = $request['descriptionApp'];

        //ajout du 03/03/22 l'app est composé de ces pièces ...
        $Appartement->chambres       = $request['chambres'];
        $Appartement->cuisines       = $request['cuisines'];
        $Appartement->sdbs       = $request['sdbs'];
        $Appartement->toilettes       = $request['toilettes'];
        $Appartement->extra       = $request['extra'];

        $Appartement->save();
        $immeuble->appartements()->save($Appartement) ;

        $produit = new Produit([
        'etatProduit'       => $request['etatProduit'] ,
        'prixM2Indicatif'    => $request['prixM2Indicatif'] ,
        'prixM2Definitif'   => $request['prixM2Definitif'],
        'etiquette_id'   => $etiquette->id,

        ]) ;
        $Appartement->produit()->save($produit) ;
        //$etiquette->produits()->save($produit) ;
        $produit->voies()->attach($request['voies']) ;


        return redirect()->action([AppartementController::class, 'index'])
        ->with('message','Appartement ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function show(Appartement $appartement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function edit(Appartement $appartement)
    {
        if (! Gate::allows('editer appartements') && ! Gate::allows('editer appartements standing')) {
                abort(403);
        }           
        return view('appartements.edit', [
            'appartement'           => $appartement, 
            'voies'         => Voie::all(), 
            'etiquettes'    => Etiquette::whereNotIn('label', ['Vendu'])->get(),
            'immeubles'      => Immeuble::all()]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function update(ProduitRequest $request, Appartement $appartement)
    {
        if (! Gate::allows('editer appartements') && ! Gate::allows('editer appartements standing')) {
                abort(403);
        }          
        if ($appartement->produit->dossier == null) {
            
            $appartement->produit->etiquette_id = $request['etatProduit']; 
            
        }
        // controller si l'utilisateur a le droit de modifier le prix indicatif
        if (Gate::allows('editer prix produits'))
        {
            $appartement->produit->prixM2Indicatif  = $request['prixM2Indicatif'];
        }

        $appartement->produit->prixM2Definitif  = $request['prixM2Definitif'];
        $appartement->produit->update() ;
        $appartement->produit->voies()->detach() ; 
        $appartement->produit->voies()->attach($request['voies']) ;


        $immeuble = Immeuble::findOrFail($request['immeuble']) ;

        $appartement->num               = $request['numApp'];
        $appartement->surfaceApp        = $request['surfaceApp'];
        $appartement->surfaceTerrasse   = $request['surfaceTerrasse'];
        $appartement->type              = $request['type'];
        $appartement->etage             = $request['etage'];
        $appartement->description       = $request['description'];
        
        //ajout du 03/03/22 l'app est composé de ces pièces ...
        $appartement->chambres       = $request['chambres'];
        $appartement->cuisines       = $request['cuisines'];
        $appartement->sdbs       = $request['sdbs'];
        $appartement->toilettes       = $request['toilettes'];
        $appartement->extra       = $request['extra'];

        $appartement->update();

        $immeuble->appartements()->save($appartement) ;
        if ($appartement->type == 'Standing') {
            $st = 1 ;
        }else
        {
            $st = 0 ;
        }
        return redirect()->action([AppartementController::class,'index'] , ['standing' => $st ])
        ->with('message','Appartement modifié !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appartement $appartement)
    {
        if (! Gate::allows('supprimer appartements') && ! Gate::allows('editer appartements standing')) {
                abort(403);
        }     

        if ($appartement->produit->dossier != Null ) {
            return redirect()->back()
            ->with('error','Supression impossible. Déjà vendu.');
        }

        $appartement->produit->voies()->detach() ;       
        $appartement->immeuble()->dissociate() ;
        $appartement->delete() ;
        $appartement->produit()->delete() ;
        return redirect()->action([AppartementController::class, 'index'])
        ->with('message','Appartement supprimé !');
    }
}
