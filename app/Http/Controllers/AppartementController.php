<?php

namespace App\Http\Controllers;

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

class AppartementController extends Controller
{
    use PaginateTrait ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $appartementsAll = Produit::with('constructible')
                            ->where('constructible_type','appartement')
                            ->with('etiquette')
                            ->withCount('voies')
                            ->orderByDesc('created_at')
                            ->get();
        $appartementsReserved = $appartementsAll->where('etiquette_id', 3)->count() ;
        $appartementsStocked = $appartementsAll->where('etiquette_id', 2)->count() ;
        $appartementsBlocked = $appartementsAll->whereNotIn('etiquette_id', [3,2])->count() ;

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
        if (isset($request['immeuble']) && $request['immeuble'] != '-' ) {
            $tr = $request['immeuble'] ;
            $appartementsAll = $appartementsAll->where('constructible.immeuble_id', $tr); 
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
               return $total = $total + $item->totalIndicatif;
        });



        return view('appartements.index', [
            'appartements'              => $this->paginate($appartementsAll),
            'totalappartements'         => $appartementsAll->count(),
            'immeubles'                 =>Immeuble::all(),
            'etiquettes'                =>Etiquette::all(),
            'valeurTotal'               => $prixTotalappartements->sum(),

            'appartementsReserved'      => $appartementsReserved,
            'appartementsBlocked'       => $appartementsBlocked,
            'appartementsStocked'       => $appartementsStocked,

            'SearchByImm'           => $request['immeuble'] ,
            'SearchByFacade'        => $request['nombreFacadesappartement'] ,
            'SearchByEtage'     => $request['etage'] ,
            'SearchByEtat'     => $request['etatProduit'] ,
            'SearchByType'     => $request['type'] ,
            'SearchByMin'     => $request['minPrix'] ,
            'SearchByMax'     => $request['maxPrix'] ,
            'SearchByNum' => $request['numsappartement'] ,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('appartements.create', [
            'voies' => Voie::all(),
            'immeubles' => Immeuble::all(),
            'etiquettes' => Etiquette::all(),
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
        
        $immeuble = Immeuble::findOrFail($request['immeuble']) ;
        $etiquette = Etiquette::findOrFail($request['etatProduit']) ;


        $Appartement = new Appartement() ;
        $Appartement->num               = $request['numApp'];
        $Appartement->surfaceApp        = $request['surfaceApp'];
        $Appartement->surfaceTerrasse   = $request['surfaceTerrasse'];
        $Appartement->type              = $request['type'];
        $Appartement->etage             = $request['etage'];
        $Appartement->description       = $request['descriptionApp'];
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
        return view('appartements.edit', [
            'appartement'           => $appartement, 
            'voies'         => Voie::all(), 
            'etiquettes'    => Etiquette::all(),
            'immeubles'      => Immeuble::all()]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appartement $appartement)
    {
        if ($appartement->produit->dossier == null) {
            
            $appartement->produit->etiquette_id = $request['etatProduit']; 
            
        }
        $appartement->produit->prixM2Indicatif  = $request['prixM2Indicatif'];
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
        $appartement->description       = $request['descriptionApp'];
        $appartement->update();

        $immeuble->appartements()->save($appartement) ;

        return redirect()->action([AppartementController::class, 'index'])
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
        $appartement->produit->voies()->detach() ;       
        $appartement->immeuble()->dissociate() ;
        $appartement->delete() ;
        $appartement->produit()->delete() ;
        return redirect()->action([AppartementController::class, 'index'])
        ->with('message','Appartement supprimé !');
    }
}
