<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Dossier $dossier)
    {
        return view('paiements.index', [
            'dossier' => $dossier ,
            'paiements' => $dossier->paiements()->paginate(15)]) ;
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
    public function store(Request $request, Dossier $dossier)
    {
        $request->validate([
            'date'      => 'required|string',
            'type'      => 'required|string',
            'num'       => 'sometimes|required|string',
            'montant'   => 'required|integer',
        ]);

        $paiement = new Paiement([
            'date'              => $request['date'],
            'type'              => $request['type'],
            'montant'           => $request['montant'],
        ]) ;

        if ($paiement->type != 'Espèce')
        {
            $paiement->num = $request['num'] ;
        }

        $dossier->paiements()->save($paiement) ;
        return redirect()->action([PaiementController::class, 'index'] , ['dossier' => $dossier]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function show(Dossier $dossier, Paiement $paiement)
    {
        return view('paiements.index', [
            'dossier' => $dossier ,
            'paiement' => $paiement ,
            'paiements' => $dossier->paiements()->paginate(15)]) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function edit(Paiement $paiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dossier $dossier, Paiement $paiement)
    {
        $request->validate([
            'date'      => 'required|string',
            'type'      => 'required|string',
            'num'       => 'sometimes|required|string',
            'montant'   => 'required|integer',
        ]);


            $paiement->date     = $request['date'] ;
            $paiement->type     = $request['type'] ;
            $paiement->montant  = $request['montant']; 


        if ($paiement->type != 'Espèce')
        {
            $paiement->num = $request['num'] ;
        }else
        {
            $paiement->num = NULL ;
        }

        $paiement->update() ;
        return redirect()->action([PaiementController::class, 'index'] , ['dossier' => $dossier]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dossier $dossier, Paiement $paiement)
    {
        $paiement->delete() ;
        return redirect()->action([PaiementController::class, 'index'] , ['dossier' => $dossier]);
    }
}
