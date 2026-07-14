<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\Paiement;
use Illuminate\Http\Request;

use NumberToWords\NumberToWords;
use setasign\Fpdi\Tcpdf\Fpdi as TCPDF;
use setasign\Fpdi\Fpdi;
use Barryvdh\DomPDF\Facade\Pdf;

class RecuController extends Controller
{
    public function recu(Dossier $dossier, Paiement $paiement)
    {
        // create the number to words "manager" class
        $toWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $toWords->getNumberTransformer('fr');        
        $montantEnLetters = ucfirst($numberTransformer->toWords($paiement->montant)) ;
        $pdf = Pdf::loadView('pdf.contrats.recu',
            ['dossier' => $dossier,
            'paiement' => $paiement,
            'montantEnLetters' => $montantEnLetters,
            'logo' => $dossier->produit->projet->entreprise->logo]);
        return $pdf->download('recu.pdf');
    }
}
