<?php

namespace App\Http\Controllers;

use App\Exports\LotsExport;
use App\Http\Requests\ProduitRequest;
use App\Http\Traits\PaginateTrait;
use App\Models\Etiquette;
use App\Models\Lot;
use App\Models\Produit;
use App\Models\Projet;
use App\Models\Tranche;
use App\Models\Voie;
use App\Rules\oneLotPerProjet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class LotController extends Controller
{
    use PaginateTrait ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! Gate::allows('voir lots')) {
                abort(403);
        }
        // update 19/09/2023
        //récupérer le projet selectionné
        $projet = $request->session()->get('projet_id');
        
        $lotsAll = Produit::with('constructible')
                            ->where('constructible_type','lot')
                            ->where('projet_id', $projet)
                            ->with('etiquette')
                            ->withCount('voies')
                            ->orderByDesc('created_at')
                            ->get();
        $lotsAll = $lotsAll->sortBy('constructible.num') ;

        $lotsReserved = $lotsAll->where('etiquette_id', 3)->count() ;
        $lotsStocked = $lotsAll->where('etiquette_id', 2)->count() ;
        $lotsR = $lotsAll->where('etiquette_id', 9)->count() ;
        $lotsBlocked = $lotsAll->whereNotIn('etiquette_id', [3,2,9])->count() ;                            
        
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
                return $total = $total + $item->totalIndicatif;
        });

           $lotsParPage = $this->paginate($lotsAll) ;
           $lotsParPage->withPath('/lots');
           $lotsParPage->withQueryString() ;

           $urlWithQueryString = $request->fullUrl();
           $urlWithQueryString = substr($urlWithQueryString, strlen($request->url())) ;

        return view('lots.index', [
            'lots'              => $lotsParPage,
            'totalLots'         => $lotsAll->count(),
            'tranches'          => Tranche::where('projet_id' , session('projet_id'))->orderBy('num')->get(),
            'etiquettes'        =>Etiquette::all(),
            'valeurTotal'       => $prixTotalLots->sum(),
            'lotsReserved'       => $lotsReserved,
            'lotsBlocked'        => $lotsBlocked,
            'lotsStocked'        => $lotsStocked,
            'lotsR'             => $lotsR,
            'SearchByTranche'   => $request['tranche'] ,
            'SearchByFacade'    => $request['nombreFacadesLot'] ,
            'SearchByEtage'     => $request['etage'] ,
            'SearchByEtat'     => $request['etatProduit'] ,
            'SearchByType'     => $request['type'] ,
            'SearchByMin'     => $request['minPrix'] ,
            'SearchByMax'   => $request['maxPrix'] ,
            'SearchByNum'   => $request['numsLot'] ,
            'urlWithQueryString'  => $urlWithQueryString,


        ]);
    }

    public function export(Request $request) 
    {
        return Excel::download(new LotsExport($request), 'Etats-lots.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('editer lots')) {
                abort(403);
        }        
        return view('lots.create', [
            'voies' => Voie::where('projet_id' , session('projet_id'))->get(),
            'tranches' => Tranche::where('projet_id' , session('projet_id'))->orderBy('num')->get(),
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
        $request->validate(
            [
                'numLot' => [
                'sometimes',
                'required',
                new oneLotPerProjet(),
                ],
            ]
        );

        if (! Gate::allows('editer lots')) {
                abort(403);
        }
        $tranche = Tranche::findOrFail($request['tranche']) ;
        $etiquette = Etiquette::findOrFail($request['etatProduit']) ;

        $lot = new Lot() ;
        $lot->num                = $request['numLot'];
        $lot->num_cadastre       = $request['num_cadastre'];
        $lot->surface_cadastre = $request['surface_cadastre'];

        $lot->surface            = $request['surface'];
        $lot->type               = $request['type'];
        $lot->etage             = $request['etage'];
        $lot->description        = $request['description'];
        $lot->save();
        $tranche->lots()->save($lot) ;

        $produit = new Produit([
        'etatProduit'           => $request['etatProduit'] ,
        'prixM2Indicatif'       => $request['prixM2Indicatif'] ,
        'prixM2Definitif'       => $request['prixM2Definitif'],
        'etiquette_id'          => $etiquette->id,
        'projet_id'             => session('projet_id') ,
        ]);
        $lot->produit()->save($produit) ;
        $produit->voies()->attach($request['voies']) ;
        return redirect()->action([LotController::class, 'index'])
        ->with('message','Lot ajouté !');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lot $lot)
    {
        if (! Gate::allows('voir lots')) {
                abort(403);
        }        
            return view('lots.show', ['lot' => $lot]) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lot $lot)
    {
        if (! Gate::allows('editer lots')) {
                abort(403);
        }        
        return view('lots.edit', [
            'lot'           => $lot, 
            'voies' => Voie::where('projet_id' , session('projet_id'))->get(),
            'etiquettes'    => Etiquette::whereNotIn('label', ['Vendu'])->get(),
            'tranches' => Tranche::where('projet_id' , session('projet_id'))->orderBy('num')->get(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProduitRequest $request, Lot $lot)
    {
        if (! Gate::allows('editer lots')) {
                abort(403);
        }
        $request->validate(
            [
                'numLot' => [
                'required',
                new oneLotPerProjet($lot->id),
                ],
                'num_cadastre' => [
                'nullable',
                new oneLotPerProjet($lot->id, 'lots.num_cadastre'),
                ],                
            ]
        );
        $tranche = Tranche::findOrFail($request['tranche']) ;
        if ($lot->produit->dossier == null)
        {
            $lot->produit->etiquette_id = $request['etatProduit'];    
        }
        // controller si l'utilisateur a le droit de modifier le prix indicatif
        if (Gate::allows('editer prix produits'))
        {
            $lot->produit->prixM2Indicatif  = $request['prixM2Indicatif'];
        }

        $lot->produit->prixM2Definitif  = $request['prixM2Definitif'];
        $lot->produit->update() ;
        $lot->produit->voies()->detach() ; 
        $lot->produit->voies()->attach($request['voies']) ;

        $lot->num_cadastre       = $request['num_cadastre'];
        $lot->surface_cadastre = $request['surface_cadastre'];        

        $lot->num               = $request['numLot'];
        $lot->surface            = $request['surface'];
        $lot->type               = $request['type'];
        $lot->etage       = $request['etage'];
        $lot->description        = $request['description'];
        $lot->titre_foncier        = $request['titre_foncier'];

        $lot->update();
        $tranche->lots()->save($lot) ;

        return redirect()->action([LotController::class, 'index'])
        ->with('message','Lot modifié !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lot $lot)
    {
        if (! Gate::allows('supprimer lots')) {
                abort(403);
        }
        if ($lot->produit->dossier != Null ) {
            return redirect()->back()
            ->with('error','Supression impossible. Déjà vendu.');
        }
        $lot->produit->voies()->detach() ;
        $lot->delete() ;
        $lot->produit()->delete() ;
        return redirect()->action([LotController::class, 'index'])
        ->with('message','Lot supprimé !');
        
    }

    
}
