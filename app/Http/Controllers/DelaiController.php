<?php

namespace App\Http\Controllers;

use App\Models\Delai;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DelaiController extends Controller
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
    public function create(Dossier $dossier)
    {
        if (! Gate::allows('Ajouter dossiers ' . p($dossier->produit->constructible_type))) 
        {
                abort(403);

        }

        if ($dossier->isVente)
        {
                abort(403, 'La vente est déjà conclue');
        }
        return view('delais.create', ['dossier' => $dossier]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Dossier $dossier)
    {
        if (! Gate::allows('Ajouter dossiers ' . p($dossier->produit->constructible_type))) {
                abort(403);
        }

        $request->validate([
            'date'       => 'required|date|after:today',
            'raison'    => 'required|string',
        ],
        [
            'date.after'    => 'La date du délai doit être une date postérieure à celle d\'aujourd\'hui',
        ]
    );

        $delai = new Delai ;
        $delai->raison = $request['raison'] ;
        $delai->date = $request['date'] ;
        $dossier->delais()->save($delai) ;
        $dossier->isVente = false ;
        $dossier->update() ;
        return redirect($dossier->produit->constructible_type . '/0/dossiers')
                    ->with('message','Délai ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delai  $delai
     * @return \Illuminate\Http\Response
     */
    public function show(Delai $delai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delai  $delai
     * @return \Illuminate\Http\Response
     */
    public function edit(Delai $delai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delai  $delai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delai $delai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delai  $delai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delai $delai)
    {
        //
    }
}
