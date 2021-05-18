<?php

namespace App\Exports;

use App\Models\Appartement;
use App\Models\Box;
use App\Models\Etiquette;
use App\Models\Lot;
use App\Models\Magasin;
use App\Models\Office;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Tranche;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class LotsExport implements FromView, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    protected $request;

 function __construct($request) {
        $this->request = $request;
 }

    public function map($invoice): array
    {
        return [
            // $invoice->invoice_number,
            // Date::dateTimeToExcel($invoice->created_at),
            // $invoice->total
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
	public function view(): View
    {
        $lotsAll = Produit::with('constructible')
                            ->where('constructible_type','lot')
                            ->with('etiquette')
                            ->withCount('voies')
                            ->orderByDesc('created_at')
                            ->get();
        $lotsAll = $lotsAll->sortBy('constructible.num') ;

        $lotsReserved = $lotsAll->where('etiquette_id', 3)->count() ;
        $lotsStocked = $lotsAll->where('etiquette_id', 2)->count() ;
        $lotsR = $lotsAll->where('etiquette_id', 9)->count() ;
        $lotsBlocked = $lotsAll->whereNotIn('etiquette_id', [3,2,9])->count() ;                            
        
        //selectionner les lots 
        //$lotsAll = $lotsAll->whereNotNull('lot.id' ); 

        $maxPrix = $lotsAll->max('prixM2Indicatif');
        $minPrix = $lotsAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des lot
        if (isset($this->request['numsLot']) && $this->request['numsLot'] != '' ) {
            $numsLot = preg_split("/[\s,\.]+/", $this->request['numsLot']);
            $numsLot = array_map('trim', $numsLot);
            $lotsAll = $lotsAll->whereIn('constructible.num', $numsLot);
        }

        //recherche par prix
        if (isset($this->request['minPrix']) && $this->request['minPrix'] != '' ) {
            $minPrix = intval($this->request['minPrix']) ;
        }

        //recherche par prix
        if (isset($this->request['maxPrix']) && $this->request['maxPrix'] != '' ) {
            $maxPrix = floatval($this->request['maxPrix']) ;
        }

        $lotsAll = $lotsAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 

        //recherche par tranche
        if (isset($this->request['tranche']) && $this->request['tranche'] != '-' ) {
            $tr = $this->request['tranche'] ;
            $lotsAll = $lotsAll->where('constructible.tranche_id', $tr); 
        }

        //recherche par nombre de façades
        if (isset($this->request['nombreFacadesLot']) && $this->request['nombreFacadesLot'] != '-' ) {
            $fa = $this->request['nombreFacadesLot'] ;
            $lotsAll = $lotsAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($this->request['etage']) && $this->request['etage'] != '-' ) {
            $et = $this->request['etage'] ;
            $lotsAll = $lotsAll->where('constructible.etage', $et); 
        }  

        //recherche par type de lot
        if (isset($this->request['type']) && $this->request['type'] != '-' ) {
            $ty = $this->request['type'] ;
            $lotsAll = $lotsAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du lot
        if (isset($this->request['etatProduit']) && $this->request['etatProduit'] != '-' ) {
            $etat = $this->request['etatProduit'] ;
            $lotsAll = $lotsAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalLots = $lotsAll->map(function ($item, $key) use ($total) {
                return $total = $total + $item->totalIndicatif;
        });


        return view('exports.lots', [
            'lots'              => $lotsAll,
            'totalLots'         => $lotsAll->count(),
            'tranches'          =>Tranche::all(),
            'etiquettes'          =>Etiquette::all(),
            'valeurTotal'       => $prixTotalLots->sum(),

            'lotsReserved'       => $lotsReserved,
            'lotsBlocked'        => $lotsBlocked,
            'lotsStocked'        => $lotsStocked,
            'lotsR'             => $lotsR,
            
            'SearchByTranche'   => $this->request['tranche'] ,
            'SearchByFacade'    => $this->request['nombreFacadesLot'] ,
            'SearchByEtage'     => $this->request['etage'] ,
            'SearchByEtat'     => $this->request['etatProduit'] ,
            'SearchByType'     => $this->request['type'] ,
            'SearchByMin'     => $this->request['minPrix'] ,
            'SearchByMax'     => $this->request['maxPrix'] ,
            'SearchByNum' => $this->request['numsLot'] ,

        ]);
    }
}
