<?php

namespace App\Exports;

use App\Models\Appartement;
use App\Models\Box;
use App\Models\Lot;
use App\Models\Magasin;
use App\Models\Office;
use App\Models\Paiement;
use App\Models\Produit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Builder;
// pour le formattage des colonnes 
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class PaiementsExport implements FromView, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    protected $request;

 function __construct($request) {
        $this->request = $request;
 }

    public function map($invoice): array
    {
        return [
            $invoice->invoice_number,
            Date::dateTimeToExcel($invoice->created_at),
            $invoice->total
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
	public function view(): View
    {
       $status = $this->request['status'] ;

        $statusArray = ($status == null || $status == '' || !is_numeric($status)) ?
                    [0,1] : [$status] ;

        $constructible = $this->request['constructible'] ;
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
        if (isset($this->request['num']) && $this->request['num'] != '' ) {
            $nums = preg_split("/[\s,\.]+/", $this->request['num']);
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
                        ->get();             
        }else
        {
        $paiements = Paiement::whereHas('dossier.produit', function (Builder $query) use ($constructibleArray)
                            {
                                $query->whereIn('constructible_type', $constructibleArray);
                            })
                        ->whereIn('valider', $statusArray)
                        ->get();             
        }

        $paiementsT = $paiements->sum('montant') ;
        $paiementsV = $paiements->where('valider', 1)->sum('montant') ;
        $paiementsN = $paiementsT - $paiementsV ;

        $constructibles = ['lot','appartement','box','magasin','bureau'] ;
        return view('exports.paiements', [
            'constructibles' => $constructibles ,
            'constructible' => $constructible,
            'status'    => $status,
            'paiements' => $paiements,
            'paiementsT' => $paiementsT,
            'paiementsN' => $paiementsN,
            'paiementsV' => $paiementsV,
            'totalPaiements' => Paiement::sum('montant'),
            'ca' => $ca,
            'SearchByNum' => $this->request['num'] ,

        ]) ;
    }
}
