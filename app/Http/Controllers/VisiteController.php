<?php

namespace App\Http\Controllers;

use App\Http\Traits\PaginateTrait;
use App\Models\Client;
use App\Models\Visite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitesExport;

class VisiteController extends Controller
{
    use PaginateTrait ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd(Visite::interets()) ;
        $visitesAll = Visite::with('client')
                            ->with('user')
                            ->latest('created_at')->get();

        //dd($visitesAll);
        $dateStartExist = false ;
        $dateEndExist = false ;

        //recherche par prix
        if (isset($request['dateStart']) && $request['dateStart'] != '' ) {
            $ds =  $request['dateStart'] ;
            $dateSt = str_replace('/', '-', $ds);
            $dateStart = date('Y-m-d', strtotime($dateSt));
            $dateStartExist = true ;

        }

        //recherche par prix
        if (isset($request['dateEnd']) && $request['dateEnd'] != '' ) {
            $de =  $request['dateEnd'] ;
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

           $visitesParPage = $this->paginate($visitesAll) ;
           $visitesParPage->withPath('/visites');
           $visitesParPage->withQueryString() ;

           $urlWithQueryString = $request->fullUrl();
           $urlWithQueryString = substr($urlWithQueryString, strlen($request->url())) ;           

        return view('visites.index', [
            'visites'       => $visitesParPage,
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
            'dateEnd'       => $request['dateEnd'],
            'dateStart'     => $request['dateStart'], 
            'nombreVisites' => $nombreVisites,
            'mois'          => $mois, 
            'urlWithQueryString' => $urlWithQueryString,

        ]);
    }

    public function export(Request $request) 
    {
        return Excel::download(new VisitesExport($request), 'Récap-visites-DSD.xlsx');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('visites.create') ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //this is for updating clients
        //$mobile = (isset($this->lot->id)) ? $this->lot->id : Null ;
        //'mobile'   => 'required|numeric|unique:clients,mobile'.$mobile,

        $request->validate([
            'nom'      => 'string|nullable',
            'prenom'      => 'string|nullable',
            'mobile'   => 'required|numeric|unique:clients,mobile',
            'date'  => 'required|date',
            'interet' => 'required|string',
            'detail' => 'required|string',
            'typeContact' => 'required|string' ,
            'source' => 'required|string' ,
            'domaine' => 'string|nullable' ,
            'surfaceDesired' => 'numeric|nullable' ,
            'autre' => 'string|nullable' ,

        ]);

        $client = new Client() ;
        $client->nom    = strtoupper($request['nom']);
        $client->prenom = strtoupper($request['prenom']);
        $client->mobile = $request['mobile'];

        $client->save();

        $visite = new Visite([
        'date'       => $request['date'] ,
        'interet'    => $request['interet'] ,
        'detail'   => $request['detail'],
        'remarqueClient'   => $request['remarqueClient'],
        'typeContact'   => $request['typeContact'],
        'source'   => $request['source'],
        'domaine'   => $request['domaine'],
        'surfaceDesired'   => $request['surfaceDesired'],
        'autre'   => $request['autre'],
        ]) ;
            // if ($request['source'] == 'Autre' && $request['autre'] != null) {
            //     $visite->source = $request['autre'] ;
            // }

        $visite->client()->associate($client) ;
        $visite->user()->associate(Auth::user()) ;

        $visite->save() ;


        return redirect()->action([VisiteController::class, 'index'])
        ->with('message','Visite ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function show(Visite $visite)
    {
        return view('visites.show', ['visite' => $visite]) ;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function edit(Visite $visite)
    {
        return view('visites.edit', ['visite' => $visite]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visite $visite)
    {
        $client = $visite->client ;
        $request->validate([
            'nom'      => 'nullable|string',
            'prenom'      => 'nullable|string',
            'mobile'   => 'required|numeric|unique:clients,mobile,'. $client->id,
            'date'  => 'required|date',
            'interet' => 'required|string',
            'detail' => 'required|string',
            'typeContact' => 'required|string' ,
            'source' => 'required|string' ,
            'domaine' => 'string|nullable' ,
            'surfaceDesired' => 'numeric|nullable' , 
            'autre' => 'string|nullable' ,

        ]);

        $client->nom                = strtoupper($request['nom']);
        $client->prenom             = strtoupper($request['prenom']);
        $client->mobile             = $request['mobile'];

        $client->update();

        $visite->interet        = $request['interet'] ;
        $visite->detail         = $request['detail'];
        $visite->remarqueClient = $request['remarqueClient'];
        $visite->typeContact = $request['typeContact'];
        $visite->source = $request['source'];
        $visite->domaine = $request['domaine'];
        $visite->surfaceDesired = $request['surfaceDesired'];
        $visite->autre = $request['autre'];

        $visite->update() ;


        return redirect()->action([VisiteController::class, 'index'])
        ->with('message','Visite modifié !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visite $visite)
    {
        $visite->delete() ;
        return redirect()->action([VisiteController::class, 'index'])
        ->with('message','Visite supprimé !');

    }
}
