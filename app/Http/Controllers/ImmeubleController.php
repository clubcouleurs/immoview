<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use App\Models\Tranche;
use Illuminate\Http\Request;

class ImmeubleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('immeubles.index', ['immeubles' => Immeuble::all(), 'tranches' => Tranche::all()]) ; //->paginate(2)]) ;

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
        $tranche = Tranche::findOrFail($request['tranche_id']) ;
        $request->validate([
            'description' => 'string|nullable',
            'num' => 'required|alpha_num|unique:immeubles',

        ]);

        $immeuble = new Immeuble([
        'description'       => $request['description'],
        'num'               => $request['num'] ,

        ]) ;
        $tranche->immeubles()->save($immeuble) ;
        return redirect()->action([ImmeubleController::class, 'index'])
        ->with('message','Immeuble ajouté !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\immeuble  $immeuble
     * @return \Illuminate\Http\Response
     */
    public function show(Immeuble $immeuble)
    {
        return view('immeubles.index', ['immeubles' => Immeuble::all(),'tranches' => Tranche::all(),
        'immeuble' => $immeuble]) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\immeuble  $immeuble
     * @return \Illuminate\Http\Response
     */
    public function edit(Immeuble $immeuble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\immeuble  $immeuble
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Immeuble $immeuble)
    {
        //$immeuble->update(['tranche_id' => $request['tranche_id']);

        $request->validate([
            'description' => 'string|nullable',
            'num' => 'required|alpha_num|unique:immeubles,num,'. $immeuble->id,
        ]);

        $immeuble->description = $request['description'] ;
        $immeuble->tranche_id = $request['tranche_id'] ;
        $immeuble->num = $request['num'] ;

        $immeuble->save() ;

        return redirect()->action([ImmeubleController::class, 'index'])
        ->with('message','Immeuble modifié !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\immeuble  $immeuble
     * @return \Illuminate\Http\Response
     */
    public function destroy(Immeuble $immeuble)
    {
        $immeuble->delete() ;
        return redirect()->action([ImmeubleController::class, 'index'])
        ->with('message','Immeuble supprimé !');

    }
}
