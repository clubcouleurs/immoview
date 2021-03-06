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


class StockExport implements FromView, WithColumnFormatting, WithMapping, ShouldAutoSize
{


    public function map($invoice): array
    {
        return [];
    }
    
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
	public function view(): View
    {

        //créer un tableau contenant tout les types de constructibles
        $constructibleArray = ['appartement' ,'lot',  'bureau' , 'magasin' , 'box', 'showroom'] ;

        //une boucle pour collecter la data selon le type de constructible
        foreach ($constructibleArray as $constructible) {
        if ($constructible == 'showroom') {  
            ${$constructible . 'Dossiers'} = Produit::where('constructible_type', 'lot')
                            ->with('dossier')
                            ->with('constructible')
                            ->whereHasMorph(
                                    'constructible',
                                    [Lot::class],
                                    function (Builder $query) {
                                        $query->where('type', '=', 'showroom');
                                    }
                                )
                            ->with('paiements')
                            ->get();           
        }elseif($constructible == 'lot')
        {
            ${$constructible . 'Dossiers'} = Produit::where('constructible_type', $constructible)
                            ->with('dossier')
                            ->with('constructible')
                            ->whereHasMorph(
                                    'constructible',
                                    [Lot::class],
                                    function (Builder $query) {
                                        $query->where('type', '=', 'commercial');
                                    }
                                )
                            ->with('paiements')
                            ->get();
        }else
        {
            ${$constructible . 'Dossiers'} = Produit::where('constructible_type', $constructible)
                            ->with('dossier')
                            ->with('constructible')
                            ->with('paiements')
                            ->get();
        }
        // faire un groupement par tranche selon le type de constructible
            switch ($constructible)
            {
                 case 'lot':
                 case 'showroom':
                    ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                            ->groupBy('constructible.tranche_id');

                     break;
                 case 'appartement':
                 case 'magasin':
                 case 'box':
                    ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                            ->groupBy('constructible.immeuble.tranche_id');
                     break;
                 case 'bureau':
                    ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                            ->groupBy('constructible.situable.immeuble.tranche_id');
                     break;                      
                 default:
                     break;
             }


        ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}
                        ->map(function ($item, $key) use ($constructible){
            return $item->map(function ($item, $key) use ($constructible){
                    return
                    [
               'total' . $constructible   => 1 ,
               'vendus'. $constructible
                            => ($item->dossier !== null && $item->dossier->isVente == true ) ? 1 :0 ,       
               'reserved'. $constructible
                            => ($item->dossier !== null && $item->dossier->isVente == false ) ? 1 :0 ,  
               'stocked'. $constructible
                            => ($item->etiquette_id == 2 ) ? 1 : 0,
               'blocked'. $constructible
                            => (!in_array($item->etiquette_id, [2,3,9])) ? 1 : 0,
                    ];
            });
        });
        ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}->map(function ($item, $key) 
            use ($constructible){
                return
                [
                'total' 
                    => $item->sum('total'. $constructible) ,
                'vendus' 
                    => $item->sum('vendus'. $constructible) ,
                'reserved'
                    => $item->sum('reserved'. $constructible) ,
                'stocked'
                    => $item->sum('stocked'. $constructible) ,
               'blocked'
                    => $item->sum('blocked'. $constructible) ,              
                ]  ;    
        });
                        $total  = 0 ;
                        $vendus = 0 ;
                        $reserved = 0 ;
                        $stocked = 0 ;
                        $blocked = 0 ;

        foreach (${$constructible. 'Dossiers'} as $data) {
                                    $total  += $data['total'] ;
                                    $vendus += $data['vendus']  ;
                                    $reserved += $data['reserved']  ;
                                    $stocked += $data['stocked']  ;
                                    $blocked += $data['blocked']  ;
                                  }  

        ${$constructible. 's' . 'Dossiers'} = collect(
            ['total' => $total,
            'vendus' => $vendus,
            'reserved' => $reserved,
            'stocked' => $stocked,
            'blocked' => $blocked,
        ]) ; 

        //dd(${$constructible. 's' . 'Dossiers'}) ;
        if ($constructible !== 'showroom')
        {
            ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}->mapWithKeys(function ($item, $key) {
                return ['Tranche '.$key => $item];
            });
            
        }else
        {
            ${$constructible . 'Dossiers'} = ${$constructible . 'Dossiers'}->mapWithKeys(function ($item, $key) {
                return ['Showroom' => $item];
            });
            }            
        }


        $lotsDossiers = $lotsDossiers->map(function ($item1, $key1) use ($showroomsDossiers){
            foreach ($showroomsDossiers as $key => $value) {
                if ($key == $key1) {
                    $a = 0 ;
                    $a = ($item1 + $value) ;
                }
            }
            return $a ;            
        });

        $lotDossiers = $lotDossiers->merge($showroomDossiers);

        return view('exports.stocks',

            ['color' => [ '#86EFAC' ,'#D8B4FE','#93C5FD' , '#FCA5A5' , '#FDE047','#A5B4FC'], 
                'constructibles' => [
                'Lots' => 'lot',
                'Appartements'=>'appartement',
                'Bureaux' => 'bureau',
                'Magasins' =>'magasin',
                'Boxes' => 'box',
                //'Showrooms' => 'showroom'
            ]
            ] +
            ['appartement' => $appartementDossiers] +
            ['Appartements' => $appartementsDossiers] +
                                    ['lot' => $lotDossiers] +
                                    ['Lots' => $lotsDossiers] +

                                    ['magasin' => $magasinDossiers] + 
                                    ['Magasins' => $magasinsDossiers] +

                                    ['box' => $boxDossiers] + 
                                    ['Boxes' => $boxsDossiers] +

                                    ['bureau' => $bureauDossiers] +
                                    ['Bureaux' => $bureausDossiers]// +
                                    //['showroom' => $showroomDossiers] +
                                    //['Showrooms' => $showroomsDossiers]                                    

        ) ;        
    }
}
