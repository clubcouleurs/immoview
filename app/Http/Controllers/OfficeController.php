<?php

namespace App\Http\Controllers;

use App\Http\Traits\PaginateTrait;
use App\Models\Appartement;
use App\Models\Etiquette;
use App\Models\Immeuble;
use App\Models\Magasin;
use App\Models\Office;
use App\Models\Produit;
use App\Models\Tranche;
use App\Models\Voie;
use Illuminate\Http\Request;

class OfficeController extends Controller
{

    use PaginateTrait ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $officesAll = Produit::with('constructible')
                            ->where('constructible_type','bureau')
                            ->with('etiquette')
                            ->withCount('voies')
                            ->get();

        $officesReserved = $officesAll->where('etiquette_id', 3)->count() ;
        $officesStocked = $officesAll->where('etiquette_id', 2)->count() ;
        $officesBlocked = $officesAll->whereNotIn('etiquette_id', [3,2])->count() ;

        //selectionner les appartements 
        //$officesAll = $officesAll->whereNotNull('appartement.id' ); 

        $maxPrix = $officesAll->max('prixM2Indicatif');
        $minPrix = $officesAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des appartement
        if (isset($request['numsappartement']) && $request['numsappartement'] != '' ) {
            $numsappartement = preg_split("/[\s,\.]+/", $request['numsappartement']);
            $numsappartement = array_map('trim', $numsappartement);
            $officesAll = $officesAll->whereIn('constructible.num', $numsappartement);
        }

        //recherche par prix
        if (isset($request['minPrix']) && $request['minPrix'] != '' ) {
            $minPrix = intval($request['minPrix']) ;
        }

        //recherche par prix
        if (isset($request['maxPrix']) && $request['maxPrix'] != '' ) {
            $maxPrix = floatval($request['maxPrix']) ;
        }

        $officesAll = $officesAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 

        //recherche par tranche
        if (isset($request['tranche']) && $request['tranche'] != '-' ) {
            $tr = $request['tranche'] ;
            $officesAll = $officesAll->where('constructible.tranche_id', $tr); 
        }

        //recherche par nombre de façades
        if (isset($request['nombreFacadesappartement']) && $request['nombreFacadesappartement'] != '-' ) {
            $fa = $request['nombreFacadesappartement'] ;
            $officesAll = $officesAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($request['etage']) && $request['etage'] != '-' ) {
            $et = $request['etage'] ;
            $officesAll = $officesAll->where('constructible.etage', $et); 
        }  

