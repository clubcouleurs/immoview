<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class SyntheseController extends Controller
{
    public function Synthese (Request $request)
    {
        $y = 75 ;
        $nbr_box = 0 ;
        $request->validate([
            'dossier'      => 'required|numeric',
            'type'      => 'required|string',
            'titre_foncier'      => 'sometimes|string',
        ]); 
        $dossier = Dossier::findOrFail($request['dossier']);
        $coeficient = 16 * (1- (count($dossier->clients) / 10) ) ; 

        // initiate FPDI
        $pdf = new FPDI();
        //$pdf->SetTextColor(126, 139, 156) ;
        $pdf->SetTextColor(0, 0, 0) ;
        $pdf->SetFont('Helvetica');

        $pageCount = $pdf->setSourceFile(Storage_path('app/public/synthese-2.pdf'));

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
                    ///$pdf->Image(Storage_path('app/public/' . $natureContrat . '.jpg'), 77 , 31.5 ,-300);
                    $pdf->SetXY(60, $y);
                    $pdf->Write(8,'Objet : Compromis de vente' );   
                }elseif ($natureContrat == 'acte'){
                    //$pdf->Image(Storage_path('app/public/' . $natureContrat . '.jpg'), 77 , 31.5 ,-300);
                    $pdf->SetXY(60, $y);
                    $pdf->Write(8,'Objet : Acte de vente' );   
                }
                //$pdf->SetFont('Times','B');
                $pdf->SetFontSize(12);

                $y = $y + $coeficient ;
                $this->toBold($pdf);
            $pdf->SetXY(85, $y);
            $pdf->Write(8, 'Agadir, Le : ' .  date("j/n/Y"));   
                $this->toRegular($pdf);
                $y = $y + 16 ;
            $pdf->SetXY(20, $y);
            $pdf->Write(8,iconv('UTF-8', 'windows-1252', 'Numéro du Lot : '));
                $this->toBold($pdf);
            $pdf->SetXY(50, $y);
            $pdf->Write(8,$dossier->produit->constructible->num);            
                $this->toRegular($pdf);
            $y = $y + $coeficient ;
            $t = '' ;
            if ($request['titre_foncier'] == "oui") {
                $t = $dossier->produit->constructible->titre_foncier ;   
            }
                $pdf->SetXY(20, $y);
                $pdf->Write(8, ucfirst('Titre Foncier : '));   
                    $this->toBold($pdf);
                $pdf->SetXY(46, $y);
                $pdf->Write(8,  $t );   
                    $this->toRegular($pdf);

            $y = $y + $coeficient ;
                $pdf->SetXY(20, $y);
                $pdf->Write(8, ucfirst('Clients ('. count($dossier->clients) .') :'));   

                    $i = 0 ;
                    $x = 0 ; 
                    //$y = 74 ;
                foreach ($dossier->clients as $key => $client)
                {  
                    $nbr_box += 1 ;
                    $txt = '' ;
                    $i += 1 ;
                    $txt .= ('(' . ($key+1) . ')') . ' - ' ;
                    $txt .= iconv('UTF-8', 'windows-1252', 'Nom et Prénom : '); 
                    $prenom = stripslashes($client->prenom);
                    $nom = iconv('UTF-8', 'windows-1252', $prenom);
                    $nom = stripslashes($client->nom);
                    $nom = iconv('UTF-8', 'windows-1252', $nom);
                    $nomC = ucfirst($nom) . ' ' . ucfirst($prenom) ;
                    // if (strlen($nomC) > 20)  {
                    //     $lastSpaceIndex = strrpos($nomC, ' '); 
                    //     $stringToGoToNextLine = substr($nomC, $lastSpaceIndex + 1) ;
                    //     $stringToStayInPlace = substr($nomC, - strlen($nomC), $lastSpaceIndex);
                    //     $nomC = $stringToStayInPlace . chr(10) . $stringToGoToNextLine ;
                    // }
                        $txt .= $nomC  ;
                        $txt .= ', Adresse : '  ;
                        $adresse = stripslashes($client->adresse);
                        $adresse = ucfirst(preg_replace( "/\r|\n/", " ", $adresse )) ;
                        $adresse = iconv('UTF-8', 'windows-1252', $adresse);
                        $txt .= $adresse ;
                        $txt .= iconv('UTF-8', 'windows-1252', ', CIN : ' );
                        $txt .=  $client->cin  ;
                        $txt .= iconv('UTF-8', 'windows-1252', ', N° TEL : ' );
                        $txt .=  $client->mobile  ;
                        $ad = str_split($txt, 72) ;
                        if (count($ad) > 1) {
                            $ad[0] = $ad[0] . '-' ; 
                        }
                        $txt = implode(chr(10) , $ad) ;
                        if ($i == 1) {
                            $y = $y +  6 ;
                        }else
                        {
                            $y = $y + count($ad) * 6 ;
                        }
                $pdf->SetXY(20, $y );
                $this->toBold($pdf);
                $pdf->MultiCell(0,5, $txt);
                $this->toRegular($pdf);
        }
            $y += 14 ;
            $pdf->SetXY(20, $y);
            $pdf->Write(8, 'Tranche : ');    
                $this->toBold($pdf);
                $pdf->SetXY(38, $y);
                $pdf->Write(8, $dossier->produit->constructible->tranche_id);    
                $this->toRegular($pdf);

            $y += $coeficient ;
            $pdf->SetXY(20, $y);
            $pdf->Write(8, 'Superficie : ');
                $this->toBold($pdf);
                $pdf->SetXY(42, $y);
                $pdf->Write(8, $dossier->produit->constructible->surface   .'m2');            
                $this->toRegular($pdf);
            $y += $coeficient ;
            $pdf->SetXY(20, $y);
            $pdf->Write(8, iconv('UTF-8', 'windows-1252', 'Nombre d’étage : ' ));
                $this->toBold($pdf);
                $pdf->SetXY(50, $y);            
                $pdf->Write(8,$dossier->produit->constructible->etage);            
                $this->toRegular($pdf);
            $y += $coeficient ;
            $pdf->SetXY(20, $y);
            $pdf->Write(8, iconv('UTF-8', 'windows-1252', 'Référence produit : ' ) ); 
                $this->toBold($pdf);
                $pdf->SetXY(54, $y);
                $pdf->Write(8, 'HC' );                 
                $this->toRegular($pdf);
            $y += $coeficient ;

            $pdf->SetXY(20, $y);
            $pdf->Write(8, 'Prix m2 : ');
                $this->toBold($pdf);
                $pdf->SetXY(39, $y);
                $pdf->Write(8, $dossier->produit->prix . ' DHS');
                $this->toRegular($pdf);
            $y += $coeficient ;
            $priceTotal = number_format($dossier->produit->total,2, ',' , '.') . ' DHS';
            $pdf->SetXY(20, $y);
            $pdf->Write(8, 'Prix de Vente : ' );   
                $this->toBold($pdf);
                    $pdf->SetXY(48, $y);
                    $pdf->Write(8, $priceTotal);                 
                $this->toRegular($pdf);                            

            // foreach ($dossier->paiements as $paiement)
            // {
            //     $pdf->SetXY($x2 , $y2 + $l );
            //     //$pdf->Write(8, $paiement->date);   

            //     $pdf->SetXY($x2+30 , $y2 + $l);
            //     //$pdf->Write(8, number_format($paiement->montant,2, ',' , '.') . ' DHS'); 
            //     $l = $l + 4 ;
            // }
            //$l = $l + 3 ;
            //$pdf->SetFontSize(13) ;
            //$l = $l + 4.5 ;   
            $y += $coeficient ; 
            $priceTotal = number_format($dossier->TotalPaiementsV,2, ',' , '.') . ' DHS';

            $pdf->SetXY(20, $y);
            $pdf->Write(8, 'Total Avance : '); 
                $this->toBold($pdf);
            $pdf->SetXY(46, $y);
            $pdf->Write(8, $priceTotal); 
                $this->toRegular($pdf);
            $y += $coeficient ; 
            $priceTotal = number_format($dossier->Reliquat,2, ',' , '.') . ' DHS';
            $pdf->SetXY(20 , $y);
            $pdf->Write(8, 'Reliquat restant : ');
                $this->toBold($pdf); 
                $pdf->SetXY(51 , $y);
                $pdf->Write(8, $priceTotal);                
                $this->toRegular($pdf);
            $pdf->SetXY(40 , 269);
            $pdf->Write(0, 'Signature promoteur : '  ); 
            $pdf->SetXY(140 , 269);
            $pdf->Write(0, 'Signature client : ' ); 

                //$pdf->SetXY(20, $y);
                //$pdf->Image(Storage_path('app/public/visa.jpg'), 10 , 240 ,-300);
            }  

        }

        // Output the new PDF
        $pdf->Output('D', 'synthese_situation_lot_N_' . $dossier->produit->constructible->num
            . '_' . '.pdf', true);
    }

    public function toBold($pdf)
    {
      $pdf->SetFont('Times','B');
    }
    public function toRegular($pdf)
    {
      $pdf->SetFont('Times');
    }    

}
