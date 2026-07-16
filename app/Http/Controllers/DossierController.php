<?php

namespace App\Http\Controllers;

use App\Exports\DossiersExport;
use App\Http\Requests\DossierRequest;
use App\Http\Traits\PaginateTrait;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\Contrat;
use App\Models\Delai;
use App\Models\Dossier;
use App\Models\Produit;
use App\Models\Tranche;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Mavinoo\Batch\Batch;
use NumberToWords\NumberToWords;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Tcpdf\Fpdi as TCPDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Paiement;


class DossierController extends Controller
{
    use PaginateTrait ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $constructible = $request['constructible'] ;
        $projet_id = session('projet_id') ;

        if ($constructible == 'appartement' && isset($request['type']) && !is_null($request['type']))
        {
            $typeApp = $request['type'] ;
        }

        if (Gate::none(['voir dossiers ' . p($constructible),
                'voir ses propres dossiers'
                , 'voir dossiers ' . p($constructible) . ' standing'])) {
            abort(403);
        }
        if (!isset($typeApp) && $constructible=="appartement" && !Gate::allows('voir dossiers ' . p($constructible))) {
            abort(403);
        }        
        $tranche = $request['tranche'] ;
        $tranches = Tranche::where('projet_id' , session('projet_id'))->orderBy('num')->get();
        $tranchesArray = ($tranche == null) ? $tranches->pluck('id')->toArray() : [$tranche] ;
        $constructiblesArray = ($constructible == null) ?
                    ['lot','appartement','box','magasin','bureau'] : [$constructible] ;
          if ($constructible == 'appartement' && isset($request['type']) && !is_null($request['type']))
            {

                $All = Produit::with('constructible')
                                    ->whereIn('constructible_type', $constructiblesArray)
                                    ->whereHasMorph('constructible',
                                                [Appartement::class],
                                                function (Builder $qu) use ($typeApp)
                                            {
                                                $qu->where('type', $typeApp);

                                            })                                    
                                    ->with('etiquette')
                                    ->where('projet_id', $projet_id)
                                    ->get();
            }else
            {
                $All = Produit::with('constructible')
                                    ->whereIn('constructible_type', $constructiblesArray)
                                    ->with('etiquette')
                                    ->where('projet_id', $projet_id)
                                    ->get();                
            }

        $reserved = $All->where('etiquette_id', 3)->count() ;
        $stocked = $All->where('etiquette_id', 2)->count() ;
        $r = $All->where('etiquette_id', 9)->count() ;
        $blocked = $All->whereNotIn('etiquette_id', [3,2,9])->count() ;


