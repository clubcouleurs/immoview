<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Bordereau;
use App\Models\Dossier;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use setasign\Fpdi\Tcpdf\Fpdi as TCPDF;

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
            'bordereaux' => $dossier->bordereaux()->paginate(15),
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

         // outputs "five thousand one hundred twenty"

        // initiate FPDI
        $pdf = new TCPDF();
        $pdf->SetTextColor(0, 0, 255) ;
        $pdf->SetFont('Helvetica');

        // get the page count

        $pageCount = $pdf->setSourceFile(Storage_path('app/public/bordereau.pdf'));

        // iterate through all pages

            $pdf->SetMargins(0, 0, 0 , 0) ;
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // import a page
            $templateId = $pdf->importPage(1); //$pageNo
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);

            // create a page (landscape or portrait depending on the imported page size)
            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);

            $pdf->SetXY(141, 101);
            $pdf->Write(0, ucfirst($dossier->client->mobile)); 

                $pdf->SetXY(20, 62.5);
                $pdf->Write(0,$dossier->produit->constructible->immeuble->tranche->num) ;

                $pdf->SetXY(53, 62.5);
                $pdf->Write(0,$dossier->produit->constructible->immeuble->num) ;

                $pdf->SetXY(87, 62.5);
                $pdf->Write(0,$dossier->produit->constructible->etage) ; 

                $pdf->SetXY(127, 62.5);
                $pdf->Write(0,$dossier->produit->constructible->num) ;


                $pdf->SetXY(157, 62.5);
                $pdf->Write(0,$dossier->produit->constructible->surface) ;


                $pdf->SetXY(47 , 73.25);
                $pdf->Write(0,$dossier->user->name) ;

            $pdf->SetXY(19, 101);
            $pdf->Write(0, ucfirst($dossier->client->cin));
                
            $prenom = stripslashes($dossier->client->prenom);
            $nom = stripslashes($dossier->client->nom);
            $nomC =  $nom . ' ' . $prenom ;
            $pdf->SetXY(50, 101);
            $pdf->Write(0, $nomC);               
 

            $adresse = stripslashes($dossier->client->adresse);

            $pdf->SetXY(19, 117);
            $pdf->Write(8, ucfirst(preg_replace( "/\r|\n/", " ", $adresse )));

            $pdf->SetXY(195 , 57.5);
            $pdf->Write(0, "Banque ". strtoupper($bordereau->banque->abreviation) ." COMPTE  N° :") ;

            $pdf->SetXY(195 , 62.5);
            $pdf->Write(0, $bordereau->banque->num) ;

            $pdf->SetXY(47, 145.5);
            $pdf->Write(0, date("j/n/Y"));   

            $pdf->SetXY(17, 158);
            $pdf->Write(0, number_format($bordereau->montant) . ' Dirhams');

            $pdf->SetXY(17, 172);
            $pdf->Write(0, ucfirst($numberTransformer->toWords($bordereau->montant)) . ' Dirhams');


        
        $pdf->Output('Bordereau_Versement_' . $dossier->produit->constructible->num
            . '_' . $dossier->client->nom . '_' . $dossier->client->prenom . '.pdf', 'I'); 
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
        // if (! Gate::allows('supprimer appartements')) {
        //         abort(403);
        // }          
        //dd($bordereau) ;
        $bordereau->delete() ;
        return redirect()->action([BordereauController::class, 'index'], ['dossier' => $dossier])
        ->with('message','Bordereau supprimé !');
    }
}
