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
use Illuminate\Support\Facades\Gate;


class MagasinsExport implements FromView, WithColumnFormatting, WithMapping, ShouldAutoSize
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
                if (! Gate::allows('voir magasins')) {
                abort(403);
        }        
        $magasinsAll = Produit::with('constructible')
                            ->where('constructible_type','magasin')
                            ->with('etiquette')
                            ->withCount('voies')
                            ->orderByDesc('created_at')
                            ->get();
        $magasinsAll = $magasinsAll->sortBy('constructible.id') ;
                            
        $magasinsReserved = $magasinsAll->where('etiquette_id', 3)->count() ;
        $magasinsStocked = $magasinsAll->where('etiquette_id', 2)->count() ;
        $magasinsBlocked = $magasinsAll->whereNotIn('etiquette_id', [3,2,9])->count() ;
        $magasinsR = $magasinsAll->whereNotIn('etiquette_id', [9])->count() ;

        //selectionner les appartements 
        //$magasinsAll = $magasinsAll->whereNotNull('appartement.id' ); 

        $maxPrix = $magasinsAll->max('prixM2Indicatif');
        $minPrix = $magasinsAll->min('prixM2Indicatif');  
        $nums = [];

        //recherche par numéro des appartement
        if (isset($this->request['numsappartement']) && $this->request['numsappartement'] != '' ) {
            $numsappartement = preg_split("/[\s,\.]+/", $this->request['numsappartement']);
            $numsappartement = array_map('trim', $numsappartement);
            $magasinsAll = $magasinsAll->whereIn('constructible.num', $numsappartement);
        }

        //recherche par prix
        if (isset($this->request['minPrix']) && $this->request['minPrix'] != '' ) {
            $minPrix = intval($this->request['minPrix']) ;
        }

        //recherche par prix
        if (isset($this->request['maxPrix']) && $this->request['maxPrix'] != '' ) {
            $maxPrix = floatval($this->request['maxPrix']) ;
        }

        $magasinsAll = $magasinsAll->whereBetween('prixM2Indicatif', [$minPrix, $maxPrix] ); 


        //recherche par tranche
        if (isset($this->request['tranche']) && $this->request['tranche'] != '-' ) {
            $tr = $this->request['tranche'] ;

            $magasinsAll = $magasinsAll->filter(function ($item) use ($tr)  {

                    if ($item->constructible->immeuble->tranche_id == $tr) {
                        return true;
                    }
                        return false;
            });

            //$appartementsAll = $appartementsAll->where('constructible.immeuble_id', $tr); 
        }

        //recherche par immeuble
        if (isset($this->request['immeuble']) && $this->request['immeuble'] != '-' ) {
            $imm = $this->request['immeuble'] ;
            $magasinsAll = $magasinsAll->where('constructible.immeuble_id', $imm); 
        }

        //recherche par nombre de façades
        if (isset($this->request['nombreFacadesappartement']) && $this->request['nombreFacadesappartement'] != '-' ) {
            $fa = $this->request['nombreFacadesappartement'] ;
            $magasinsAll = $magasinsAll->where('voies_count', $fa); 
        }

        //recherche par nombre d'etages
        if (isset($this->request['etage']) && $this->request['etage'] != '-' ) {
            $et = $this->request['etage'] ;
            $magasinsAll = $magasinsAll->where('constructible.etage', $et); 
        }  

        //recherche par type de appartement
        if (isset($this->request['type']) && $this->request['type'] != '-' ) {
            $ty = $this->request['type'] ;
            $magasinsAll = $magasinsAll->where('constructible.type', $ty);  
        }           

        //recherche par etat du appartement
        if (isset($this->request['etatProduit']) && $this->request['etatProduit'] != '-' ) {
            $etat = $this->request['etatProduit'] ;
            $magasinsAll = $magasinsAll->where('etiquette_id', $etat);  
        }           

        $total = 0 ;
           $prixTotalappartements = $magasinsAll->map(function ($item, $key) use ($total) {
                    return $total = $total + $item->totalIndicatif;
        });

        return view('exports.magasins', [
            'magasins'              => $magasinsAll,
            // 'totalMagasins'         => $magasinsAll->count(),
            // 'immeubles'              =>Immeuble::all(),
            // 'etiquettes'            =>Etiquette::all(),
            // 'valeurTotal'           => $prixTotalappartements->sum(),
            // 'tranches'                  =>Tranche::all(),
            // 'magasinsReserved'       => $magasinsReserved,
            // 'magasinsBlocked'        => $magasinsBlocked,
            // 'magasinsStocked'        => $magasinsStocked,
            // 'magasinsR'             => $magasinsR, 
            // 'SearchByImm'           => $this->request['immeuble'] ,
            // 'SearchByFacade'        => $this->request['nombreFacadesappartement'] ,
            // 'SearchByEtage'         => $this->request['etage'] ,
            // 'SearchByEtat'          => $this->request['etatProduit'] ,
            // 'SearchByType'          => $this->request['type'] ,
            // 'SearchByMin'           => $this->request['minPrix'] ,
            // 'SearchByMax'           => $this->request['maxPrix'] ,
            // 'SearchByNum'           => $this->request['numsappartement'] ,
            // 'SearchByTr'           => $this->request['tranche'] ,
        ]);

    }
}
