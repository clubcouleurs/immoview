<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Bordereau;
use App\Models\Dossier;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use setasign\Fpdi\Tcpdf\Fpdi as TCPDF;
use setasign\Fpdi\Fpdi;

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

        // // initiate FPDI
        // $pdf = new TCPDF();
        // $pdf->SetTextColor(0, 0, 255) ;
        // $pdf->SetFont('Helvetica');

        // initiate FPDI
        $pdf = new FPDI();
        $pdf->SetTextColor(0, 0, 255) ;
        $pdf->SetFont('Helvetica');

        // get the page count

        $pageCount = $pdf->setSourceFile(Storage_path('app/public/bordereau.pdf'));

        // iterate through all pages

            $pdf->SetMargins(0, 0, 0 , 0) ;
            // $pdf->setPrintHeader(false);
            // $pdf->setPrintFooter(false);
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



                $pdf->SetXY(20, 65.5);
                $pdf->Write(0,$dossier->produit->tranche) ;

                $pdf->SetXY(53, 65.5);
                $pdf->Write(0,$dossier->produit->immeuble) ;

                $pdf->SetXY(87, 65.5);
                $pdf->Write(0,$dossier->produit->etage) ; 

                $pdf->SetXY(127, 65.5);
                $pdf->Write(0,$dossier->produit->constructible->num) ;


                $pdf->SetXY(157, 65.5);
                $pdf->Write(0,$dossier->produit->constructible->surface) ;
                $pdf->SetXY(47 , 76.25);
                $pdf->Write(0,$dossier->user->name) ;


            // $pdf->SetXY(141, 101);
            // $pdf->Write(0, ucfirst($dossier->client->mobile)); 
            // $pdf->SetXY(19, 101);
            // $pdf->Write(0, ucfirst($dossier->client->cin));
            // $prenom = stripslashes($dossier->client->prenom);
            // $nom = stripslashes($dossier->client->nom);
            // $nomC =  $nom . ' ' . $prenom ;
            // $pdf->SetXY(50, 101);
            // $pdf->Write(0, $nomC);               
            // $adresse = stripslashes($dossier->client->adresse);
            // $pdf->SetXY(19, 117);
            // $pdf->Write(8, ucfirst(preg_replace( "/\r|\n/", " ", $adresse )));


            $txt = '' ;
                    $i = 0 ;
                foreach ($dossier->clients as $client)
                {  

                    $i += 1 ;
                    $txt .= '- Monsieur/Madame : ' ;
                    $prenom = stripslashes($client->prenom);
                    $nom = iconv('UTF-8', 'windows-1252', $prenom);

            $nom = stripslashes($client->nom);
            $nom = iconv('UTF-8', 'windows-1252', $nom);
            $nomC = ucfirst($nom) . ' ' . ucfirst($prenom) ;
            $nomC .= ' - Mobile : ' . $client->mobile ;
            $txt .= $nomC . chr(10) ;
            $txt .= 'Demeurant à : ' ;
            $adresse = stripslashes($client->adresse);
            $adresse = ucfirst(preg_replace( "/\r|\n/", " ", $adresse )) ;
            $adresse = iconv('UTF-8', 'windows-1252', $adresse);

            $ad = str_split($adresse, 45) ;

            $txt .= implode(chr(10) , $ad) . chr(10) ;

            $txt .= 'Titulaire de la carte d’identité nationale N° : ' ;

            $txt .= $client->cin  ;
                if ($i !== $dossier->clients->count() )
                {
                   $txt .= chr(10) ;
                }
            }
            $txt = iconv('UTF-8', 'windows-1252', $txt) ;
            switch ($i) {
                case 1:
                    $i = 70 + 25 ;
                    break;
                case 2:
                    $i = 70 + 20 ;
                    break;
                case 3:
                    $i = 70 + 15 ;
                    break;  
                                      
                default:
                    break;
            }
            $pdf->SetXY(20, $i);
            $pdf->MultiCell(130, 5, $txt);
            //$pdf->MultiCell(8,  $txt);





            $pdf->SetXY(195 , 60.5);

            $b = "Banque ". strtoupper($bordereau->banque->abreviation) ." COMPTE  N° :" ; 
            $b  = iconv('UTF-8', 'windows-1252', $b );

            $pdf->Write(0, $b ) ;

            $pdf->SetXY(195 , 65.5);
            $pdf->Write(0, $bordereau->banque->num) ;

            $pdf->SetXY(47, 148.5);
            $pdf->Write(0, date("j/n/Y"));   

            $pdf->SetXY(17, 161);
            $pdf->Write(0, number_format($bordereau->montant) . ' Dirhams');

            $pdf->SetXY(17, 175);
            $pdf->Write(0, ucfirst($numberTransformer->toWords($bordereau->montant)) . ' Dirhams');


        
        $pdf->Output('Bordereau_Versement_' . $dossier->produit->constructible->num
            . '_' . '.pdf', 'I'); 
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
