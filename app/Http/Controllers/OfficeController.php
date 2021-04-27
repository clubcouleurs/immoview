<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduitRequest;
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
use Illuminate\Support\Facades\Gate;

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
        if (! Gate::allows('voir bureaux')) {
                abort(403);
        }   
        $officesAll = Produit::with('constructible')
                            ->where('constructible_type','bureau')
                            ->with('etiquette')
                            ->withCount('voies')
                            ->orderByDesc('created_at')
                            ->get();
        $officesAll = $officesAll->sortBy('constructible.num') ;

        $officesReserved = $officesAll->where('etiquette_id', 3)->count() ;
        $officesStocked = $officesAll->where('etiquette_id', 2)->count() ;
        $officesBlocked = $officesAll->whereNotIn('etiquette_id', [3,2,9])->count() ;
        $officesR = $officesAll->whereNotIn('etiquette_id', [9])->count() ;
        
        //dd($officesAll) ;
        //selectionner les appartements 
        //$officesAll = $officesAll->whereNotNull('appartement.id' ); 

        $maxPrix = $officesAll->max('prixM2Indicatif');
        $minPrix = $officesAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des appartement
        if (isset($request['numsBureaux']) && $request['numsBureaux'] != '' ) {
            $numsBureaux = preg_split("/[\s,\.]+/", $request['numsBureaux']);
            $numsBureaux = array_map('trim', $numsBureaux);
            $officesAll = $officesAll->whereIn('constructible.num', $numsBureaux);
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
        if (isset($request['immeuble']) && $request['immeuble'] != '-' ) {
            $tr = $request['immeuble'] ;
            $officesAll = $officesAll->where('constructible.immeuble_id', $tr); 
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

           $officesParPage = $this->paginate($officesAll) ;
           $officesParPage->withPath('/magasins');
           $officesParPage->withQueryString() ;

        return view('offices.index', [
            'offices'               => $officesParPage,
            'totalOffices'          => $officesAll->count(),
            'immeubles'              => Immeuble::all(),
            'etiquettes'            => Etiquette::all(),
            'valeurTotal'           => $prixTotalOffices->sum(),
            'officesReserved'       => $officesReserved,
            'officesBlocked'        => $officesBlocked,
            'officesStocked'        => $officesStocked,
            'officesR'              => $officesR,
            'SearchByImm'       => $request['immeuble'] ,
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
        if (! Gate::allows('editer bureaux')) {
                abort(403);
        }          
        return view('offices.create', [
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
        if (! Gate::allows('editer bureaux')) {
                abort(403);
        }             
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


        return redirect()->action([OfficeController::class, 'index'])
        ->with('message','Bureau ajouté !');
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
        if (! Gate::allows('editer bureaux')) {
                abort(403);
        }           
        return view('offices.edit', [
            'office'           => $office, 
            'voies'         => Voie::all(), 
            'etiquettes'    => Etiquette::whereNotIn('label', ['Vendu'])->get(),
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


        if (! Gate::allows('editer bureaux')) {
                abort(403);
        }   

        $immeuble = Immeuble::findOrFail($request['immeuble']) ;

        // l'utilisateur ne change pas le type du bureau 
            // le bureau était un appartement et il reste un appartement
        if ($office->situable_type == 'appartement' && $request['type'] === 'Appartement') {
            //$situable = new Appartement() ;
            $office->situable->surfaceApp        = $request['surfaceApp'];
            $office->situable->surfaceTerrasse   = $request['surfaceTerrasse'];
            $office->situable->etage             = $request['etage'];
            $office->situable->description       = $request['descriptionApp'];
            $office->situable->save();
            $immeuble->appartements()->save($office->situable) ;
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
                    //dd('here') ;

            $office->situable()->delete() ;  
            // on crée une nouvelle instance de l'appartement                     

            $situable = new Appartement() ;
            $situable->surfaceApp        = $request['surfaceApp'];
            $situable->surfaceTerrasse   = $request['surfaceTerrasse'];
            $situable->etage             = $request['etage'];
            $situable->description       = $request['descriptionApp'];
            $situable->save();
            $immeuble->appartements()->save($situable) ;

            $situable->office()->save($office) ;
            // $office->situable()->save($situable) ;  
            // $office->update() ;
            //$situable->office()->save($office) ;

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

            $situable->office()->save($office) ;

        }


        $office->num =  $request['numBur']; 
        $office->update() ;
        if ($office->produit->dossier == null) {

            $office->produit->etiquette_id = $request['etatProduit']; 
        }
        // controller si l'utilisateur a le droit de modifier le prix indicatif
        if (Gate::allows('editer prix produits'))
        {
            $office->produit->prixM2Indicatif  = $request['prixM2Indicatif'];
        }

        $office->produit->prixM2Definitif  = $request['prixM2Definitif'];
        $office->produit->update() ;
        $office->produit->voies()->detach() ; 
        $office->produit->voies()->attach($request['voies']) ;


        //$office->produit()->save($produit) ;



        return redirect()->action([OfficeController::class, 'index'])
        ->with('message','Bureau modifié !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        if (! Gate::allows('supprimer bureaux')) {
                abort(403);
        }
        if ($office->produit->dossier != Null ) {
            return redirect()->back()
            ->with('error','Supression impossible. Déjà vendu.');
        }
       
        $office->produit->voies()->detach() ;
        $office->produit()->delete() ;  
        $office->situable()->delete() ;
        $office->delete() ;

        return redirect()->action([OfficeController::class, 'index'])
        ->with('message','Bureau supprimé !');
    }
}
