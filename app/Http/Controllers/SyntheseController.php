<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class SyntheseController extends Controller
{
    public function Synthese (Request $request)
    {
        $request->validate([
            'dossier'      => 'required|numeric',
            'type'      => 'required|string',
        ]); 
        $dossier = Dossier::findOrFail($request['dossier']);

        // initiate FPDI
        $pdf = new FPDI();
        //$pdf->SetTextColor(126, 139, 156) ;
        $pdf->SetTextColor(0, 0, 0) ;
        $pdf->SetFont('Helvetica');

        $pageCount = $pdf->setSourceFile(Storage_path('app/public/synthese.pdf'));

        // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->SetMargins(0, 0, 0 , 0) ;

            // import a page
            $templateId = $pdf->importPage($pageNo); //$pageNo
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            //dd($size) ;
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);
            if ($pageNo == 1)
            {
                $pdf->SetFontSize(20);
                $natureContrat = $request['type'];
                if ($natureContrat == 'compromis') {
                    $pdf->Image(Storage_path('app/public/' . $natureContrat . '.jpg'), 77 , 31.5 ,-300);
                    $pdf->SetXY(78.75, 32.5);
                    $pdf->Write(8,'X');   
                }elseif ($natureContrat == 'acte'){
                    $pdf->Image(Storage_path('app/public/' . $natureContrat . '.jpg'), 77 , 31.5 ,-300);
                    $pdf->SetXY(78.75, 32.5);
                    $pdf->Write(8,'X');   
                }
                $pdf->Ln(0.5); 
                $pdf->SetFontSize(11);
            $pdf->SetXY(10, 59);
            $pdf->Write(8, 'Agadir, Le : ' .  date("j/n/Y"));   

            $pdf->SetXY(79, 51);
            $pdf->Write(8, ucfirst($dossier->produit->constructible->num));   

            $pdf->SetXY(123, 51);
            $pdf->Write(8, ucfirst($dossier->produit->constructible->titre_foncier));   

            $pdf->SetXY(185, 51);
            $pdf->Write(8, ucfirst($dossier->produit->constructible->tranche_id));    

            $pdf->SetXY(89, 61);
            $pdf->Write(0, 
                $dossier->produit->constructible->surface   .'m2'
            );

            $pdf->SetXY(117, 61);
            $pdf->Write(0, $dossier->produit->constructible->etage);

            $pdf->SetXY(82, 63);
            $pdf->Write(8, $dossier->produit->prix . ' DHS');

            $priceTotal = number_format($dossier->produit->total,2, ',' , '.') . ' DHS';
            $pdf->SetXY(137, 63);
            $pdf->Write(8, $priceTotal);   
          

            $pdf->SetXY(185, 57);
            $pdf->Write(8, 'HC' ); 

                    $i = 0 ;
                    $x = 10 ; 
                    $y = 74 ;
                foreach ($dossier->clients as $client)
                {  
                    $txt = '' ;
                    $i += 1 ;
                    $txt .= 'NOM ET PRENOM : ' . chr(10);
                    $prenom = stripslashes($client->prenom);
                    $nom = iconv('UTF-8', 'windows-1252', $prenom);
                    $nom = stripslashes($client->nom);
                    $nom = iconv('UTF-8', 'windows-1252', $nom);
                    $nomC = ucfirst($nom) . ' ' . ucfirst($prenom) ;
                    if (strlen($nomC) > 30)  {
                        $lastSpaceIndex = strrpos($nomC, ' '); 
                        $stringToGoToNextLine = substr($nomC, $lastSpaceIndex + 1) ;
                        $stringToStayInPlace = substr($nomC, - strlen($nomC), $lastSpaceIndex);
                        $nomC = $stringToStayInPlace . chr(10) . $stringToGoToNextLine ;
                    }
                        $txt .= $nomC . chr(10) ;
                        $txt .= 'ADRESSE : ' . chr(10) ;
                        $adresse = stripslashes($client->adresse);
                        $adresse = ucfirst(preg_replace( "/\r|\n/", " ", $adresse )) ;
                        $adresse = iconv('UTF-8', 'windows-1252', $adresse);
                        $ad = str_split($adresse, 33) ;
                        $txt .= implode(chr(10) , $ad) . chr(10) ;
                        $txt .= iconv('UTF-8', 'windows-1252', 'CIN : ' );
                        $txt .= $client->cin . chr(10) ;
                        $txt .= iconv('UTF-8', 'windows-1252', 'N° TEL : ' );
                        $txt .= $client->mobile . chr(10) ;
                        $txt .= 'Signature : ' . chr(10) ;

            if ($i > 1 ) {

                if ($i % 2 == 0) {
                    $x = $x + 95 ;
                    $y =74 + ((($i/2)-1) * 56 ) ;
                }else
                {
                    $y = $y + 56 ;
                    $x = 10 ;
                }
            }
                $pdf->Image(Storage_path('app/public/client.jpg'), $x , $y ,-300);
                $pdf->SetXY($x + 8, $y + 7);
                $pdf->MultiCell(0,5, $txt);
        }
        ++$i ;
            if ($i > 1 ) {
                if ($i % 2 == 0) {

                    $x = $x + 95 ;
                    $y =74 + ((($i/2)-1) * 56 ) ;
                }else
                {
                    $y = $y + 56 ;
                    $x = 10 ;
                }
            }

                $pdf->Image(Storage_path('app/public/paiement.jpg'), $x , $y ,-300);
                $x2 = $x + 8 ;
                $y2 = $y + 10 ;
                $l = 0 ;
            foreach ($dossier->paiements as $paiement)
            {
                $pdf->SetXY($x2 , $y2 + $l );
                $pdf->Write(8, $paiement->date);   

                $pdf->SetXY($x2+30 , $y2 + $l);
                $pdf->Write(8, number_format($paiement->montant,2, ',' , '.') . ' DHS'); 
                $l = $l + 4 ;
            }
            $l = $l + 3 ;
            $pdf->Line($x2-4, $y2+$l , $x2-4 + 78, $y2+$l);
            $pdf->SetLineWidth(0.5);
            $pdf->SetDrawColor(126, 139, 156);
            $pdf->SetFontSize(13) ;
            $l = $l + 4.5 ;    
            $priceTotal = number_format($dossier->TotalPaiementsV,2, ',' , '.') . ' DHS';
            $pdf->SetXY($x2, $y2+$l);
            $pdf->Write(0, 'Total Avances : ' . $priceTotal);   
            $l = $l + 4.5 ;
            $priceTotal = number_format($dossier->Reliquat,2, ',' , '.') . ' DHS';
            $pdf->SetXY($x2, $y2+$l);
            $pdf->Write(0, 'Reliquat Restant : ' . $priceTotal);   

                ++$i ;
            if ($i > 1 ) {
                if ($i % 2 == 0) {

                    $x = $x + 95 ;
                    $y =74 + ((($i/2)-1) * 56 ) ;
                }else
                {
                    $y = $y + 56 ;
                    $x = 10 ;
                }
            }
                $pdf->Image(Storage_path('app/public/visa.jpg'), $x , $y ,-300);


          

            }  

        }

        // Output the new PDF
        $pdf->Output('D', 'actes_reservation_lot_N_' . $dossier->produit->constructible->num
            . '_' . '.pdf', true);
    }

}
