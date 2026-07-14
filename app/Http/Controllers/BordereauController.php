<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Bordereau;
use App\Models\Dossier;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use setasign\Fpdi\Tcpdf\Fpdi as TCPDF;
use setasign\Fpdi\Fpdi;
use Barryvdh\DomPDF\Facade\Pdf;

class BordereauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Dossier $dossier)
    {
        return view('bordereaux.index', [
            'dossier' => $dossier ,
            'bordereaux' => $dossier->bordereaux()->paginate(25),
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
            'montant'   => 'required|integer',
            'banque'   => 'required|integer',

        ]);

        $banque = Banque::findOrFail($request['banque']) ;

        $bordereau = new Bordereau([
            'montant'           => $request['montant'],
        ]) ;

        $totalPaiement = $dossier->totalPaiements + $bordereau->montant ;
        $restePaiement = $bordereau->montant - $dossier->totalPaiements ;

        if($totalPaiement > $dossier->produit->total)
        {
            return back()->withInput()->with('error', 'Vous avez dépasser le reste à payer!') ;
        }

                
        $bordereau->banque()->associate($banque) ;
        $bordereau->dossier()->associate($dossier) ;
        $bordereau->save();
        //$this->bordereau($dossier, $banque , $request['montant']); //exit;

        return redirect()->action([BordereauController::class, 'index'] , ['dossier' => $dossier])
        ->with('message','Bordereau généré et sauvegrdé !');
    }

    public function bordereau(Dossier $dossier, Bordereau $bordereau)
    {
        // create the number to words "manager" class
        $toWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $toWords->getNumberTransformer('fr');        

        $montantEnLetters = ucfirst($numberTransformer->toWords($bordereau->montant)) ;
        $pdf = Pdf::loadView('pdf.contrats.bordereau',
            ['dossier' => $dossier,
            'bordereau' => $bordereau,
            'montantEnLetters' => $montantEnLetters,
            'logo' => $dossier->produit->projet->entreprise->logo]);
        return $pdf->download('bordereau.pdf');
    }

 


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bordereau  $bordereau
     * @return \Illuminate\Http\Response
     */
    public function show(Dossier $dossier, Bordereau $bordereau)
    {

        return view('bordereaux.index', [
            'dossier' => $dossier ,
            'bordereau' => $bordereau ,
            'bordereaux' => $dossier->bordereaux()->paginate(15),
            'banques' => Banque::all(),
        ]) ;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bordereau  $bordereau
     * @return \Illuminate\Http\Response
     */
    public function edit(Bordereau $bordereau)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bordereau  $bordereau
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bordereau $bordereau)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bordereau  $bordereau
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dossier $dossier, Bordereau $bordereau)
    {
        $bordereau->delete() ;
        return redirect()->action([BordereauController::class, 'index'], ['dossier' => $dossier])
        ->with('message','Bordereau supprimé !');
    }
}
