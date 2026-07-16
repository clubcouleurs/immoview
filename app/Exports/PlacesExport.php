<?php

namespace App\Exports;

use App\Models\place;
use App\Models\Box;
use App\Models\Etiquette;
use App\Models\Immeuble;
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


class PlacesExport implements FromView, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    protected $request;

 function __construct($request) {
        $this->request = $request;
 }

    public function map($invoice): array
    {
        return [];
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


            $placesAll = Produit::with('constructible')
                                ->where('constructible_type','place')
                                ->with('etiquette')
                                ->withCount('voies')
                                ->orderByDesc('created_at')
                                ->get();

     

        $placesAll = $placesAll->sortBy('constructible.num') ;
        $placesReserved = $placesAll->where('etiquette_id', 3)->count() ;
        $placesStocked = $placesAll->where('etiquette_id', 2)->count() ;
        $placesR = $placesAll->where('etiquette_id', 9)->count() ;
        $placesBlocked = $placesAll->whereNotIn('etiquette_id', [3,2,9])->count() ;

        //selectionner les places 
        //$placesAll = $placesAll->whereNotNull('place.id' ); 

        $maxPrix = $placesAll->max('prixM2Indicatif');
        $minPrix = $placesAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des place
        if (isset($this->request['numsplace']) && $this->request['numsplace'] != '' ) {
            $numsplace = preg_split("/[\s,\.]+/", $this->request['numsplace']);
            $numsplace = array_map('trim', $numsplace);
            $placesAll = $placesAll->whereIn('constructible.num', $numsplace);
        }

        //recherche par prix
        if (isset($this->request['minPrix']) && $this->request['minPrix'] != '' ) {
            $minPrix = intval($this->request['minPrix']) ;
        }

        //recherche par prix
        if (isset($this->request['maxPrix']) && $this->request['maxPrix'] != '' ) {
            $maxPrix = floatval($this->request['maxPrix']) ;
            $placesAll = $placesAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 

        }


        //recherche par tranche
        if (isset($this->request['immeuble']) && $this->request['immeuble'] != '-' ) {
            $tr = $this->request['immeuble'] ;
            $placesAll = $placesAll->where('constructible.immeuble_id', $tr); 
        }

        //recherche par nombre de façades
        if (isset($this->request['nombreFacadesplace']) && $this->request['nombreFacadesplace'] != '-' ) {
            $fa = $this->request['nombreFacadesplace'] ;
            $placesAll = $placesAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($this->request['etage']) && $this->request['etage'] != '-' ) {
            $et = $this->request['etage'] ;
            $placesAll = $placesAll->where('constructible.etage', $et); 
        }  

        //recherche par type de place
        if (isset($this->request['type']) && $this->request['type'] != '-' ) {
            $ty = $this->request['type'] ;
            $placesAll = $placesAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du place
        if (isset($this->request['etatProduit']) && $this->request['etatProduit'] != '-' ) {
            $etat = $this->request['etatProduit'] ;
            $placesAll = $placesAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalplaces = $placesAll->map(function ($item, $key) use ($total) {
               return $total = $total + $item->totalIndicatif;
        });

   
        return view('exports.places', [
            'places'              => $placesAll ,
            'totalplaces'         => $placesAll->count(),
            'immeubles'                 =>Immeuble::all(),
            'etiquettes'                =>Etiquette::all(),
            'valeurTotal'               => $prixTotalplaces->sum(),

            'placesReserved'      => $placesReserved,
            'placesBlocked'       => $placesBlocked,
            'placesStocked'       => $placesStocked,
            'placesR'            => $placesR,

            'SearchByImm'           => $this->request['immeuble'] ,
            'SearchByFacade'        => $this->request['nombreFacadesplace'] ,
            'SearchByEtage'     => $this->request['etage'] ,
            'SearchByEtat'     => $this->request['etatProduit'] ,
            'SearchByType'     => $this->request['type'] ,
            'SearchByMin'     => $this->request['minPrix'] ,
            'SearchByMax'     => $this->request['maxPrix'] ,
            'SearchByNum' => $this->request['numsplace'] ,

        ]);


    }
}
