<?php

namespace App\Http\Controllers;

use App\Exports\DossiersExport;
use App\Http\Requests\DossierRequest;
use App\Http\Traits\PaginateTrait;
use App\Models\Client;
use App\Models\Delai;
use App\Models\Dossier;
use App\Models\Produit;
use App\Models\Tranche;
use App\Models\User;
use App\Models\Appartement;
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

class DossierController extends Controller
{
    use PaginateTrait ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function litige(Request $request)
    {
        //dd($request) ;
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
        //var_dump($request['litiges']) ;
        $arrayValues = [];
            foreach ($arrayValuesFromRequest as $value) {
                //dd($value);
            array_push($arrayValues, 
             [
                 'id' => $value ,
                 'litige' => $etatLegale ,
             ]
             );
             }
        
        //     dd($arrayValues) ;
        $index = 'id';

        \Batch::update($dossierInstance, $arrayValues, $index);
        return redirect()->back()
                    ->with('message','Dossiers marqués !');
        }
        }
    }
    
    public function index(Request $request)
    {
        $constructible = $request['constructible'] ;

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
        $tranches = Tranche::all();
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
                                    ->get();
            }else
            {
                $All = Produit::with('constructible')
                                    ->whereIn('constructible_type', $constructiblesArray)
                                    ->with('etiquette')
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
        // else
        // {
        //     $dossiersAll = $dossiersAll->whereIn('litige', [NULL, false]);  
        // }

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
            'SearchByLitige' => $request['litige'],
            'constructible'         => $constructible ,
            'type' => $request['type'],
            'reserved' => $reserved , 
            'stocked' => $stocked , 
            'r' => $r , 
            'blocked' => $blocked,
            'urlWithQueryString' => $urlWithQueryString
        ]);
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



        //recherche par etat du dossier
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
        return Excel::download(new DossiersExport($request), 'Récap-ventes-DSD.xlsx');
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

    public function recap(Produit $produit)
    {
        return 
            'Qui concerne ' . $produit->constructible_type .' N° ' . $produit->constructible->num . 
            ', d\'une surface totale de : ' . $produit->constructible->surface . 'm2' .
            '. Vendu au prix total de : ' . number_format($produit->total) . ' Dhs'.
            '. Du type : ' . $produit->constructible->type . '. Etage : ' . $produit->constructible->etage .
            '. ' . ucfirst($produit->constructible_type) .' sur la tranche ' . $produit->constructible->tranche->id ;
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

        return view('dossiers.show', [
            'dossier'              => $dossier,
            'clients'               =>   Client::all(),
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
            'clients'   => Client::orderBy('nom', 'desc')->get(), 
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
            ->storeAs('public/actes', $pjName . '.' . $pjExtension) ;

            $dossier->actePj = 'actes/' . $pjName . '.' . $pjExtension ;

        }else
        {
            $dossier->clients()->detach();            
            $dossier->clients()->attach($request['client']);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dossier  $dossier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dossier $dossier)
    {
        // le produit devient dispo au stock après suppression du dossier
        $dossier->produit->etiquette_id = 2 ; // étiquette -> En stock
        $dossier->produit->update() ; // étiquette -> En stock

        $dossier->clients()->detach();
        $dossier->paiements()->delete() ;

        $dossier->delete() ;

        return redirect()->back()
                ->with('message','Dossier supprimé !');

        // return redirect()->action([DossierController::class, 'index'])
        //         ->with('message','Dossier supprimé !');
    }

    public function actesLot(Dossier $dossier)
    {

        // create the number to words "manager" class
        $toWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $toWords->getNumberTransformer('fr');

         // outputs "five thousand one hundred twenty"

        // initiate FPDI
        $pdf = new FPDI();
        $pdf->SetTextColor(0, 0, 255) ;
        $pdf->SetFont('Helvetica');
            // $pdf->setPrintHeader(false);
            // $pdf->setPrintFooter(false);
        // get the page count

        $pageCount = $pdf->setSourceFile(Storage_path('app/public/acte-reservation-'.
         $dossier->produit->constructible_type .'.pdf'));

        // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->SetMargins(0, 0, 0 , 0) ;

            // import a page
            $templateId = $pdf->importPage($pageNo); //$pageNo
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            //dd($size) ;
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);
            if ($pageNo == 1)
            {
                    $txt = '' ;
                    $i = 0 ;
                foreach ($dossier->clients as $client)
                {  

                    $i += 1 ;
                    $txt .= '- Monsieur/Madame : ' ;
                    $prenom = stripslashes($client->prenom);
                    $nom = iconv('UTF-8', 'windows-1252', $prenom);

            $nom = stripslashes($client->nom);
            $nom = iconv('UTF-8', 'windows-1252', $nom);
            $nomC = ucfirst($nom) . ' ' . ucfirst($prenom) ;
            $txt .= $nomC . chr(10) ;
            $txt .= 'Demeurant à : ' ;
            $adresse = stripslashes($client->adresse);
            $adresse = ucfirst(preg_replace( "/\r|\n/", " ", $adresse )) ;
            $adresse = iconv('UTF-8', 'windows-1252', $adresse);

            $ad = str_split($adresse, 45) ;

            $txt .= implode(chr(10) , $ad) . chr(10) ;

            $txt .= iconv('UTF-8', 'windows-1252', 'Titulaire de la carte d’identité nationale N° : ' );

            $txt .= $client->cin  ;
                if ($i !== $dossier->clients->count() )
                {
                   $txt .= chr(10) ;
                }
            }
            //$txt = iconv('UTF-8', 'windows-1252', $txt) ;
            switch ($i) {
                case 1:
                    $i = 93.75 + 25 ;
                    break;
                case 2:
                    $i = 93.75 + 20 ;
                    break;
                case 3:
                    $i = 93.75 + 15 ;
                    break;  
                                      
                default:
                    break;
            }
            $pdf->SetXY(50, $i);

            $pdf->MultiCell(0,5, $txt);

            }    

            if ($pageNo == 2)
            {
            $pdf->SetXY(120, 46);
            $pdf->Write(8, ucfirst($dossier->produit->constructible->num));   

            $pdf->SetXY(180, 46);
            $pdf->Write(8, ucfirst($dossier->produit->constructible->tranche_id));    

            $pdf->SetXY(105.25, 55.5);
            $pdf->Write(0, 
                ucfirst($dossier->produit->constructible->surface) .
                'm2 (R+' . $dossier->produit->constructible->etage . ').'
            );


            $priceTotal = number_format($dossier->produit->total) . ' DHS, ';
            $priceTotal .= ucfirst($numberTransformer->toWords($dossier->produit->total)) . ' dirhams.'; 
            $pdf->SetXY(49, 82);
            $pdf->Write(8, $priceTotal);   

            // $pdf->SetXY(80, 82);
            // $pdf->Write(8, );     

            $pdf->SetXY(49, 87.25);
            $pdf->Write(8, '(' .$dossier->produit->prix . iconv('UTF-8', 'windows-1252',' DHS le mètre carré) toutes taxes comprises.'));    

            // affichage du 30% du prix en chiffre
            $paiements = number_format((($dossier->produit->total) * 30) /100) . ' DHS, ' ; 
            $paiements .= ucfirst($numberTransformer->toWords((($dossier->produit->total) * 30) /100 )) . ' dirhams.' ;

            $pdf->SetXY(49, 106);
            $pdf->Write(0, $paiements);   

            // affichage du 30% du prix en lettre
            // $pdf->SetXY(80, 106);
            // $pdf->Write(0, );  


            // affichage du 30% du prix en lettre
            $pdf->SetXY(140, 116);
            $pdf->Write(0, number_format($dossier->totalPaiementsV) . ' DHS');              

            // affichage du délai de livraison
            if (in_array($dossier->produit->constructible->tranche->num, [1,2])) {
                $delai = 24 ;
            }elseif (in_array($dossier->produit->constructible->tranche->num, [3,4])) {
                $delai = 36 ;
            }
            $pdf->SetXY(142, 263.25);
            $pdf->Write(0, $delai);  
            }  

            if ($pageNo == 4)
            {

            $pdf->SetXY(113, 153);
            $pdf->Write(8, date("j/n/Y"));   
          

            }  

        }

        // Output the new PDF
        $pdf->Output('D', 'actes_reservation_lot_N_' . $dossier->produit->constructible->num
            . '_' . '.pdf', true);
    }

    public function actesApp(Dossier $dossier)
    {

        // create the number to words "manager" class
        $toWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $toWords->getNumberTransformer('fr');

         // outputs "five thousand one hundred twenty"

        // initiate FPDI
        $pdf = new TCPDF();
        $pdf->SetTextColor(0, 0, 255) ;
        //$pdf->SetFont('Helvetica');
        $pdf->setRTL(true);
        $pdf->SetFont('aealarabiya', '', 14);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
        // get the page count
            if (in_array($dossier->produit->constructible->immeuble->tranche->num, [2,3,4])
                && ($dossier->produit->constructible->etage == 1 || 
                    $dossier->produit->constructible->etage == 2)) {
             $pageCount = $pdf->setSourceFile(Storage_path('app/public/acte-reservation-appartement-t2.pdf'));
            }else{
             $pageCount = $pdf->setSourceFile(Storage_path('app/public/acte-reservation-'.
             $dossier->produit->constructible_type .'.pdf'));
            }


        // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->SetMargins(0, 0, 0 , 0) ;

            // import a page
            $templateId = $pdf->importPage($pageNo); //$pageNo
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            //dd($size) ;
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);
            if ($pageNo == 1) // 1 
            {
                $i_start = 35 ;
                $cin_start = 69 ;
                $ad_start = 117 ;
                foreach ($dossier->clients as $client)
                {
                    $prenom = stripslashes($client->prenomAr);
                    //$prenom = iconv('UTF-8', 'windows-1251//TRANSLIT//IGNORE', $prenom);
                    //    dd('مفعول') ;
                    $nom = stripslashes($client->nomAr);
                    //$nom = iconv("Windows-1256//TRANSLIT//IGNORE", "UTF-8//TRANSLIT//IGNORE", 'مفعول');

                    $pdf->SetXY($i_start, 95.75);
                    $nomC =  $nom . ' ' . $prenom . ' |';
                    $i_start += strlen($nomC)+2 ;

                    $pdf->Write(8, $nomC);

                    $adresse = stripslashes($client->adresseAr);
                    //$adresse = iconv('UTF-8', 'windows-1251//TRANSLIT//IGNORE', $adresse);

                    $pdf->SetXY(14, $ad_start);
                    $pdf->Write(8, ucfirst(preg_replace( "/\r|\n/", " ", '- ' . $adresse )));
                    $ad_start += 8 ;

                    $pdf->SetXY($cin_start, 103);
                    $pdf->Write(8, strtoupper($client->cin) . ' | ');    

                    $cin_start += (strlen($client->cin)*3) +2 ;

                }                
            }    

            if ($pageNo == 2) // 2
            {
                $pdf->SetFont('Helvetica', 12);

                $pdf->SetXY(56, 41.5);
                $pdf->Write(0,$dossier->produit->constructible->surface) ;

                $pdf->SetXY(109, 41.5);
                $pdf->Write(0,$dossier->produit->constructible->immeuble->tranche->num) ;

                $pdf->SetXY(150, 41.5);
                $pdf->Write(0,$dossier->produit->constructible->immeuble->num) ;

                $pdf->SetXY(55, 48.5);
                $pdf->Write(0,$dossier->produit->constructible->num) ;

                $pdf->SetXY(32, 48.5);
                $pdf->Write(0,$dossier->produit->constructible->etage) ;                
            }  

            if ($pageNo == 6) // 6
            {

            $pdf->SetXY(99, 194.5);
            $pdf->Write(8, date("j/n/Y"));   
          

            }  

        }
        $pdf->Output('actes_reservation_app_N_' . $dossier->produit->constructible->num
            . '_' .  '_' . '.pdf', 'I'); 
        // Output the new PDF
        //$pdf->Output('D', 'actes_reservation_lot_N_' . $dossier->produit->constructible->num
        //    . '_' . $dossier->client->nom . '_' . $dossier->client->prenom . '.pdf', true);

        // $pdf->Output('actes_reservation_lot_N_' . $dossier->produit->constructible->num
        //     . '_' . $dossier->client->nom . '_' . $dossier->client->prenom . '.pdf', 'I'); 
        // // Output the new PDF
        // //$pdf->Output('D', 'actes_reservation_lot_N_' . $dossier->produit->constructible->num
        // //    . '_' . $dossier->client->nom . '_' . $dossier->client->prenom . '.pdf', true);
    }    

    public function actesStanding(Dossier $dossier)
    {

        // create the number to words "manager" class
        $toWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $toWords->getNumberTransformer('ar');

         // outputs "five thousand one hundred twenty"

        // initiate FPDI
        $pdf = new TCPDF();
        $pdf->SetTextColor(0, 0, 255) ;
        //$pdf->SetFont('Helvetica');
        $pdf->setRTL(true);
        $pdf->SetFont('aealarabiya', '', 14);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
        // get the page count

        $pageCount = $pdf->setSourceFile(Storage_path('app/public/acte-reservation-appartement-standing.pdf'));

        // iterate through all pages
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->SetMargins(0, 0, 0 , 0) ;

            // import a page
            $templateId = $pdf->importPage($pageNo); //$pageNo
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            //dd($size) ;
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);
            if ($pageNo == 1) // 1 
            {
                $i_start = 35 ;
                $cin_start = 69 ;
                $ad_start = 117 ;
                foreach ($dossier->clients as $client)
                {
                    $prenom = stripslashes($client->prenomAr);
                    //$prenom = iconv('UTF-8', 'windows-1251//TRANSLIT//IGNORE', $prenom);
                    //    dd('مفعول') ;
                    $nom = stripslashes($client->nomAr);
                    //$nom = iconv("Windows-1256//TRANSLIT//IGNORE", "UTF-8//TRANSLIT//IGNORE", 'مفعول');

                    $pdf->SetXY($i_start, 95.75);
                    $nomC =  $nom . ' ' . $prenom . ' |';
                    $i_start += strlen($nomC)+2 ;

                    $pdf->Write(8, $nomC);

                    $adresse = stripslashes($client->adresseAr);
                    //$adresse = iconv('UTF-8', 'windows-1251//TRANSLIT//IGNORE', $adresse);

                    $pdf->SetXY(14, $ad_start);
                    $pdf->Write(8, ucfirst(preg_replace( "/\r|\n/", " ", '- ' . $adresse )));
                    $ad_start += 8 ;

                    $pdf->SetXY($cin_start, 103);
                    $pdf->Write(8, strtoupper($client->cin) . ' | ');    

                    $cin_start += (strlen($client->cin)*3) +2 ;

                }                
            }    

            if ($pageNo == 2) // 2
            {
                $pdf->SetXY(41, 168.5);
                $pdf->Write(0,$numberTransformer->toWords($dossier->produit->totalIndicatif) . ' درهم.  ' ) ;

                $pdf->SetFont('Helvetica', 12);

                $pdf->SetXY(39, 27.5);
                $pdf->Write(0,$dossier->produit->constructible->immeuble->tranche->num) ;

                $pdf->SetXY(65, 27.5);
                $pdf->Write(0,$dossier->produit->constructible->immeuble->num) ;

                $pdf->SetXY(95, 27.5);
                $pdf->Write(0,$dossier->produit->constructible->surface) ;

                $pdf->SetXY(152, 27.5);
                $pdf->Write(0,$dossier->produit->constructible->etage) ;   

                $pdf->SetXY(31, 34.5);
                $pdf->Write(0,$dossier->produit->constructible->num) ;   
                
                $pdf->SetFont('aealarabiya', '', 16);   

                $pdf->SetXY(11.5, 40);
                $pdf->Write(0,$dossier->produit->constructible->composer) ;                 
                           
            }  

            if ($pageNo == 3) // 2
            {
                $pdf->SetFont('aealarabiya', '', 16);   

                $pdf->SetXY(11, 258.5);             
                $pdf->Write(0,$numberTransformer->toWords(
                    $dossier->totalPaiementsV) . ' درهم.  ' 
                    ) ;
                $pdf->SetXY(11, 88.5);
                $pdf->Write(0,$numberTransformer->toWords(
                round($dossier->produit->totalIndicatif * 0.3)
                ) . ' درهم.  ' ) ;
          
            }  
            if ($pageNo == 5) // 6
            {

            $pdf->SetXY(73  , 120);
            $pdf->Write(8, date("j/n/Y"));   
          

            }  

        }
        $pdf->Output('actes_reservation_app_standing_N_' . $dossier->produit->constructible->num
            . '.pdf', 'I'); 
    }     
}
