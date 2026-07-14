<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('types.index', ['types' => Type::all()]) ; 
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
            'type' => [
                'required',
                'string',
            ],
        ]);
        $type = new Type([
        'type'       => $request['type'] ,

        ]) ;
        $type->save();
        return redirect()->action([TypeController::class, 'index'])
        ->with('message','Type ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tranche  $tranche
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return view('types.index', ['types' => Type::all(),
        'type' => $type]) ; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tranche  $tranche
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
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
    public function update(Request $request, Type $type)
    {

        $request->validate([
            'type' => [
                'required',
                'string',
            ],
        ]);

        $type->type = $request['type'] ;

        $type->save() ;

        return redirect()->action([TypeController::class, 'index'])
        ->with('message','Type modifié !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tranche  $tranche
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete() ;
        return redirect()->action([TypeController::class, 'index'])
        ->with('message','Type supprimé !');
    }
}
