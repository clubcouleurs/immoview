<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Tranche;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrancheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projet = Projet::where('id' , session('projet_id'))->limit(1)->first() ;  
        return view('tranches.index', ['tranches' => Tranche::where('projet_id' , $projet->id)->get()]) ; 
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
        $projet_id = session('projet_id');
        $projet = Projet::where('id' , $projet_id)->limit(1)->first() ;  
        $request->validate([
            'description' => 'string|nullable',
            'num' => [
                'required',
                'numeric',
                Rule::unique('tranches', 'num')->where('projet_id', $projet->id),
            ],
        ]);
        $tranche = new Tranche([
        'description'       => $request['description'] ,
        'num'               => $request['num'] ,
        'projet_id'         => $projet->id ,
        ]) ;
        $projet->tranches()->save($tranche);
        return redirect()->action([TrancheController::class, 'index'])
        ->with('message','Tranche ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tranche  $tranche
     * @return \Illuminate\Http\Response
     */
    public function show(Tranche $tranch)
    {
        // $projet = Projet::where('id' , session('projet_id'))->limit(1)->first() ;  
        return view('tranches.index', ['tranches' => Tranche::where('projet_id' , session('projet_id'))->get(),
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

        $projet = Projet::where('id' , session('projet_id'))->limit(1)->first() ;  
        $request->validate([
            'description' => 'string|nullable',
            'num' => [
                'required',
                'numeric',
                Rule::unique('tranches', 'num')->where('projet_id', $projet->id)->ignore($tranch),
            ],
        ]);

        // $request->validate([
        //     'description' => 'string|nullable',
        //     'num' => 'required|numeric|unique:tranches,num,'.$tranch->id,

        // ]);

        $tranch->description = $request['description'] ;
        $tranch->num = $request['num'] ;

        $tranch->save() ;

        return redirect()->action([TrancheController::class, 'index'])
        ->with('message','Tranche modifié !');
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
        return redirect()->action([TrancheController::class, 'index'])
        ->with('message','Tranche supprimé !');
    }
}
