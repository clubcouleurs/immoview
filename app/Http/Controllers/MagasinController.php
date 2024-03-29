<?php

namespace App\Http\Controllers;

use App\Exports\MagasinsExport;
use App\Http\Controllers\MagasinController;
use App\Http\Requests\ProduitRequest;
use App\Http\Traits\PaginateTrait;
use App\Models\Etiquette;
use App\Models\Immeuble;
use App\Models\Magasin;
use App\Models\Produit;
use App\Models\Tranche;
use App\Models\Voie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class MagasinController extends Controller
{
    use PaginateTrait ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! Gate::allows('voir magasins')) {
                abort(403);
        }        
        $magasinsAll = Produit::with('constructible')
                            ->where('constructible_type','magasin')
                            ->with('etiquette')
                            ->withCount('voies')
                            ->orderByDesc('created_at')
                            ->get();
        $magasinsAll = $magasinsAll->sortBy('constructible.id') ;
                            
        $magasinsReserved = $magasinsAll->where('etiquette_id', 3)->count() ;
        $magasinsStocked = $magasinsAll->where('etiquette_id', 2)->count() ;
        $magasinsBlocked = $magasinsAll->whereNotIn('etiquette_id', [3,2,9])->count() ;
        $magasinsR = $magasinsAll->whereNotIn('etiquette_id', [9])->count() ;

        //selectionner les appartements 
        //$magasinsAll = $magasinsAll->whereNotNull('appartement.id' ); 

        $maxPrix = $magasinsAll->max('prixM2Indicatif');
        $minPrix = $magasinsAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des appartement
        if (isset($request['numsappartement']) && $request['numsappartement'] != '' ) {
            $numsappartement = preg_split("/[\s,\.]+/", $request['numsappartement']);
            $numsappartement = array_map('trim', $numsappartement);
            $magasinsAll = $magasinsAll->whereIn('constructible.num', $numsappartement);
        }

        //recherche par prix
        if (isset($request['minPrix']) && $request['minPrix'] != '' ) {
            $minPrix = intval($request['minPrix']) ;
        }

        //recherche par prix
        if (isset($request['maxPrix']) && $request['maxPrix'] != '' ) {
            $maxPrix = floatval($request['maxPrix']) ;
        }

        $magasinsAll = $magasinsAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 


        //recherche par tranche
        if (isset($request['tranche']) && $request['tranche'] != '-' ) {
            $tr = $request['tranche'] ;

            $magasinsAll = $magasinsAll->filter(function ($item) use ($tr)  {

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
            $magasinsAll = $magasinsAll->where('constructible.immeuble_id', $imm); 
        }

        //recherche par nombre de façades
        if (isset($request['nombreFacadesappartement']) && $request['nombreFacadesappartement'] != '-' ) {
            $fa = $request['nombreFacadesappartement'] ;
            $magasinsAll = $magasinsAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($request['etage']) && $request['etage'] != '-' ) {
            $et = $request['etage'] ;
            $magasinsAll = $magasinsAll->where('constructible.etage', $et); 
        }  

        //recherche par type de appartement
        if (isset($request['type']) && $request['type'] != '-' ) {
            $ty = $request['type'] ;
            $magasinsAll = $magasinsAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du appartement
        if (isset($request['etatProduit']) && $request['etatProduit'] != '-' ) {
            $etat = $request['etatProduit'] ;
            $magasinsAll = $magasinsAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalappartements = $magasinsAll->map(function ($item, $key) use ($total) {
                    return $total = $total + $item->totalIndicatif;
        });

           $magasinsParPage = $this->paginate($magasinsAll) ;
           $magasinsParPage->withPath('/magasins');
           $magasinsParPage->withQueryString() ;

           $urlWithQueryString = $request->fullUrl();
           $urlWithQueryString = substr($urlWithQueryString, strlen($request->url())) ;           

        return view('magasins.index', [
            'magasins'              => $magasinsParPage,
            'totalMagasins'         => $magasinsAll->count(),
            'immeubles'              =>Immeuble::all(),
            'etiquettes'            =>Etiquette::all(),
            'valeurTotal'           => $prixTotalappartements->sum(),
            'tranches'                  =>Tranche::all(),
            'magasinsReserved'       => $magasinsReserved,
            'magasinsBlocked'        => $magasinsBlocked,
            'magasinsStocked'        => $magasinsStocked,
            'magasinsR'             => $magasinsR, 
            'SearchByImm'           => $request['immeuble'] ,
            'SearchByFacade'        => $request['nombreFacadesappartement'] ,
            'SearchByEtage'         => $request['etage'] ,
            'SearchByEtat'          => $request['etatProduit'] ,
            'SearchByType'          => $request['type'] ,
            'SearchByMin'           => $request['minPrix'] ,
            'SearchByMax'           => $request['maxPrix'] ,
            'SearchByNum'           => $request['numsappartement'] ,
            'SearchByTr'           => $request['tranche'] ,
             'urlWithQueryString' => $urlWithQueryString

        ]);
    }

    public function export(Request $request) 
    {
        return Excel::download(new MagasinsExport($request), 'Etats-Magasins-DSD.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('editer magasins')) {
                abort(403);
        }         
        return view('magasins.create', [
            'voies'         => Voie::all(),
            'immeubles'     => Immeuble::all(),
            'etiquettes'    => Etiquette::whereNotIn('label', ['Vendu'])->get(),
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
        if (! Gate::allows('editer magasins')) {
                abort(403);
        }         
        $immeuble = Immeuble::findOrFail($request['immeuble']) ;
        $etiquette = Etiquette::findOrFail($request['etatProduit']) ;
        $Magasin = new Magasin() ;
        $Magasin->num               = $request['numMag'];
        $Magasin->surfacePlancher        = $request['surfacePlancher'];
        $Magasin->surfaceMezzanine   = $request['surfaceMezzanine'];
        $Magasin->surfaceSousSol   = $request['surfaceSousSol'];
        $Magasin->description       = $request['description'];
        $Magasin->save();
        $immeuble->magasins()->save($Magasin) ;

        $produit = new Produit([
        'etatProduit'       => $request['etatProduit'] ,
        'prixM2Indicatif'    => $request['prixM2Indicatif'] ,
        'prixM2Definitif'   => $request['prixM2Definitif'],
        'etiquette_id'   => $etiquette->id,

        ]) ;
        $Magasin->produit()->save($produit) ;
        //$etiquette->produits()->save($produit) ;
        $produit->voies()->attach($request['voies']) ;


        return redirect()->action([MagasinController::class, 'index'])
        ->with('message','Magasin ajouté !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magasin  $magasin
     * @return \Illuminate\Http\Response
     */
    public function show(Magasin $magasin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Magasin  $magasin
     * @return \Illuminate\Http\Response
     */
    public function edit(Magasin $magasin)
    {
        if (! Gate::allows('editer magasins')) {
                abort(403);
        }         
        return view('magasins.edit', [
            'magasin'           => $magasin, 
            'voies'         => Voie::all(), 
            'etiquettes'    => Etiquette::whereNotIn('label', ['Vendu'])->get(),
            'immeubles'      => Immeuble::all()]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Magasin  $magasin
     * @return \Illuminate\Http\Response
     */
    public function update(ProduitRequest $request, Magasin $magasin)
    {
        if (! Gate::allows('editer magasins')) {
                abort(403);
        }         
        $immeuble = Immeuble::findOrFail($request['immeuble']) ;

        if ($magasin->produit->dossier == null) {
            
            $magasin->produit->etiquette_id = $request['etatProduit'];  
            
        }
        // controller si l'utilisateur a le droit de modifier le prix indicatif
        if (Gate::allows('editer prix produits'))
        {
            $magasin->produit->prixM2Indicatif  = $request['prixM2Indicatif'];

        }

        
        $magasin->produit->prixM2Definitif  = $request['prixM2Definitif'];
        $magasin->produit->update() ;
        $magasin->produit->voies()->detach() ; 
        $magasin->produit->voies()->attach($request['voies']) ;

        $magasin->num               = $request['numMag'];
        $magasin->surfacePlancher   = $request['surfacePlancher'];
        $magasin->surfaceMezzanine  = $request['surfaceMezzanine'];
        $magasin->surfaceSousSol   = $request['surfaceSousSol'];
        $magasin->description       = $request['description'];
        $magasin->update();
        $immeuble->magasins()->save($magasin) ;

        return redirect()->action([MagasinController::class, 'index'])
        ->with('message','Magasin modifié !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Magasin  $magasin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Magasin $magasin)
    {
        if (! Gate::allows('supprimer magasins')) {
                abort(403);
        }          
        if ($magasin->produit->dossier != Null ) {
            return redirect()->back()
            ->with('error','Supression impossible. Déjà vendu.');
        }         
        $magasin->produit->voies()->detach() ;
        $magasin->delete() ;
        $magasin->produit()->delete() ;
        return redirect()->action([MagasinController::class, 'index'])
        ->with('message','Magasin supprimé !');
    }
}