        //recherche par type de appartement
        if (isset($request['type']) && $request['type'] != '-' ) {
            $ty = $request['type'] ;
            $officesAll = $officesAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du appartement
        if (isset($request['etatProduit']) && $request['etatProduit'] != '-' ) {
            $etat = $request['etatProduit'] ;
            $officesAll = $officesAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalOffices = $officesAll->map(function ($item, $key) use ($total) {
                return $total = $total + $item->totalIndicatif;
        });



        return view('offices.index', [
            'offices'               => $this->paginate($officesAll),
            'totalOffices'          => $officesAll->count(),
            'tranches'              => Tranche::all(),
            'etiquettes'            => Etiquette::all(),
            'valeurTotal'           => $prixTotalOffices->sum(),
            'officesReserved'       => $officesReserved,
            'officesBlocked'        => $officesBlocked,
            'officesStocked'        => $officesStocked,

            'SearchByTranche'       => $request['tranche'] ,
            'SearchByFacade'        => $request['nombreFacadesappartement'] ,
            'SearchByEtage'         => $request['etage'] ,
            'SearchByEtat'          => $request['etatProduit'] ,
            'SearchByType'          => $request['type'] ,
            'SearchByMin'           => $request['minPrix'] ,
            'SearchByMax'           => $request['maxPrix'] ,
            'SearchByNum'           => $request['numsappartement'] ,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offices.create', [
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
    public function store(Request $request)
    {
        $immeuble = Immeuble::findOrFail($request['immeuble']) ;
        $etiquette = Etiquette::findOrFail($request['etatProduit']) ;

        if ($request['type'] === 'Appartement') {

            $situable = new Appartement() ;
            $situable->surfaceApp        = $request['surfaceApp'];
            $situable->surfaceTerrasse   = $request['surfaceTerrasse'];
            $situable->etage             = $request['etage'];
            $situable->description       = $request['descriptionApp'];
            $situable->save();
            $immeuble->appartements()->save($situable) ;

        }elseif($request['type'] === 'Magasin')
        {
            $situable = new Magasin() ;
            $situable->surfacePlancher        = $request['surfacePlancher'];
            $situable->surfaceMezzanine   = $request['surfaceMezzanine'];
            $situable->description       = $request['description'];
            $situable->save();
            $immeuble->magasins()->save($situable) ;            
        }

        $office = new Office([
            'num'       => $request['numBur'] ,
        ]) ;

        $produit = new Produit([
            'etatProduit'       => $request['etatProduit'] ,
            'prixM2Indicatif'    => $request['prixM2Indicatif'] ,
            'prixM2Definitif'   => $request['prixM2Definitif'],
            'etiquette_id'   => $etiquette->id,
        ]) ;

        $situable->office()->save($office) ;
        $office->produit()->save($produit) ;

        $produit->voies()->attach($request['voies']) ;


        return redirect()->action([OfficeController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        return view('offices.edit', [
            'office'           => $office, 
            'voies'         => Voie::all(), 
            'etiquettes'    => Etiquette::all(),
            'immeubles'      => Immeuble::all()]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        ////////////////////
        //dd($request['voies']) ;

        $immeuble = Immeuble::findOrFail($request['immeuble']) ;
        $etiquette = Etiquette::findOrFail($request['etatProduit']) ;

        // l'utilisateur ne change pas le type du bureau 
            // le bureau était un appartement et il reste un appartement
        if ($office->situable_type == 'appartement' && $request['type'] === 'Appartement') {
            //$situable = new Appartement() ;
            $office->situable->surfaceApp        = $request['surfaceApp'];
            $office->situable->surfaceTerrasse   = $request['surfaceTerrasse'];
            $office->situable->etage             = $request['etage'];
            $office->situable->description       = $request['descriptionApp'];
            $office->situable->save();
            $immeuble->appartements()->save($situable) ;
        }
            // le bureau était un magasin et il reste un magasin
        if($office->situable_type == 'magasin' && $request['type'] === 'Magasin')
        {
            //$situable = new Magasin() ;
            $office->situable->surfacePlancher     = $request['surfacePlancher'];
            $office->situable->surfaceMezzanine    = $request['surfaceMezzanine'];
            $office->situable->description         = $request['description'];
            $office->situable->save();
            $immeuble->magasins()->save($office->situable) ;            
        }

        // l'utilisateur change le type du bureau 
            // le bureau était un magasin et il devient un appartement

        if ($office->situable_type == 'magasin' && $request['type'] === 'Appartement') {
            // supprimer le magasin
            // supprimer le produit
                    //$office->produit->voies()->detach() ;
                    //$office->delete() ;
                    //$office->produit()->delete() ;  
                    $office->situable()->delete() ;  

            // on crée une nouvelle instance de l'appartement                     

            $situable = new Appartement() ;
            $situable->surfaceApp        = $request['surfaceApp'];
            $situable->surfaceTerrasse   = $request['surfaceTerrasse'];
            $situable->etage             = $request['etage'];
            $situable->description       = $request['descriptionApp'];
            $situable->save();
            $immeuble->appartements()->save($situable) ;
        }
            // le bureau était un appartement et il devient un magasin

        if ($office->situable_type == 'appartement' && $request['type'] === 'Magasin') {
            // supprimer l'appartement
            // supprimer le produit
                    //$office->produit->voies()->detach() ;
                    //$office->delete() ;
                    //$office->produit()->delete() ;  
                    $office->situable()->delete() ;  

            // on crée une nouvelle instance de l'appartement                     

            $situable = new Magasin() ;
            $situable->surfacePlancher        = $request['surfacePlancher'];
            $situable->surfaceMezzanine   = $request['surfaceMezzanine'];
            $situable->description       = $request['description'];
            $situable->save();
            $immeuble->magasins()->save($situable) ;   
        }


        $office->num =  $request['numBur']; 
        $office->update() ;

        $office->produit->etiquette_id      = $request['etatProduit']; 
        $office->produit->prixM2Indicatif  = $request['prixM2Indicatif'];
        $office->produit->prixM2Definitif  = $request['prixM2Definitif'];
        $office->produit->update() ;
        $office->produit->voies()->detach() ; 
        $office->produit->voies()->attach($request['voies']) ;


        $situable->office()->save($office) ;
        //$office->produit()->save($produit) ;



        return redirect()->action([OfficeController::class, 'index']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        $office->produit->voies()->detach() ;
        $office->delete() ;
        $office->produit()->delete() ;  
        $office->situable()->delete() ;  
        return redirect()->action([OfficeController::class, 'index']);
    }
}
