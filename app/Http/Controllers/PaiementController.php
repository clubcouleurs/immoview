<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Dossier;
use App\Models\Paiement;
use App\Models\Produit;
use Illuminate\Http\Request;

class PaiementController extends Controller
{




    public function historique()
    {
        $collection = Produit::with('constructible')->get() ;
        $multiplied = $collection->map(function ($item, $key) {
            return $item->prixM2Definitif * $item->constructible->surface;
        });
        $ca = $multiplied->sum() ;
        $totalPaiements = Paiement::sum('montant') ;
        return view('paiements.historique', [
            'paiements' => Paiement::paginate(15),
            'ca' => $ca,
            'toatalPaiements' => $totalPaiements

        ]) ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Dossier $dossier)
    {
        return view('paiements.index', [
            'dossier' => $dossier ,
            'paiements' => $dossier->paiements()->paginate(15),
            'banques' => Banque::all(),
        ]);
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
            'banque'   => 'required|integer',

        ]);
        $paiement = new Paiement([
            'date'              => $request['date'],
            'type'              => $request['type'],
            'montant'           => $request['montant'],
            'banque_id'           => $request['banque'],

        ]) ;
        if ($paiement->type != 'Espèce')
        {
            $paiement->num = $request['num'] ;
        }
        $dossier->paiements()->save($paiement) ;
        return redirect()->action([PaiementController::class, 'index'] , ['dossier' => $dossier])
        ->with('message','Paiement ajouté !');
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
            'paiements' => $dossier->paiements()->paginate(15),
            'banques' => Banque::all(),
        ]) ;
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
            'date'      => 'sometimes|required|string',
            'type'      => 'sometimes|required|string',
            'num'       => 'sometimes|required|string',
            'montant'   => 'sometimes|required|integer',
            'valider'   => 'sometimes|required|boolean',
            'banque'   => 'required|integer',

        ]);

        if (isset($request['montant']))
        {
            $paiement->date     = $request['date'] ;
            $paiement->type     = $request['type'] ;
            $paiement->montant  = $request['montant']; 
            $paiement->banque_id = $request['banque']; 
            
            if ($paiement->type != 'Espèce')
            {
                $paiement->num = $request['num'] ;
            }else
            {
                $paiement->num = NULL ;
            }
        }
        elseif(isset($request['valider']))
        {
            $paiement->valider = boolval($request['valider']) ;
        }
        $paiement->update() ;
        $dossier = ($dossier != null) ? $dossier : $paiement->$dossier ;
        return redirect()->action([PaiementController::class, 'index'] , ['dossier' => $dossier])->with('message','Paiement modifié !');
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
        return redirect()->action([PaiementController::class, 'index'] , ['dossier' => $dossier])
        ->with('message','Paiement supprimé !');
    }
}
