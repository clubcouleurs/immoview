<?php

namespace App\Http\Controllers;

use App\Models\Tranche;
use Illuminate\Http\Request;

class TrancheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tranches.index', ['tranches' => Tranche::all()]) ; //->paginate(2)]) ;
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
            'description' => 'string|nullable',
        ]);

        $tranche = new Tranche([
        'description'       => $request['description'] ,
        ]) ;
        $tranche->save() ;
        return redirect()->action([TrancheController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tranche  $tranche
     * @return \Illuminate\Http\Response
     */
    public function show(Tranche $tranch)
    {
        return view('tranches.index', ['tranches' => Tranche::all(),
        'tranche' => $tranch]) ; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tranche  $tranche
     * @return \Illuminate\Http\Response
     */
    public function edit(Tranche $tranche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tranche  $tranche
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tranche $tranch)
    {
        $request->validate([
            'description' => 'string|nullable',
        ]);

        $tranch->description = $request['description'] ;
        $tranch->save() ;

        return redirect()->action([TrancheController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tranche  $tranche
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tranche $tranch)
    {
        $tranch->delete() ;
        return redirect()->action([TrancheController::class, 'index']);
    }
}
