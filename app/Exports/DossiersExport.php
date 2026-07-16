<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\Dossier;
use App\Models\Lot;
use App\Models\Produit;
use App\Models\Tranche;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;


class DossiersExport implements FromView
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

        $constructible = $this->request['constructible'] ;
        $projet_id = session('projet_id') ;

        if ($constructible == 'appartement' && isset($this->request['type']) && !is_null($this->request['type']))
        {
            $typeApp = $this->request['type'] ;
        }

        if (Gate::none(['voir dossiers ' . p($constructible),
                'voir ses propres dossiers'
                , 'voir dossiers ' . p($constructible) . ' standing'])) {
            abort(403);
        }
        if (!isset($typeApp) && $constructible=="appartement" && !Gate::allows('voir dossiers ' . p($constructible))) {
            abort(403);
        }  

        $tranche = $this->request['tranche'] ;
        $tranches = Tranche::where('projet_id' , session('projet_id'))->orderBy('num')->get();
        $tranchesArray = ($tranche == null) ? $tranches->pluck('id')->toArray() : [$tranche] ;
        $constructiblesArray = ($constructible == null) ?
                    ['lot','appartement','place','magasin','bureau'] : [$constructible] ;

          if ($constructible == 'appartement' && isset($this->request['type']) && !is_null($this->request['type']))
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
        if ($constructible == 'appartement' && isset($this->request['type']) && !is_null($this->request['type']))
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
          if ($constructible == 'appartement' && isset($this->request['type'])  && !is_null($this->request['type']))
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
        if (isset($this->request['sign']) && $this->request['sign'] != '' ) {

            if(isset($this->request['tauxComparateur']) && $this->request['tauxComparateur'] != '-' ) {

            $tauxComparateur = $this->request['tauxComparateur'] ;
            $sign = $this->request['sign'] ;
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
        if (isset($this->request['num']) && $this->request['num'] != '' ) {
            $numsDossier = preg_split("/[\s,\.]+/", $this->request['num']);
            $numsDossier = array_map('trim', $numsDossier);
            $dossiersAll = $dossiersAll->whereIn('produit.constructible.num', $numsDossier);
        }

        //recherche par nom, prénom ou CIN client
        if (isset($this->request['client']) && $this->request['client'] != '' ) {
            $value = strtolower($this->request['client']) ;
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
                case 'place':
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
        if (isset($this->request['user']) && $this->request['user'] != '-' ) {
            $user = $this->request['user'] ;
            $dossiersAll = $dossiersAll->where('user_id', $user); 
        }

        //recherche par relance 
        if (isset($this->request['relance']) && $this->request['relance'] != '-' ) {
            $relance = $this->request['relance'] ;
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
            $dossiersAll = $dossiersAll->whereBetween('date', [$dateStart, $dateEnd] ); 

        }elseif ($dateStartExist == true && $dateEndExist == false) {
            $dossiersAll = $dossiersAll->where('date' , $dateStart); 

        }elseif ($dateStartExist == false && $dateEndExist == true) {
            $dossiersAll = $dossiersAll->where('date' , $dateEnd); 
        }

        //recherche par etat du dossier
        if (isset($this->request['etatDossier']) && $this->request['etatDossier'] != '-' ) {
            $etat = $this->request['etatDossier'] ;
            $dossiersAll = $dossiersAll->where('isVente', $etat);  
        }

        // recherche par etat légale du dossier
        if (isset($this->request['litige']) && $this->request['litige'] != '' ) {
            $litige = $this->request['litige'] ;
            $dossiersAll = $dossiersAll->where('litige', $litige);  
        }
        // recherche par etat transfert du dossier
        if (isset($this->request['transfert']) && $this->request['transfert'] != '' ) {

            $dossiersAll = $dossiersAll->whereNotNull('transferred_at');  
        }        

        // recherche par etat légale du dossier
        if (isset($this->request['desisstement']) && $this->request['desisstement'] != '' ) {

            $dossiersAll = Dossier::onlyTrashed()
                            ->whereHas('produit', function (Builder $query) use ($projet_id) {
                                    $query->where('projet_id', $projet_id);
                            })->get();  
        }

     

        return view('exports.dossiers', [
            'dossiers'              => $dossiersAll,
            'totalDossier'          => $dossiersAll->count(),
            'clients'               =>   Client::all(),
            'users'                 => User::whereIn('role_id',[2,5,6])->get(),
            'dossiersParType'       => Dossier::dossiersParType(),
            'tranches'              => $tranches ,
            'etatDossier'           => $this->request['etatDossier'],
            'SearchByUser'          => $this->request['user'] ,
            'SearchBySign'          => $this->request['sign'] ,
            'SearchByTauxComparateur'          => $this->request['tauxComparateur'] ,
            'SearchByTranche'       => $tranche,
            'dateEnd'               => $this->request['dateEnd'],
            'dateStart'               => $this->request['dateStart'],
            'SearchByRelance'           => $this->request['relance'],
            'SearchByNum'           => implode(',' , $numsDossier) ,
            'SearchByClient'        => $this->request['client'] ,
            'constructible'         => $constructible ,
            'reserved' => $reserved , 
            'stocked' => $stocked , 
            'r' => $r , 
            'blocked' => $blocked
        ]);
    }
}
