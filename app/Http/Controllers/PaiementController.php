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
            'pj' => 'sometimes|required|max:5000|mimetypes:application/pdf,image/png,image/jpeg,image/tiff,image/gif',

        ]);
        $banque = Banque::findOrFail($request['banque']) ;
        $paiement = new Paiement([
            'date'              => $request['date'],
            'type'              => $request['type'],
            'montant'           => $request['montant'],
        ]) ;

        $totalPaiement = $dossier->totalPaiements + $paiement->montant ;
        $restePaiement = $paiement->montant - $dossier->totalPaiements ;

        if($totalPaiement > $dossier->produit->total)
        {
            return back()->withInput()->with('error', 'Vous avez dépasser le reste à payer!') ;
        }

        $paiement->num = $request['num'] ;

        if($request->hasFile('pj'))
        {
            $client = $dossier->client->nom . '-' . $dossier->client->prenom ;
            $pjName = str_replace(' ', '', $paiement->type) . '-' 
            . str_replace('.', '', $paiement->num) . '-DossierN' 

            . str_replace('.', '', $dossier->num) . '-' 

            . str_replace('.', '',  $client ) . '-' 

            . str_replace(' ', '-', date('Y-m-d-His')) ;
            $pjExtension = $request->file('pj')->extension() ;
            $pdfPath = $request->file('pj')
            ->storeAs('public/pj', $pjName . '.' . $pjExtension) ;
            $paiement->pj = 'pj/' . $pjName . '.' . $pjExtension ;
        }
                
        $paiement->banque()->associate($banque) ;
        $paiement->dossier()->associate($dossier) ;
        $paiement->save();

        $dossier->isVente = true ;
        $dossier->update() ;
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
            'banque'    => 'sometimes|required|integer',
            'pj' => 'sometimes|required|max:5000|mimetypes:application/pdf,image/png,image/jpeg,image/tiff,image/gif',

        ]);

        if (isset($request['montant']))
        {
            $paiement->date     = $request['date'] ;
            $paiement->type     = $request['type'] ;
            $paiement->montant  = $request['montant']; 
            $paiement->banque_id = $request['banque']; 
            
        if($totalPaiement > $dossier->produit->total)
        {
            return back()->withInput()->with('error', 'Vous avez dépasser le reste à payer!') ;
        }

            if ($paiement->type != 'Espèce')
            {
                $paiement->num = $request['num'] ;

                if($request->hasFile('pj'))
                {
                    $client = $dossier->client->nom . '-' . $dossier->client->prenom ;

                    $pjName = str_replace(' ', '', $paiement->type) . '-' 
                    . str_replace('.', '', $paiement->num) . '-DossierN' 

                    . str_replace('.', '', $dossier->num) . '-' 

                    . str_replace('.', '',  $client ) . '-' 

                    . str_replace(' ', '-', date('Y-m-d-His')) ;

                    $pjExtension = $request->file('pj')->extension() ;                 

                    $pdfPath = $request->file('pj')
                    ->storeAs('public/pj', $pjName . '.' . $pjExtension) ;

                    $paiement->pj = 'pj/' . $pjName . '.' . $pjExtension ;

                    //$paiement->pj = $pjName . '.' . $pjExtension ;
                }

            }else
            {
                $paiement->num  = NULL ;
                $paiement->pj   = NULL ;
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
        if ($dossier->paiements->count() === 0 ) {
            $dossier->isVente = false ;
            $dossier->update() ;
        }
        return redirect()->action([PaiementController::class, 'index'] , ['dossier' => $dossier])
        ->with('message','Paiement supprimé !');
    }
}