        if (Gate::allows('voir dossiers ' . p($constructible)) 
            || Gate::allows('voir dossiers ' . p($constructible) . ' standing')) {
        if ($constructible == 'appartement' && isset($request['type']) && !is_null($request['type']))
        {
        $dossiersAll = Dossier::whereHas('produit', function (Builder $query) use ($typeApp, $constructiblesArray)
                            {
                                $query->whereIn('constructible_type', $constructiblesArray)
                                ->whereHasMorph('constructible',
                                            [Appartement::class],
                                            function (Builder $qu) use ($typeApp)
                                        {
                                            $qu->where('type', $typeApp);

                                        })
                                ;
                            })
                            ->whereHas('produit', function (Builder $query) use ($projet_id) {
                                    $query->where('projet_id', $projet_id);
                                })        
                            ->with('produit')
                            ->with('delais')
                            ->with('clients')
                            ->with('paiements')->orderbyDesc('created_at')
                            ->get(); 
                        }
                        else
                        {
        $dossiersAll = Dossier::whereHas('produit', function (Builder $query) use ($constructiblesArray)
                            {
                                $query->whereIn('constructible_type', $constructiblesArray);
                            })
                            ->with('produit')
                            ->with('delais')
                            ->with('clients')
                            ->with('paiements')->orderbyDesc('created_at')
                            ->whereHas('produit', function (Builder $query) use ($projet_id) {
                                    $query->where('projet_id', $projet_id);
                            })                            
                            ->get();                             
                        }
        }
        elseif(Gate::allows('voir ses propres dossiers'))
        {
          if ($constructible == 'appartement' && isset($request['type'])  && !is_null($request['type']))
            {
        $dossiersAll = Dossier::where('user_id' , Auth::user()->id)->
        whereHas('produit', function (Builder $query) use ($constructiblesArray)
                            {
                                $query->whereIn('constructible_type', $constructiblesArray);
                            })
                            ->with('produit')
                            ->with('delais')
                            ->with('clients')
                            ->whereHas('produit', function (Builder $query) use ($projet_id) {
                                    $query->where('projet_id', $projet_id);
                            })                            
                            ->with('paiements')->orderbyDesc('created_at')
                            ->get();                
            }
        else
        {
        $dossiersAll = Dossier::where('user_id' , Auth::user()->id)->
        whereHas('produit', function (Builder $query) use ($constructiblesArray)
                            {
                                $query->whereIn('constructible_type', $constructiblesArray);
                            })
                            ->whereHas('produit', function (Builder $query) use ($projet_id) {
                                    $query->where('projet_id', $projet_id);
                            })        
                            ->with('produit')
                            ->with('delais')
                            ->with('clients')
                            ->with('paiements')->orderbyDesc('created_at')
                            ->get();
            }
        }
        //recherche par taux de paiement
        if (isset($request['sign']) && $request['sign'] != '' ) {

            if(isset($request['tauxComparateur']) && $request['tauxComparateur'] != '-' ) {

            $tauxComparateur = $request['tauxComparateur'] ;
            $sign = $request['sign'] ;
            $dossiersAll = $dossiersAll->filter(function ($dossier) use ($sign, $tauxComparateur)  {
            // $taux = $dossier->paiements->sum('montant') * 100 /
            //                 ($dossier->produit->Total) ;

            $taux = $dossier->tauxPaiementV ;   

                switch ($sign) {
                    case '>':
                    if ($taux > $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '<':
                    if ($taux < $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '=>':
                    if ($taux >= $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '<=':
                    if ($taux <= $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;                                                                        

                }

            });                
            }
        }

        $numsDossier = [];

        //recherche par numéro des dossiers
        if (isset($request['num']) && $request['num'] != '' ) {
            $numsDossier = preg_split("/[\s,\.]+/", $request['num']);
            $numsDossier = array_map('trim', $numsDossier);
            $dossiersAll = $dossiersAll->whereIn('produit.constructible.num', $numsDossier);
        }

        //recherche par nom, prénom ou CIN client
        if (isset($request['client']) && $request['client'] != '' ) {
            $value = strtolower($request['client']) ;
                $clientSearch = '' ;

            $dossiersAll = $dossiersAll->filter(function ($item) use ($value, $clientSearch)  {
                foreach ($item->clients as $client) {
                $clientSearch .= strtolower(trim($client->cin . ' ' . $client->nom . ' ' . $client->prenom . ' ' ));
                }

                    if (strpos($clientSearch , $value) !== false) {
                        return true;
                    }
                        return false;
            });                

        }        

        //recherche par tranche
        if (isset($tranche) && $tranche != '-' ) {
            switch ($constructible) {
                case 'appartement':
                case 'magasin':
                case 'box':
                    $dossiersAll = $dossiersAll->filter(function ($dossier) use ($tranchesArray)
                    {
                        if(in_array($dossier->produit->constructible->immeuble->tranche_id, $tranchesArray))
                        {
                            return true ; 
                        }
                    });
                    break;
                case 'lot':
                    $dossiersAll = $dossiersAll->filter(function ($dossier) use ($tranchesArray)
                    {
                        if(in_array($dossier->produit->constructible->tranche_id, $tranchesArray))
                        {
                            return true ; 
                        }
                    });
                    break;
                case 'bureau':
                    $dossiersAll = $dossiersAll->filter(function ($dossier) use ($tranchesArray)
                    {
                        if(in_array($dossier->produit->constructible->situable->immeuble->tranche_id, $tranchesArray))
                        {
                            return true ; 
                        }
                    });
                    break;
            }
        }

        //recherche par commercial
        if (isset($request['user']) && $request['user'] != '-' ) {
            $user = $request['user'] ;
            $dossiersAll = $dossiersAll->where('user_id', $user); 
        }

        //recherche par relance 
        if (isset($request['relance']) && $request['relance'] != '-' ) {
            $relance = $request['relance'] ;
            switch ($relance) {
                case 'today':
                    $date = Carbon::now() ;
                    $date = $date->toDateString() ;
                    //dd($date) ;
                    break;
                case 'tomorrow':
                    $date = Carbon::now() ;
                    $date = $date->addDays(1);
                    $date = $date->toDateString() ;
                    break;
                case 'afterTomorrow':
                    $date = Carbon::now() ;
                    $date = $date->addDays(2);
                    $date = $date->toDateString() ;
                    break;                                    
                default:
                    break;
            }
                    $dossiersAll = $dossiersAll->filter(function ($dossier) use ($date)
                    {
                        foreach ($dossier->delais as $delai) {
                            if($delai->date->toDateString() == $date)
                            {
                                return true ; 
                            }
                        }
                    });
        }                 
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
            $dossiersAll = $dossiersAll->whereBetween('date', [$dateStart, $dateEnd] ); 

        }elseif ($dateStartExist == true && $dateEndExist == false) {
            $dossiersAll = $dossiersAll->where('date' , $dateStart); 

        }elseif ($dateStartExist == false && $dateEndExist == true) {
            $dossiersAll = $dossiersAll->where('date' , $dateEnd); 
        }

        //recherche par etat du dossier
        if (isset($request['etatDossier']) && $request['etatDossier'] != '-' ) {
            $etat = $request['etatDossier'] ;
            $dossiersAll = $dossiersAll->where('isVente', $etat);  
        }

        // recherche par etat légale du dossier
        if (isset($request['litige']) && $request['litige'] != '' ) {
            $litige = $request['litige'] ;
            $dossiersAll = $dossiersAll->where('litige', $litige);  
        }
        // recherche par etat transfert du dossier
        if (isset($request['transfert']) && $request['transfert'] != '' ) {

            $dossiersAll = $dossiersAll->whereNotNull('transferred_at');  
        }        

        // recherche par etat légale du dossier
        if (isset($request['desisstement']) && $request['desisstement'] != '' ) {

            $dossiersAll = Dossier::onlyTrashed()->get();  
        }

           $dossiersParPage = $this->paginate($dossiersAll) ;
           $dossiersParPage->withPath('/dossiers');
           $dossiersParPage->withQueryString() ;

           $urlWithQueryString = $request->fullUrl();
           $urlWithQueryString = substr($urlWithQueryString, strlen($request->url())) ;

        return view('dossiers.index', [
            'dossiers'              => $dossiersParPage,
            'totalDossier'          => $dossiersAll->count(),
            'clients'               => Client::all(),
            'users'                 => User::whereIn('role_id',[2,5,6])->get(),
            'dossiersParType'       => Dossier::dossiersParType($projet_id),
            'tranches'              => $tranches ,
            'etatDossier'           => $request['etatDossier'],
            'SearchByUser'          => $request['user'] ,
            'SearchBySign'          => $request['sign'] ,
            'SearchByTauxComparateur'          => $request['tauxComparateur'] ,
            'SearchByTranche'       => $tranche,
            'dateEnd'               => $request['dateEnd'],
            'dateStart'               => $request['dateStart'],
            'SearchByRelance'           => $request['relance'],
            'SearchByNum'           => implode(',' , $numsDossier) ,
            'SearchByClient'        => $request['client'] ,

            'SearchByLitige' => $request['litige'],
            'SearchByDesisstement' => $request['desisstement'],
            'SearchByTransfert' => $request['transfert'],

            'constructible'         => $constructible ,
            'type' => $request['type'],
            'reserved' => $reserved , 
            'stocked' => $stocked , 
            'r' => $r , 
            'blocked' => $blocked,
            'urlWithQueryString' => $urlWithQueryString
        ]);
    }

    public function litige(Request $request)
    {
        $request->validate([
            'action'      => 'required|string',
            'litiges.*'      => 'required|numeric',
        ]);        

        if ($request['action'] == '-1') {
            return redirect()->back(); 
        }
        else
        {
        if($request['litiges'] == NULL )
        {
        return redirect()->back();            

            }
            else
            {
        $action = $request['action'] ;
        switch ($action) {
            case 'litige':
                $etatLegale = true ;
                break;
            case 'accord':
                $etatLegale = false ;
                break;
            default:
                break;
        }
        $dossierInstance = new Dossier;
        $arrayValuesFromRequest = $request['litiges'] ;
        $arrayValues = [];
            foreach ($arrayValuesFromRequest as $value) {
            array_push($arrayValues, 
             [
                 'id' => $value ,
                 'litige' => $etatLegale ,
             ]
             );
             }
        $index = 'id';
        \Batch::update($dossierInstance, $arrayValues, $index);
        return redirect()->back()
                    ->with('message','Dossiers marqués !');
        }
        }
    }

    public function recouvrement(Request $request)
    {
        $constructible = $request['constructible'] ;
        if (Gate::none(['voir dossiers ' . p($constructible), 'voir ses propres dossiers'])) {
            abort(403);
        }

        $tranche = $request['tranche'] ;
        $tranches = Tranche::all();
        $tranchesArray = ($tranche == null) ? $tranches->pluck('id')->toArray() : [$tranche] ;
        $constructiblesArray = ($constructible == null) ?
                    ['lot','appartement','box','magasin','bureau'] : [$constructible] ;


        $All = Produit::with('constructible')
                            ->whereIn('constructible_type', $constructiblesArray)
                            ->with('etiquette')
                            ->get();

        $reserved = $All->where('etiquette_id', 3)->count() ;
        $stocked = $All->where('etiquette_id', 2)->count() ;
        $r = $All->where('etiquette_id', 9)->count() ;
        $blocked = $All->whereNotIn('etiquette_id', [3,2,9])->count() ;


        if (Gate::allows('voir dossiers ' . p($constructible))) {
        $dossiersAll = Dossier::whereHas('produit', function (Builder $query) use ($constructiblesArray)
                            {
                                $query->whereIn('constructible_type', $constructiblesArray);
                            })
                            ->with('produit')
                            ->with('delais')
                            ->with('clients')
                            ->with('paiements')->orderbyDesc('created_at')
                            ->get(); 
        }
        elseif(Gate::allows('voir ses propres dossiers'))
        {
        $dossiersAll = Dossier::where('user_id' , Auth::user()->id)->
        whereHas('produit', function (Builder $query) use ($constructiblesArray)
                            {
                                $query->whereIn('constructible_type', $constructiblesArray);
                            })
                            ->with('produit')
                            ->with('delais')
                            ->with('clients')
                            ->with('paiements')->orderbyDesc('created_at')
                            ->get();           
        }
        //recherche par taux de paiement
        if (isset($request['sign']) && $request['sign'] != '' ) {

            if(isset($request['tauxComparateur']) && $request['tauxComparateur'] != '-' ) {

            $tauxComparateur = $request['tauxComparateur'] ;
            $sign = $request['sign'] ;
            $dossiersAll = $dossiersAll->filter(function ($dossier) use ($sign, $tauxComparateur)  {
            // $taux = $dossier->paiements->sum('montant') * 100 /
            //                 ($dossier->produit->Total) ;

            $taux = $dossier->tauxPaiementV ;   

                switch ($sign) {
                    case '>':
                    if ($taux > $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '<':
                    if ($taux < $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '=>':
                    if ($taux >= $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;
                    case '<=':
                    if ($taux <= $tauxComparateur) {
                        return true;
                    }
                        return false;
                        break;                                                                        

                }

            });                
            }
        }

        $numsDossier = [];

        //recherche par numéro des dossiers
        if (isset($request['num']) && $request['num'] != '' ) {
            $numsDossier = preg_split("/[\s,\.]+/", $request['num']);
            $numsDossier = array_map('trim', $numsDossier);
            $dossiersAll = $dossiersAll->whereIn('produit.constructible.num', $numsDossier);
        }

        //recherche par nom, prénom ou CIN client
        if (isset($request['client']) && $request['client'] != '' ) {
            $value = strtolower($request['client']) ;
                $clientSearch = '' ;

            $dossiersAll = $dossiersAll->filter(function ($item) use ($value, $clientSearch)  {
                foreach ($item->clients as $client) {
                $clientSearch .= strtolower(trim($client->cin . ' ' . $client->nom . ' ' . $client->prenom . ' ' ));
                }

                    if (strpos($clientSearch , $value) !== false) {
                        return true;
                    }
                        return false;
            });                

        }        


        //recherche par tranche
        if (isset($tranche) && $tranche != '-' ) {
            switch ($constructible) {
                case 'appartement':
                case 'magasin':
                case 'box':
                    $dossiersAll = $dossiersAll->filter(function ($dossier) use ($tranchesArray)
                    {
                        if(in_array($dossier->produit->constructible->immeuble->tranche_id, $tranchesArray))
                        {
                            return true ; 
                        }
                    });
                    break;
                case 'lot':
                    $dossiersAll = $dossiersAll->filter(function ($dossier) use ($tranchesArray)
                    {
                        if(in_array($dossier->produit->constructible->tranche_id, $tranchesArray))
                        {
                            return true ; 
                        }
                    });
                    break;
                case 'bureau':
                    $dossiersAll = $dossiersAll->filter(function ($dossier) use ($tranchesArray)
                    {
                        if(in_array($dossier->produit->constructible->situable->immeuble->tranche_id, $tranchesArray))
                        {
                            return true ; 
                        }
                    });
                    break;
            }
        }

        //recherche par commercial
        if (isset($request['user']) && $request['user'] != '-' ) {
            $user = $request['user'] ;
            $dossiersAll = $dossiersAll->where('user_id', $user); 
        }

        //recherche par relance 
        if (isset($request['relance']) && $request['relance'] != '-' ) {
            $relance = $request['relance'] ;
            switch ($relance) {
                case 'today':
                    $date = Carbon::now() ;
                    $date = $date->toDateString() ;
                    //dd($date) ;
                    break;
                case 'tomorrow':
                    $date = Carbon::now() ;
                    $date = $date->addDays(1);
                    $date = $date->toDateString() ;
                    break;
                case 'afterTomorrow':
                    $date = Carbon::now() ;
                    $date = $date->addDays(2);
                    $date = $date->toDateString() ;
                    break;                                    
                default:
                    break;
            }
                    $dossiersAll = $dossiersAll->filter(function ($dossier) use ($date)
                    {
                        foreach ($dossier->delais as $delai) {
                            if($delai->date->toDateString() == $date)
                            {
                                return true ; 
                            }
                        }
                    });
        }                 
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
            $dossiersAll = $dossiersAll->whereBetween('date', [$dateStart, $dateEnd] ); 

        }elseif ($dateStartExist == true && $dateEndExist == false) {
            $dossiersAll = $dossiersAll->where('date' , $dateStart); 

        }elseif ($dateStartExist == false && $dateEndExist == true) {
            $dossiersAll = $dossiersAll->where('date' , $dateEnd); 
        }

        if (isset($request['etatDossier']) && $request['etatDossier'] != '-' ) {
            $etat = $request['etatDossier'] ;
            $dossiersAll = $dossiersAll->where('isVente', $etat);  
        }           

           $dossiersParPage = $this->paginate($dossiersAll) ;
           $dossiersParPage->withPath('/recouvrement');
           $dossiersParPage->withQueryString() ;

           $urlWithQueryString = $request->fullUrl();
           $urlWithQueryString = substr($urlWithQueryString, strlen($request->url())) ;

        return view('dossiers.recouvrement', [
            'dossiers'              => $dossiersParPage,
            'totalDossier'          => $dossiersAll->count(),
            'clients'               =>   Client::all(),
            'users'                 => User::whereIn('role_id',[2,5,6])->get(),
            'dossiersParType'       => Dossier::dossiersParType(),
            'tranches'              => $tranches ,
            'etatDossier'           => $request['etatDossier'],
            'SearchByUser'          => $request['user'] ,
            'SearchBySign'          => $request['sign'] ,
            'SearchByTauxComparateur'          => $request['tauxComparateur'] ,
            'SearchByTranche'       => $tranche,
            'dateEnd'               => $request['dateEnd'],
            'dateStart'               => $request['dateStart'],
            'SearchByRelance'           => $request['relance'],
            'SearchByNum'           => implode(',' , $numsDossier) ,
            'SearchByClient'        => $request['client'] ,
            'constructible'         => $constructible ,
            'reserved' => $reserved , 
            'stocked' => $stocked , 
            'r' => $r , 
            'blocked' => $blocked,
            'urlWithQueryString' => $urlWithQueryString
        ]);
    }    

    public function export(Request $request) 
    {
        return Excel::download(new DossiersExport($request), 'Récap-ventes.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Produit $produit)
    {
        return view('dossiers.create', [
            'clients'       => Client::where('activer', '=' , 1)->orderbyDesc('created_at')->get(),
            'produit'       => $produit,
            'dataRecap'     => $this->recap($produit),

        ]) ;
    }

    public function createWithClient(Produit $produit, Client $client)
    {
        return view('dossiers.create', [
            'client'    => $client,
            'produit'   => $produit,
            'dataRecap' => $this->recap($produit),

        ]) ;
    }

    // !!!!! A déplacer vers la model produit 

    public function recap(Produit $produit)
    {
        return 
            'Qui concerne ' . $produit->constructible_type .' N° ' . $produit->constructible->num . 
            ', d\'une surface totale de : ' . $produit->constructible->surface . 'm2' .
            '. Vendu au prix total de : ' . number_format($produit->total) . ' Dhs'.
            '. Du type : ' . $produit->type . '. Etage : ' . $produit->etage .
            '. ' . ucfirst($produit->constructible_type) .' sur la tranche ' . $produit->constructible->tranche->description ;
    }


    public function createWithoutProduit(Client $client)
    {   
        // On vérifie si l'utilisateur a droit de créer un dossier pour un type de produit
        if (Gate::none(['Ajouter dossiers appartements',
                       'Ajouter dossiers lots',
                       'Ajouter dossiers appartements standing' ,
                       'Ajouter dossiers bureaux' ,
                       'Ajouter dossiers magasins']))
        {
            abort(403);
        }

        // ici on connait que le client
        // Renvoyer le client et le produit sera retrouvé grâce au formulaire de recherche ...
        return view('dossiers.create', [
            'client'    => $client
        ]) ;
    }

    public function createWithoutClient()
    {
        // On vérifie si l'utilisateur a droit de créer un dossier pour un type de produit
        if (Gate::none(['Ajouter dossiers appartements',
                       'Ajouter dossiers lots',
                       'Ajouter dossiers appartements standing' ,
                       'Ajouter dossiers bureaux' ,
                       'Ajouter dossiers magasins']))
        {
            abort(403);
        }

        // ici on connait ni le client ni le produit
        // Renvoyer tous les clients et le produit sera retrouvé grâce au formulaire de recherche ...
        return view('dossiers.create', [
            'clients' => Client::where('activer', '=' , 1)->orderbyDesc('created_at')->get()
        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DossierRequest $request)
    {
        $produit = Produit::findOrFail($request['produit']) ;
        $constructible = $produit->constructible_type ;
        
        if (!Gate::allows('Ajouter dossiers ' . p($constructible))
            && !Gate::allows('Ajouter dossiers ' . p($constructible) . ' standing')
        ){
                abort(403);
        }

        $dossier = new Dossier([
            'date'              => $request['date'] ,
            'frais'             => $request['frais'] ,
            'detail'            => $request['detail'],
            'produit_id'        => $request['produit'],
            'user_id'           => Auth::id(),
            'isVente'           => $request['isVente'],
        ]) ;
  

            if(isset($produit) && $produit->etiquette_id === 2 )
            {
                $dossier->save();
                $dossier->clients()->attach($request['client']);

                if ($dossier->isVente) {
                    $dossier->produit->etiquette_id = 3 ;
                }else
                {                    
                    $dossier->produit->etiquette_id = 9 ;

                    $delai = new Delai([
                        'date'              => $request['delai'] ,
                    ]) ;
                    $dossier->delais()->save($delai) ;
                }
                $dossier->produit->update() ;

                if($produit->constructible_type == 'appartement')
                {
                    $redirect = '/dossiers?constructible='. $produit->constructible_type .
                    '&type='.$produit->constructible->type ;
                }else
                {
                    $redirect = '/dossiers?constructible='. $produit->constructible_type ;                 
                }
                return redirect($redirect)->with('message','Dossier ajouté !');
            }

            return redirect()->back()->withErrors(['msg', 'Attention : ' .
                ucfirst($produit->constructible_type). ' n\'existant pas ou étant déjà résérvé !'
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function show(Dossier $dossier)
    {
            // Exemple de récupération dans ton contrôleur avant de retourner la vue :
        $historyGroups = \Illuminate\Support\Facades\DB::table('client_dossier_histories')
        ->where('dossier_id', $dossier->id)
        ->orderBy('transferred_at', 'desc')
        ->get()
        ->groupBy('batch_id'); // 👈 Regroupe toutes les lignes d'un même transfert

        return view('dossiers.show', [
            'dossier'       => $dossier,
            'clients'       =>   Client::all(),
            'historyGroups' => $historyGroups,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function edit(Dossier $dossier)
    {
        return view('dossiers.edit' , [
        'clients'=> Client::where('activer', '=', 1 )
                            ->orderby('nom', 'desc')
                            ->get(),

            'dossier'   => $dossier,
            'produit'   => $dossier->produit,
            'client'    => $dossier->client,
            'dataRecap' => $this->recap($dossier->produit)
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function update(DossierRequest $request, Dossier $dossier)
    {
        //dd($request) ;

        if($request->hasFile('actePj'))
        {

            $clientN = '' ;
            foreach ($dossier->clients as $client)
            {
                $clientN .= $client->nom . '-' . $client->prenom . '-' ;
            }
            $clientN = str_replace(' ', '', $clientN) ;

            $pjName = 'acte-reservation' . '-' . $dossier->produit->constructible_type . '-Num' 

            . str_replace('.', '', $dossier->produit->constructible->num) . '-' 

            . str_replace('.', '',  $clientN ) . '-' 

            . str_replace(' ', '-', date('Y-m-d-His')) ;

            $pjExtension = $request->file('actePj')->extension() ;                 

            $pdfPath = $request->file('actePj')
            ->storeAs('documents/actes', $pjName . '.' . $pjExtension) ;

            $dossier->actePj = 'documents/actes/' . $pjName . '.' . $pjExtension ;

        }elseif($request->hasFile('actevente'))
        {
            $clientN = '' ;
            foreach ($dossier->clients as $client)
            {
                $clientN .= $client->nom . '-' . $client->prenom . '-' ;
            }
            $clientN = str_replace(' ', '', $clientN) ;

            $pjName = 'acte-vente' . '-' . $dossier->produit->constructible_type . '-Num' 

            . str_replace('.', '', $dossier->produit->constructible->num) . '-' 

            . str_replace('.', '',  $clientN ) . '-' 

            . str_replace(' ', '-', date('Y-m-d-His')) ;

            $pjExtension = $request->file('actevente')->extension() ;                 

            $pdfPath = $request->file('actevente')
            ->storeAs('documents/actes', $pjName . '.' . $pjExtension) ;

            $dossier->actevente = 'documents/actes/' . $pjName . '.' . $pjExtension ;
        }
        else
        {
            $dossier->date = $request['date'];
            $dossier->frais = $request['frais'];
            $dossier->detail = $request['detail'];
            $dossier->isVente = $request['isVente'] ;
        }

            $dossier->update(); 

                if ($dossier->isVente) {
                    $dossier->produit->etiquette_id = 3 ;
                }else
                {                    
                    $dossier->produit->etiquette_id = 9 ;
                    
                    $id_delai = $request['delai_id'] ;
                        //dd( is_numeric($id_delai) ) ;

                    if (is_numeric($id_delai)) {
                        $delai = Delai::find($id_delai) ;
                        if ($delai != null ) {
                            $delai->date = $request['delai'];
                            $delai->update() ;
                        }

                    }else
                    {
                        $delai = new Delai([
                            'date'  => $request['delai'] ,
                        ]) ;
                        $dossier->delais()->save($delai) ;
                    }
                }

                $dossier->produit->update() ;

                return redirect(
                    '/dossiers?constructible='. $dossier->produit->constructible_type
                )->with('message','Dossier modifié !');

    }

    public function retour(Dossier $dossier)
    {
        return view('dossiers.retour', [
            'dossier'       => $dossier
        ]) ;
    }

    public function acte_vente(Dossier $dossier)
    {
        return view('dossiers.actevente', [
            'dossier'       => $dossier
        ]) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dossier $dossier)
    {

            DB::transaction(function () use ($dossier, $motif, $tauxIndemnite) {
            $dossier->update([
                'desiste_by' => Auth::id(),
            ]);
            });

        // le produit devient dispo au stock après suppression du dossier
        $dossier->produit->etiquette_id = 2 ; // étiquette -> En stock
        $dossier->produit->update() ; // étiquette -> En stock
        $dossier->clients()->detach() ;
        $dossier->paiements()->delete() ;
        $dossier->transferts()->delete() ;
        $dossier->delete() ;

        return redirect()->back()
                ->with('message','Dossier supprimé !');

        // return redirect()->action([DossierController::class, 'index'])
        //         ->with('message','Dossier supprimé !');
    }

    public function desisstement(Dossier $dossier)
    {
        return view('dossiers.desisstement', [
            'dossier'       => $dossier
        ]) ;
    }

    public function demandeDesisstement(Dossier $dossier, Request $request)
    {
            $request->validate([
                'indemnite' => 'required|numeric|min:0|max:100',
                'motif' => 'string'
            ]);

        $tauxIndemnite = $request->input('indemnite');
        $motif = $request->input('motif');
        $indemnite = $dossier->TotalPaiementsV * ($tauxIndemnite/100) ;

            DB::transaction(function () use ($dossier, $motif, $tauxIndemnite) {
            $dossier->update([
                'indemnite' => $tauxIndemnite,
                'motif_desistement' => $motif,
                'desiste_by' => Auth::id(),
            ]);
            });

        $pdf = Pdf::loadView('pdf.recaps.desisstement',
            [
                'tauxIndemnite' => $tauxIndemnite,
                'indemnite' => $indemnite,
                'dossier'   => $dossier
            ]);
        return $pdf->download('demande_desistement.pdf');

    }

    public function demandeTransfert(Dossier $dossier, Request $request)
    {

        $request->validate([
                'client.*' => 'required|integer|exists:clients,id',
            ]);
        $nouveauxClients = Client::whereIn('id', $request['client'])->get();


            DB::transaction(function () use ($dossier, $motif, $tauxIndemnite) {
            $dossier->update([
                'indemnite' => $tauxIndemnite,
                'motif_desistement' => $motif,
                'desiste_by' => Auth::id(),
            ]);
            });

        $pdf = Pdf::loadView('pdf.recaps.transfert',
            [
                'nouveauxClients' => $nouveauxClients,
                'dossier'   => $dossier
            ]);
        return $pdf->download('demande_transfert.pdf');

    }

    public function desister(Dossier $dossier, Request $request)
    {

            if ($dossier->trashed()) {
                throw new \Exception('Ce dossier est déjà désisté.');
            }

        if($request->hasFile('demandeDesisstement'))
        {

            $clientN = '' ;
            foreach ($dossier->clients as $client)
            {
                $clientN .= $client->nom . '-' . $client->prenom . '-' ;
            }
            $clientN = str_replace(' ', '', $clientN) ;

            $pjName = 'demandeDesisstement' . '-' . $dossier->produit->constructible_type . '-Num' 

            . str_replace('.', '', $dossier->produit->constructible->num) . '-' 

            . str_replace('.', '',  $clientN ) . '-' 

            . str_replace(' ', '-', date('Y-m-d-His')) ;

            $pjExtension = $request->file('demandeDesisstement')->extension() ;                 

            $pdfPath = $request->file('demandeDesisstement')
            ->storeAs('documents/desistements', $pjName . '.' . $pjExtension) ;

            $lien = 'documents/desistements/' . $pjName . '.' . $pjExtension ;

        }

        DB::transaction(function () use ($dossier, $lien) {
            $dossier->update([
                'demandeDesisstement' => $lien,
            ]);
            $dossier->produit->etiquette_id = 2 ; // app redevient dispo
            $dossier->produit->update() ; // étiquette -> En stock

       $totalPaiementVNegative = -$dossier->totalPaiementsV ;

            // Paiements ENCAISSÉS : enregistrer leur négative pour les enlever des calculs

        if ($totalPaiementVNegative !== 0)
        {
            $paiement = new Paiement([
                'date'              => now()->format('Y-m-d'),
                'type'              => 'desistement',
                'montant'           => $totalPaiementVNegative ,
                'valider'           => 1
            ]) ;

            $paiement->dossier()->associate($dossier) ;
            $paiement->save();
        }
            // Paiements NON ENCAISSÉS uniquement : ceux-là peuvent être marqués annulés
            $dossier->paiements()->where('valider', 0)->update(['valider' => 3]);

            $dossier->delete(); // soft delete, en dernier

        });

                return redirect(
                    '/dossiers?constructible='. $dossier->produit->constructible_type
                )->with('message','Dossier desisté !');        

    }



// 16/07/26 ajout de cette function pour créer le pdf du contrat partout : actesApp, actesMag, ... à supprimer
    public function actes(Dossier $dossier)
    {


        $projet = $dossier->produit->projet ;
        $contrat = Contrat::where('type_produit', $dossier->produit->type)
                            ->where('projet_id' , $projet->id)->first() ;
        $a = $contrat->articles->map(function ($article) use ($dossier){
            $article->texte =  replace_shortcodes( $article->texte, $dossier) ;
            return $article ;
        });
        $a = $a->sortBy('classement');
        $type = $dossier->produit->type ;
        $pdf = Pdf::loadView('pdf.contrats.contrat', ['data' => $a, 'type' => $type, 'logo' => $projet->entreprise->logo]);
        return $pdf->download('contrat.pdf');
    }    

    
}
