<?php

namespace App\Exports;

use App\Models\Appartement;
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


class AppartementsExport implements FromView, WithColumnFormatting, WithMapping, ShouldAutoSize
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

        if(isset($this->request['standing']) && $this->request['standing'] == 1 )
        {
            $appartementsAll = Produit::with('constructible')
                                ->where('constructible_type','appartement')
                                ->whereHasMorph(
                                    'constructible',
                                                [Appartement::class],
                                                function (Builder $qu) 
                                            {
                                                $qu->where('type', 'Standing');

                                            }
                                )
                                ->with('etiquette')
                                ->withCount('voies')
                                ->orderByDesc('created_at')
                                ->get();            
        }
        else
        {
            $appartementsAll = Produit::with('constructible')
                                ->where('constructible_type','appartement')
                                ->with('etiquette')
                                ->withCount('voies')
                                ->orderByDesc('created_at')
                                ->get();
        }

        $appartementsAll = $appartementsAll->sortBy('constructible.num') ;
        $appartementsReserved = $appartementsAll->where('etiquette_id', 3)->count() ;
        $appartementsStocked = $appartementsAll->where('etiquette_id', 2)->count() ;
        $appartementsR = $appartementsAll->where('etiquette_id', 9)->count() ;
        $appartementsBlocked = $appartementsAll->whereNotIn('etiquette_id', [3,2,9])->count() ;

        //selectionner les appartements 
        //$appartementsAll = $appartementsAll->whereNotNull('appartement.id' ); 

        $maxPrix = $appartementsAll->max('prixM2Indicatif');
        $minPrix = $appartementsAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des appartement
        if (isset($this->request['numsappartement']) && $this->request['numsappartement'] != '' ) {
            $numsappartement = preg_split("/[\s,\.]+/", $this->request['numsappartement']);
            $numsappartement = array_map('trim', $numsappartement);
            $appartementsAll = $appartementsAll->whereIn('constructible.num', $numsappartement);
        }

        //recherche par prix
        if (isset($this->request['minPrix']) && $this->request['minPrix'] != '' ) {
            $minPrix = intval($this->request['minPrix']) ;
        }

        //recherche par prix
        if (isset($this->request['maxPrix']) && $this->request['maxPrix'] != '' ) {
            $maxPrix = floatval($this->request['maxPrix']) ;
            $appartementsAll = $appartementsAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 

        }


        //recherche par tranche
        if (isset($this->request['immeuble']) && $this->request['immeuble'] != '-' ) {
            $tr = $this->request['immeuble'] ;
            $appartementsAll = $appartementsAll->where('constructible.immeuble_id', $tr); 
        }

        //recherche par nombre de façades
        if (isset($this->request['nombreFacadesappartement']) && $this->request['nombreFacadesappartement'] != '-' ) {
            $fa = $this->request['nombreFacadesappartement'] ;
            $appartementsAll = $appartementsAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($this->request['etage']) && $this->request['etage'] != '-' ) {
            $et = $this->request['etage'] ;
            $appartementsAll = $appartementsAll->where('constructible.etage', $et); 
        }  

        //recherche par type de appartement
        if (isset($this->request['type']) && $this->request['type'] != '-' ) {
            $ty = $this->request['type'] ;
            $appartementsAll = $appartementsAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du appartement
        if (isset($this->request['etatProduit']) && $this->request['etatProduit'] != '-' ) {
            $etat = $this->request['etatProduit'] ;
            $appartementsAll = $appartementsAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalappartements = $appartementsAll->map(function ($item, $key) use ($total) {
               return $total = $total + $item->totalIndicatif;
        });

   
        return view('exports.appartements', [
            'appartements'              => $appartementsAll ,
            'totalappartements'         => $appartementsAll->count(),
            'immeubles'                 =>Immeuble::all(),
            'etiquettes'                =>Etiquette::all(),
            'valeurTotal'               => $prixTotalappartements->sum(),

            'appartementsReserved'      => $appartementsReserved,
            'appartementsBlocked'       => $appartementsBlocked,
            'appartementsStocked'       => $appartementsStocked,
            'appartementsR'            => $appartementsR,

            'SearchByImm'           => $this->request['immeuble'] ,
            'SearchByFacade'        => $this->request['nombreFacadesappartement'] ,
            'SearchByEtage'     => $this->request['etage'] ,
            'SearchByEtat'     => $this->request['etatProduit'] ,
            'SearchByType'     => $this->request['type'] ,
            'SearchByMin'     => $this->request['minPrix'] ,
            'SearchByMax'     => $this->request['maxPrix'] ,
            'SearchByNum' => $this->request['numsappartement'] ,

        ]);


    }
}
