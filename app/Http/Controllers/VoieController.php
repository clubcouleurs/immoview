<?php

namespace App\Http\Controllers;

use App\Models\Voie;
use Illuminate\Http\Request;

class VoieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('voies.index', ['voies' => Voie::all()]) ; //->paginate(2)]) ;
        
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
       //dd($request) ;      
        $request->validate([
            'Largeur' => 'required|numeric',
        ]);

        $voie = new Voie([
        'Largeur'       => $request['Largeur'] ,
        ]) ;
        $voie->save() ;



        return redirect()->action([VoieController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Voie $voie)
    {
        return view('voies.index', ['voies' => Voie::all(),
        'voie' => $voie]) ; //->paginate(2)]) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voie $voie)
    {
        $request->validate([
            'Largeur' => 'required|numeric',
        ]);

        $voie->Largeur = $request['Largeur'] ;
        $voie->save() ;

        return redirect()->action([VoieController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voie $voie)
    {
        $voie->delete() ;
        return redirect()->action([VoieController::class, 'index']);
    }
}
