<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Banque;
use App\Models\Box;
use App\Models\Dossier;
use App\Models\Lot;
use App\Models\Magasin;
use App\Models\Office;
use App\Models\Paiement;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaiementController extends Controller
{

    public function historique(Request $request)
    {
        $status = $request['status'] ;

        $statusArray = ($status == null || $status == '' || !is_numeric($status)) ?
                    [0,1] : [$status] ;

        $constructible = $request['constructible'] ;
        $constructibleArray = ($constructible == null || $constructible == '') ?
                    ['lot','appartement','box','magasin','bureau'] : [$constructible] ;

        $collection = Produit::with('constructible')->get() ;
        $multiplied = $collection->map(function ($item, $key) {
            return $item->total;
        });

        $ca = $multiplied->sum() ;

        $paiements = Paiement::whereHas('dossier.produit', function (Builder $query) use ($constructibleArray)
                            {
                                $query->whereIn('constructible_type', $constructibleArray);
                            })
                        ->whereIn('valider', $statusArray)
                        ->paginate(25);        

        //recherche par numéro des appartement
        if (isset($request['num']) && $request['num'] != '' ) {
            $nums = preg_split("/[\s,\.]+/", $request['num']);
            $nums = array_map('trim', $nums);

            $paiements = Paiement::whereHas('dossier.produit', function (Builder $query) use ($constructibleArray, $nums)
                            {
                                $query->whereIn('constructible_type', $constructibleArray)
                                ->whereHasMorph(
                                    'constructible',
                                    [Lot::class,
                                    Office::class,
                                    Magasin::class,
                                    Appartement::class,
                                    Box::class],

                                    function (Builder $query) use ($nums){
                                        $query->whereIn('num', $nums);
                                    }
                                );
                            })
                        ->whereIn('valider', $statusArray)
                        ->paginate(25);             
        }else
        {
        $paiements = Paiement::whereHas('dossier.produit', function (Builder $query) use ($constructibleArray)
                            {
                                $query->whereIn('constructible_type', $constructibleArray);
                            })
                        ->whereIn('valider', $statusArray)
                        ->paginate(25);             
        }

           $paiements->withPath('/paiements');
           $paiements->withQueryString() ;

        $constructibles = ['lot','appartement','box','magasin','bureau'] ;
        return view('paiements.historique', [
            'constructibles' => $constructibles ,
            'constructible' => $constructible,

            'status'    => $status,
            'paiements' => $paiements,
            'ca' => $ca,
            'toatalPaiements' => Paiement::sum('montant'),

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
            'num'       => 'sometimes|required|string|nullable',
            'montant'   => 'required|numeric',
            'banque'   => 'sometimes|required|integer',
            'pj' => 'sometimes|required|max:5000|mimetypes:application/pdf,image/png,image/jpeg,image/tiff,image/gif',

        ]);
        $paiement = new Paiement([
            'date'              => $request['date'],
            'type'              => $request['type'],
            'montant'           => $request['montant'],
        ]) ;

        $totalPaiement = $dossier->totalPaiements + $paiement->montant ;

        if($totalPaiement > $dossier->produit->total)
        {
            return back()->withInput()->with('error', 'Vous avez dépasser le reste à payer!') ;
        }

        if ($paiement->type != "Compensation") {
            $paiement->num = $request['num'] ;
        }else
        {
            $paiement->num = Null ;
        }

        if($request->hasFile('pj'))
        {
            $produit = $dossier->produit->constructible_type . '-Num-' . $dossier->produit->constructible->num ;
            $pjName = str_replace(' ', '', $paiement->type) . '-' 
            . str_replace('.', '', $paiement->num) . '-' 

            . str_replace('.', '',  $produit ) . '-' 


            . str_replace(' ', '-', date('Y-m-d-His')) ;

            $pjExtension = $request->file('pj')->extension() ;

            $pdfPath = $request->file('pj')
            ->storeAs('public/pj', $pjName . '.' . $pjExtension) ;
            $paiement->pj = 'pj/' . $pjName . '.' . $pjExtension ;
        }

        if ($request['banque'] != null ) {
            $banque = Banque::findOrFail($request['banque']) ;
            $paiement->banque()->associate($banque) ;
        }

        $paiement->dossier()->associate($dossier) ;
        $paiement->save();

        $dossier->isVente = true ;
        $dossier->produit->etiquette_id = 3 ;
        $dossier->produit->update() ;
        
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
            'montant'   => 'sometimes|required|numeric',
            'valider'   => 'sometimes|required|boolean',
            'banque'    => 'sometimes|required|integer',
            'pj' => 'sometimes|required|max:5000|mimetypes:application/pdf,image/png,image/jpeg,image/tiff,image/gif',

        ]);

        if (isset($request['montant']))
        {
            $totalPaiement = $dossier->totalPaiements - $paiement->montant + $request['montant'] ;

            $paiement->date     = $request['date'] ;
            $paiement->type     = $request['type'] ;
            $paiement->montant  = $request['montant']; 
            $paiement->banque_id = $request['banque']; 

        if($totalPaiement > $dossier->produit->total)
        {
            return back()->withInput()->with('error', 'Vous avez dépasser le reste à payer!') ;
        }

                $paiement->num = $request['num'] ;

                if($request->hasFile('pj'))
                {
                    $file = 'public/' . $paiement->pj ;

                    if (Storage::exists($file))
                     {
                        Storage::delete($file);
                    }

                    $produit = $dossier->produit->constructible_type . '-Num-' . $dossier->produit->constructible->num ;
                    $pjName = str_replace(' ', '', $paiement->type) . '-' 
                    . str_replace('.', '', $paiement->num) . '-' 

                    . str_replace('.', '',  $produit ) . '-' 
                    
                    . str_replace(' ', '-', date('Y-m-d-His')) ;

                    $pjExtension = $request->file('pj')->extension() ;                 

                    $pdfPath = $request->file('pj')
                    ->storeAs('public/pj', $pjName . '.' . $pjExtension) ;

                    $paiement->pj = 'pj/' . $pjName . '.' . $pjExtension ;

                }

        }
        elseif(isset($request['valider']))
        {
            $paiement->valider = boolval($request['valider']) ;
        }
        $paiement->update() ;
        $dossier = ($dossier != null) ? $dossier : $paiement->$dossier ;

        return redirect()->back()->with('message','Paiement modifié !');

        // return redirect()->action([PaiementController::class, 'index'] , ['dossier' => $dossier])->with('message','Paiement modifié !');
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
