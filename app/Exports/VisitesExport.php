<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\Visite;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\FromView;


class VisitesExport implements FromView
{
    protected $request;

 function __construct($request) {
        $this->request = $request;
 }


    /**
    * @return \Illuminate\Support\Collection
    */
	public function view(): View
    {
     //dd(Visite::interets()) ;
        $visitesAll = Visite::with('client')
                            ->with('user')
                            ->latest('created_at')->get();

        //dd($visitesAll);
        $dateStartExist = false ;
        $dateEndExist = false ;

        //recherche par prix
        if (isset($this->request['dateStart']) && $this->request['dateStart'] != '' ) {
            $ds =  $this->request['dateStart'] ;
            $dateSt = str_replace('/', '-', $ds);
            $dateStart = date('Y-m-d', strtotime($dateSt));
            $dateStartExist = true ;

        }

        //recherche par prix
        if (isset($this->request['dateEnd']) && $this->request['dateEnd'] != '' ) {
            $de =  $this->request['dateEnd'] ;
            $dateEd = str_replace('/', '-', $de);
            $dateEnd = date('Y-m-d', strtotime($dateEd));
            $dateEndExist = true ;
        }


        if ($dateStartExist == true && $dateEndExist == true)
        {
            if ($dateEnd < $dateStart) {
                $d = $dateStart ;
                $dateStart = $dateEnd ;
                $dateEnd = $d ;
            }
        }

        if ($dateStartExist == true && $dateEndExist == true)
        {
            $visitesAll = $visitesAll->whereBetween('date', [$dateStart, $dateEnd] ); 

        }elseif ($dateStartExist == true && $dateEndExist == false) {
            $visitesAll = $visitesAll->where('date' , $dateStart); 

        }elseif ($dateStartExist == false && $dateEndExist == true) {
            $visitesAll = $visitesAll->where('date' , $dateEnd); 
        }


        $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'September', 'October', 'November','Décembre'] ;

        $nombreVisites = \DB::select("
                    SELECT * FROM (
                    SELECT YEAR (date) as an, MONTH(date) as mois , COUNT(*) as nombreVisites
                    from visites
                    group by MONTH(date), YEAR(date)
                    Order by YEAR(date) desc, MONTH(date) desc
                    limit 7
                    ) as sub
                    ORDER BY an asc, mois asc            
            ");        


        return view('exports.visites', [
            'visites'       => $visitesAll,
            'totalVisites'  => Visite::all(),
            'visitesDay'    => Visite::visitesDay()[1],
                        'appelsDay'    => Visite::visitesDay()[0],

            'visitesMonth'  => Visite::visitesMonth()[1],
            'appelsMonth'  => Visite::visitesMonth()[0],

            'visitesYear'   => Visite::visitesYear()[1],
            'appelsYear'   => Visite::visitesYear()[0],

            'visitesWeek'   => Visite::visitesWeek()[1],
                        'appelsWeek'   => Visite::visitesWeek()[0],

            'interets'      => Visite::interets(),
            'sources'       => Visite::sources(),
            'dateEnd'       => $this->request['dateEnd'],
            'dateStart'     => $this->request['dateStart'], 
            'nombreVisites' => $nombreVisites,
            'mois'          => $mois, 

        ]);
    }
}
