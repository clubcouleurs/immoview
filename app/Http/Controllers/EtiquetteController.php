<?php

namespace App\Http\Controllers;

use App\Models\Etiquette;
use Illuminate\Http\Request;

class EtiquetteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('etiquettes.index', ['etiquettes' => Etiquette::all()]) ; 
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
        $request->validate([
            'label' => 'string|nullable',
        ]);

        $etiquette = new Etiquette([
        'label'       => $request['label'] ,
        ]) ;
        $etiquette->save() ;
        return redirect()->action([EtiquetteController::class, 'index'])
        ->with('message','Etiquette ajouté !');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Etiquette  $etiquette
     * @return \Illuminate\Http\Response
     */
    public function show(Etiquette $etiquette)
    {
        return view('etiquettes.index', ['etiquettes' => Etiquette::all(),
        'etiquette' => $etiquette]) ; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Etiquette  $etiquette
     * @return \Illuminate\Http\Response
     */
    public function edit(Etiquette $etiquette)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Etiquette  $etiquette
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etiquette $etiquette)
    {
        $request->validate([
            'label' => 'string|nullable',
        ]);

        $etiquette->label = $request['label'] ;
        $etiquette->save() ;

        return redirect()->action([EtiquetteController::class, 'index'])
        ->with('message','Etiquette modifié !');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Etiquette  $etiquette
     * @return \Illuminate\Http\Response
     */
    public function destroy(Etiquette $etiquette)
    {
        $etiquette->delete() ;
        return redirect()->action([EtiquetteController::class, 'index'])
        ->with('message','Etiquette supprimé !');


    }
}
