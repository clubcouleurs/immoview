<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Box;
use App\Models\Dossier;
use App\Models\Lot;
use App\Models\Magasin;
use App\Models\Office;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //
    }

    public function produits_data(Request $request, $num, $type)
    {

        $produit = Produit::with('constructible')->where('etiquette_id' , '2')
        ->whereHasMorph('constructible', strtolower($type) , function (Builder $query) use($num) {
            $query->where('num' ,'=' , $num);
                })->first();

        if (isset($produit)) {
            $id = $produit->id;

            switch ($produit->constructible_type) {
                case 'appartement':
                case 'bureau':
                case 'magasin':
                case 'box' :                 
                    $name =  'Détails du produit : ' . $produit->constructible_type . 
                    ' (' . $produit->constructible->type . ')' .
                    ', Surface : ' . $produit->constructible->surface .
                    'm2, Etage : ' . $produit->etage .
                    ', Immeuble : ' . $produit->constructible->immeuble->num .
                    ', Tranche : ' . $produit->constructible->tranche->num . '.';

                    break;
                case 'lot':
                    $name =  'Détails du produit : ' . $produit->constructible_type . 
                    ' ' . $produit->constructible->type .
                    ', Surface : ' . $produit->constructible->surface .
                    'm2, R+' . $produit->etage .
                    ', Tranche : ' . $produit->constructible->tranche->num . 
                    '. Le prix total est de : ' . number_format($produit->total) . ' Dhs' .
                    ' (' . $produit->prix. 'Dhs/m2)';
                    break;                    

                default:
                    # code...
                    break;
            }


        }else {
            $name = 'Produit inexistant ou déjà vendu' ;
            $id = null ;
        } 
        

        //$produit = Produit::has('constructible.num' ,'=' , $num)->get() ;
        //dd($produit) ;
        return [ 'name' => $name, 'id' => $id ] ;

    }   
}
