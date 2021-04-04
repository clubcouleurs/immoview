<?php

namespace App\Http\Controllers;

use App\Http\Requests\DossierRequest;
use App\Http\Traits\PaginateTrait;
use App\Models\Client;
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
    public function index(Request $request)
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


        if (Gate::allows('voir dossiers ' . p($constructible))) {
        $dossiersAll = Dossier::whereHas('produit', function (Builder $query) use ($constructiblesArray)
                            {
                                $query->whereIn('constructible_type', $constructiblesArray);
                            })
                            ->with('produit')
                            ->with('delais')
                            ->with('client')
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
                            ->with('client')
                            ->with('paiements')->orderbyDesc('created_at')
                            ->get();           
        }
        //recherche par taux de paiement
        if (isset($request['sign']) && $request['sign'] != '' ) {

            if(isset($request['tauxComparateur']) && $request['tauxComparateur'] != '-' ) {

            $tauxComparateur = $request['tauxComparateur'] ;
            $sign = $request['sign'] ;
            $dossiersAll = $dossiersAll->filter(function ($dossier) use ($sign, $tauxComparateur)  {
            $taux = $dossier->paiements->sum('montant') * 100 /
                            ($dossier->produit->Total) ;
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

            $dossiersAll = $dossiersAll->filter(function ($item) use ($value)  {
            $client = strtolower(trim($item->client->cin . ' ' . $item->client->nom . ' ' . $item->client->prenom . ' ' ));

                    if (strpos($client , $value) !== false) {
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

        //recherche par nombre d'etages
        if (isset($request['nombreEtagesLot']) && $request['nombreEtagesLot'] != '-' ) {
            $et = $request['nombreEtagesLot'] ;
            $lotsAll = $lotsAll->where('lot.nombreEtagesLot', $et); 
        }  

        //recherche par type de lot
        if (isset($request['typeLot']) && $request['typeLot'] != '-' ) {
            $ty = $request['typeLot'] ;
            $lotsAll = $lotsAll->where('lot.typeLot', $ty);  
        }           

        //recherche par etat du lot
        if (isset($request['etatDossier']) && $request['etatDossier'] != '-' ) {
            $etat = $request['etatDossier'] ;
            $dossiersAll = $dossiersAll->where('isVente', $etat);  
        }           

            //$total = 0 ;
           //$totalPaiements = $dossiersAll->map(function ($item, $key) use ($total) {
           //     return $total = $total + $item->lot->surfaceLot * $item->prixM2Definitif;
           // });


        return view('dossiers.index', [
            'dossiers'              => $this->paginate($dossiersAll),
            'totalDossier'          => $dossiersAll->count(),
            'clients'               =>   Client::all(),
            'users'                 => User::all(),
            'dossiersParType'       => Dossier::dossiersParType(),
            'tranches'              => $tranches ,
            'valeurTotal'           => 1000, //$prixTotalLots->sum(),
            'etatDossier'           => $request['etatDossier'],
            'SearchByUser'          => $request['user'] ,
            'SearchBySign'          => $request['sign'] ,
            'SearchByTauxComparateur'          => $request['tauxComparateur'] ,
            'SearchByTranche'       => $tranche,
            'SearchByMin'           => '',//$request['minPrix'] ,
            'SearchByRelance'           => $request['relance'],
            'SearchByNum'           => implode(',' , $numsDossier) ,
            'SearchByClient'        => $request['client'] ,
            'constructible'         => $constructible ,


        ]);
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
                       'Ajouter dossiers boxes' ,
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
                       'Ajouter dossiers boxes' ,
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
        
        if (! Gate::allows('Ajouter dossiers ' . p($constructible))) {
                abort(403);
        }

        $dossier = new Dossier([
            'num'               => $request['num'] ,    
            'date'              => $request['date'] ,
            'frais'             => $request['frais'] ,
            'detail'            => $request['detail'],
            'client_id'         => $request['client'],
            'produit_id'        => $request['produit'],
            'user_id'           => Auth::id(),
            'isVente'           => $request['isVente'],
        ]) ;

            if(isset($produit) && $produit->etiquette_id === 2 )
            {
                $dossier->save();
                if ($dossier->isVente) {
                    $dossier->produit->etiquette_id = 3 ;
                }else
                {                    
                    $dossier->produit->etiquette_id = 9 ;
                }
                $dossier->produit->update() ;

                if ($dossier->isVente == false) {
                    $delai = new Delai([
                        'date'              => $request['delai'] ,
                    ]) ;
                    $dossier->delais()->save($delai) ;
                }

                return redirect(
                    '/dossiers?constructible='. $produit->constructible_type
                )->with('message','Dossier ajouté !');
            }

            return Redirect::back()->withErrors(['msg', 'Attention : ' .
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
            'users'                 => User::all(),
            'tranches'              => '' ,
            'valeurTotal'           => 1000, //$prixTotalLots->sum(),
            'SearchByTranche'       => '',//$request['tranche'] ,
            'SearchByUser'          => '',//$request['user'] ,
            'SearchBySign'         => '',//$request['sign'] ,
            'SearchByTauxComparateur'          => '',//$request['tauxComparateur'] ,
            'SearchByType'          => '',//$request['typeLot'] ,
            'SearchByMin'           => '',//$request['minPrix'] ,
            'SearchByMax'           => '',//$request['maxPrix'] ,
            'SearchByNum'           =>  '',//implode(',' , $numsDossier) ,
            'SearchByClient'        => '',//$request['client'] ,


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
            'dossier' => $dossier,
            'produit' => $dossier->produit,
            'client'  => $dossier->client,
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
        if($request->hasFile('actePj'))
        {

            $client = $dossier->client->nom . '-' . $dossier->client->prenom ;

            $pjName = 'acte-reservation' . '-dossierNum' 

            . str_replace('.', '', $dossier->num) . '-' 

            . str_replace('.', '',  $client ) . '-' 

            . str_replace(' ', '-', date('Y-m-d-His')) ;

            $pjExtension = $request->file('actePj')->extension() ;                 

            $pdfPath = $request->file('actePj')
            ->storeAs('public/actes', $pjName . '.' . $pjExtension) ;

            $dossier->actePj = 'actes/' . $pjName . '.' . $pjExtension ;

        }else
        {
            $dossier->num = $request['num']; 
            $dossier->date = $request['date'];
            $dossier->frais = $request['frais'];
            $dossier->detail = $request['detail'];
        }
            $dossier->update(); 
        return redirect()->action([DossierController::class, 'index'])
        ->with('message','Dossier modifié') ;
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

        $dossier->delete() ;
        $dossier->paiements()->delete() ;

        return redirect()->action([DossierController::class, 'index'])
                ->with('message','Dossier supprimé !');
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
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
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
            $prenom = stripslashes($dossier->client->prenom);
            $prenom = iconv('UTF-8', 'windows-1252', $prenom);

            $nom = stripslashes($dossier->client->nom);
            $nom = iconv('UTF-8', 'windows-1252', $nom);

            $pdf->SetXY(75, 93.75);
            $nomC = ucfirst($nom) . ' ' . ucfirst($prenom) ;
            $pdf->Write(8, $nomC);

            $adresse = stripslashes($dossier->client->adresse);
            $adresse = iconv('UTF-8', 'windows-1252', $adresse);

            $pdf->SetXY(83, 99);
            $pdf->Write(8, ucfirst(preg_replace( "/\r|\n/", " ", $adresse )));

            $pdf->SetXY(147, 104.25);
            $pdf->Write(8, ucfirst($dossier->client->cin));    

            $pdf->SetXY(120, 266.25);
            $pdf->Write(8, ucfirst($dossier->produit->constructible->num));   

            $pdf->SetXY(180, 266.25);
            $pdf->Write(8, ucfirst($dossier->produit->constructible->tranche_id));    

            $pdf->SetXY(105.25, 275.8);
            $pdf->Write(0, 
                ucfirst($dossier->produit->constructible->surface) .
                'm2 (R+' . $dossier->produit->constructible->etage . ').'
            );   
            }    

            if ($pageNo == 2)
            {

            $pdf->SetXY(49, 32);
            $pdf->Write(8, number_format($dossier->produit->total));   

            $pdf->SetXY(80, 32);
            $pdf->Write(8, ucfirst($numberTransformer->toWords($dossier->produit->total)) . ' dirhams');  

            $pdf->SetXY(50.25, 37.25);
            $pdf->Write(8, $dossier->produit->prix);    

            // affichage du 30% du prix en chiffre
            $pdf->SetXY(49, 56);
            $pdf->Write(0, number_format((($dossier->produit->total) * 30) /100 ));   

            // affichage du 30% du prix en lettre
            $pdf->SetXY(80, 56);
            $pdf->Write(0, ucfirst($numberTransformer->toWords((($dossier->produit->total) * 30) /100 )) . ' dirhams');  

            }  

            if ($pageNo == 4)
            {

            $pdf->SetXY(113, 101.5);
            $pdf->Write(8, date("j/n/Y"));   
          

            }  

        }

        // Output the new PDF
        $pdf->Output('D', 'actes_reservation_lot_N_' . $dossier->produit->constructible->num
            . '_' . $dossier->client->nom . '_' . $dossier->client->prenom . '.pdf', true);
    }

    public function actes(Dossier $dossier)
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
            if ($pageNo == 1) // 1 
            {
            $prenom = stripslashes($dossier->client->prenomAr);
            //$prenom = iconv('UTF-8', 'windows-1251//TRANSLIT//IGNORE', $prenom);
            //    dd('مفعول') ;
            $nom = stripslashes($dossier->client->nomAr);
            //$nom = iconv("Windows-1256//TRANSLIT//IGNORE", "UTF-8//TRANSLIT//IGNORE", 'مفعول');

            $pdf->SetXY(35, 95.75);
            $nomC =  $nom . ' ' . $prenom ;
            $pdf->Write(8, $nomC);

            $adresse = stripslashes($dossier->client->adresseAr);
            //$adresse = iconv('UTF-8', 'windows-1251//TRANSLIT//IGNORE', $adresse);

            $pdf->SetXY(14, 117);
            $pdf->Write(8, ucfirst(preg_replace( "/\r|\n/", " ", $adresse )));

            $pdf->SetXY(69, 103);
            $pdf->Write(8, ucfirst($dossier->client->cin));    
            }    

            if ($pageNo == 2) // 2
            {
                $pdf->SetFont('Helvetica', 12);

                $pdf->SetXY(56, 41.5);
                $pdf->Write(0,$dossier->produit->constructible->surface) ;

                $pdf->SetXY(104, 41.5);
                $pdf->Write(0,$dossier->produit->constructible->immeuble->tranche->num) ;

                $pdf->SetXY(142, 41.5);
                $pdf->Write(0,$dossier->produit->constructible->immeuble->num) ;

                $pdf->SetXY(45, 48.5);
                $pdf->Write(0,$dossier->produit->constructible->num) ;

                $pdf->SetXY(20, 48.5);
                $pdf->Write(0,$dossier->produit->constructible->etage) ;                
            }  

            if ($pageNo == 6) // 6
            {

            $pdf->SetXY(99, 194.5);
            $pdf->Write(8, date("j/n/Y"));   
          

            }  

        }
        $pdf->Output('actes_reservation_lot_N_' . $dossier->produit->constructible->num
            . '_' . $dossier->client->nom . '_' . $dossier->client->prenom . '.pdf', 'I'); 
        // Output the new PDF
        //$pdf->Output('D', 'actes_reservation_lot_N_' . $dossier->produit->constructible->num
        //    . '_' . $dossier->client->nom . '_' . $dossier->client->prenom . '.pdf', true);
    }    
}
