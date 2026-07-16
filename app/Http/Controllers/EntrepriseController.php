<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entreprises = Entreprise::orderBy('default' , 'desc')->get() ;
        return view('entreprises.index',
            [
                'entreprises' => $entreprises,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('editer entreprises')) {
                abort(403);
        }
        $villes = explode(',', $this->villes());        
        return view('entreprises.create', [
            'villes' => $villes,

        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('editer entreprise')) {
                abort(403);
        }

        $validated = $request->validate([
            'nom'    => 'required|string|unique:entreprises,nom|max:255',
            'rc'     => 'required|string|max:20',
            'patente'=> 'required|string|max:250',
            'if'     => 'required|string|max:20',
            'siege'  => 'required|string|max:250',
            'ville'  => 'required|string|max:20',
            'capital'=> 'required|numeric',
            'logo'   => 'sometimes|required|max:5000|mimes:jpg,jpeg,png',
        ], 
        [
            'nom.unique' => 'Cette entreprise est déjà enregistrée dans notre base de données.',
        ]
    );

        $entreprise             = new Entreprise() ;
        $entreprise->nom        = Str::upper($validated['nom']);
        $entreprise->rc         = $validated['rc'];
        $entreprise->patente    = $validated['patente'];
        $entreprise->if         = $validated['if'];
        $entreprise->siege      = $validated['siege'];
        $entreprise->ville      = $validated['ville'] ;
        $entreprise->capital    = $validated['capital'];        

        if($request->hasFile('logo') && $validated['logo'] != null)
        {
            $infoEntreprise = 'logo-' . Str::slug($entreprise->nom) ;
            $pjExtension = $request->file('logo')->extension() ;                 
            $pdfPath = $request->file('logo')
            ->storeAs('documents/logos', $infoEntreprise . '.' . $pjExtension) ;
            $entreprise->logo = 'documents/logos/' . $infoEntreprise . '.' . $pjExtension ;
        }
        $rslt  = $entreprise->save();

        if ($request->exists('default') && $request->exists('default') == 1 && $rslt ) {
             (Entreprise::whereNotIn('id', [$entreprise->id])->update(['default'=> 0])) ;
        }


        return redirect()->action([EntrepriseController::class, 'index'])
            ->with('message','Entreprise créée') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Http\Response
     */
    public function show(Entreprise $entreprise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Http\Response
     */
    public function edit(Entreprise $entreprise)
    {
        $villes = explode(',', $this->villes());
        return view('entreprises.edit', [
            'entreprise' => $entreprise,
            'villes' => $villes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entreprise $entreprise)
    {
        if (! Gate::allows('editer entreprise')) {
                abort(403);
        }         
        $validated = $request->validate([
            'nom' => [
            'required',
            'string',
            'max:255',
            Rule::unique('entreprises', 'nom')->ignore($entreprise),
        ],
            'rc'     => 'required|string|max:20',
            'patente'=> 'required|string|max:250',
            'if'     => 'required|string|max:20',
            'siege'  => 'required|string|max:250',
            'ville'  => 'required|string|max:20',
            'capital'=> 'required|numeric',
            'logo'   => 'sometimes|required|max:5000|mimes:jpg,jpeg,png',
        ], 
        [
            'nom.unique' => 'Cette entreprise est déjà enregistrée dans notre base de données.',
        ]
    );

        $entreprise->nom        = Str::upper($validated['nom']);
        $entreprise->rc         = $validated['rc'];
        $entreprise->patente    = $validated['patente'];
        $entreprise->if         = $validated['if'];
        $entreprise->siege      = $validated['siege'];
        $entreprise->ville      = $validated['ville'] ;
        $entreprise->capital    = $validated['capital'];        

        if($request->hasFile('logo') && $validated['logo'] != null)
        {

            $infoEntreprise =  'logo-' . Str::slug($entreprise->nom) ;
            $pjExtension = $request->file('logo')->extension() ;                 
            $pdfPath = $request->file('logo')
            ->storeAs('documents/logos', $infoEntreprise . '.' . $pjExtension) ;
            $entreprise->logo = 'documents/logos/' . $infoEntreprise . '.' . $pjExtension ;
            
        }

        $rslt  = $entreprise->update();
        if ($request->exists('default') && $request->exists('default') == 1 && $rslt ) {
             (Entreprise::whereNotIn('id', [$entreprise->id])->update(['default'=> 0])) ;
        }
        return redirect()->action([EntrepriseController::class, 'index'])
            ->with('message','Fiche entreprise modifiée') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entreprise  $entreprise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entreprise $entreprise)
    {
        if (! Gate::allows('supprimer entreprises') && ! Gate::allows('editer entreprises')) {
                abort(403);
        }     

        if ($entreprise->projets->count() != 0) {
            return redirect()->back()
            ->with('error','Supression impossible. Un projet existe déjà pour cette entreprise.');
        }else{

            $entreprise->delete() ;

        }
        return redirect()->action([EntrepriseController::class, 'index'])
        ->with('message','Entreprise supprimée !');
    }


        public function villes()
    {
        return $villes = "Aglou, Agadir,Afourar,Agdz,Aghbala,Aghbalou Nssardane,Agourai,Aguelmous,Ahfir,Ahrara,Ain Bni Mathar,Ain Cheggag,Ain Dorij,Ain El Aouda,Ain Erreggada,Ain Harrouda,Ain Jemaa,Ain Karma,Ain Leuh,Ain Taoujdate,Ait Baha,Ait Daoud,Ait Iaaza,Ait Ishaq,Ait Melloul,Ait Ourir,Ajdir,Akka,Aklim,Aknoul,Al Aaroui,Alnif,Amalou Ighriben,Amizmiz,Aoufous,Aoulouz,Aourir,Arbaoua,Arfoud,Asilah,Assa,Assahrij,Azemmour,Azilal,Azrou,Bab Berrad,Bab Taza,Ben Ahmed,Ben Guerir,Ben Slimane,Ben Taieb,Beni Mellal,Beni Yakhlef,Berkane,Berrechid,Bhalil,Biougra,Bir Jdid,Bni Bouayach,Bni Chiker,Bni Drar,Bni Hadifa,Bni Tadjite,Bouanane,Bouarfa,Bouderbala,Boudnib,Bouguedra,Bouhdila,Bouizakarn,Boujad,Boujniba,Bouknadel,Boulanouare,Boulemane,Boumalne Dades,Boumia,Bouskoura,Bouznika,Bradia,Brikcha,Bzou,Cape Bojador,Casablanca,Chefchaouen,Chichaoua,Dakhla,Dar Bni Karrich,Dar El Kebdani,Dar Gueddari,Dar Ould Zidouh,Debdou,Demnate,Deroua,Drarga,Driouch,Echemmaia,El Aioun Sidi Mellouk,El Borouj,El Gara,El Guerdan,El Hajeb,El Hanchane,El Kbab,El Kelaa des Sraghna,El Ksiba,El Marsa,El Menzel,El Ouatia,Er-Rich,Errachidia,Essaouira,Fam El Hisn,Farkhana,Fes,Figuig,Fkih Ben Saleh,Fnideq,Foum Jamaa,Foum Zguid,Ghafsai,Goulmima,Gourrama,Guelmim,Guercif,Gueznaia,Guigou,Guisser,Had Bouhssoussen,Had Kourt,Hadj Kaddour,Harhoura,Hattane,Hoceima,Ifran,Ighoud,Imintanoute,Imouzzer Kandar,Imouzzer Marmoucha,Imzouren,Inzegan,Irherm,Issaguen,Itzer,Jaadar,Jdida,Jebha,Jerada,Jmaat Shaim,Jorf,Jorf El Melha,Karia,Karia,Karia Ba Mohamed,Kariat Arkmane,Kasbat Tadla,Kassita,Kehf Nsour,Kelat Megnouna,Kenitra,Kerouna,Kerrouchen,Kettara,Khemis Sahel,Khemisset,Khenifra,Khnichet,Khouribga,Ksar El Kbir,Laakarta,Laaounate,Laattaouia,Laayoune,Lagouira,Lahraouyine,Lakhsas,Lalla Mimouna,Lalla Takerkoust,Lamkansa,Larache,Loudaya,Loulad,Lqliaa,M'diq,M'Rirt,Maaziz,Madagh,Marrakesh,Martil,Massa,Matmata,Mechra Bel Ksiri,Mediouna,Mehdya,Meknes,Mhaya,Midar,Midelt,Missour,Mohammedia,Moqrisset,Moulay Abdallah,Moulay Bouazza,Moulay Bousselham,Moulay Brahim,Moulay Driss Zerhoun,Moulay Yacoub,N'Zalat Bni Amar,Nador,Naima,Nouaceur,Ouad Laou,Oualidia,Ouaouizert,Ouarzazate,Ouazzane,Oued Amlil,Oued El Heimar,Oujda,Oulad Abbou,Oulad Amrane,Oulad Ayad,Oulad Berhil,Oulad Ghadbane,Oulad Hriz Sahel,Oulad M'Rah,Oulad Mbarek,Oulad Said,Oulad Tayeb,Oulad Teima,Oulad Yaich,Oulad Zbair,Ouled Frej,Oulmes,Ounagha,Outat El Haj,Rabat,Ras El Ain,Ras Kebdana,Ribat El Kheir,Rissani,Rommani,Sabaa Aiyoun,Safi,Saidia,Sale,Sebt Gzoula,Sebt Jahjouh,Sebt Lamaarif,Sefrou,Segangan,Selouane,Settat,Sid L'Mokhtar,Sid Zouine,Sidi Abdallah Ghiat,Sidi Addi,Sidi Ahmed,Sidi Ali Ben Hamdouche,Sidi Allal El Bahraoui,Sidi Allal Tazi,Sidi Bennour,Sidi Bou Othmane,Sidi Boubker,Sidi Bouzid,Sidi Ifni,Sidi Jaber,Sidi Kacem,Sidi Rahal,Sidi Rahel Chatai,Sidi Slimane,Sidi Slimane Echcharraa,Sidi Smail,Sidi Taibi,Sidi Yahya El Gharb,Skhinate,Skhirat,Skhour Rhamna,Skoura,Smara,Smimou,Soualem,Souk El Had,Souk Larbaa,Suq Sebt Oulad Nama,Tabounte,Tafersit,Tafetachte,Tafrawt,Taghjijt,Tahannaout,Tahla,Tainaste,Taliouine,Talmest,Talsint,Tamallalt,Tamanar,Tamassint,Tameslouht,Tan-Tan,Tangier,Taouima,Taounate,Taourirt,Tarfaya,Targuist,Taroudant,Tata,Taza,Taznakht,Temara,Temsia,Tendrara,Tetouan,Thar Essouk,Tiddas,Tifelt,Tighassaline,Tighza,Timahdite,Tinghir,Tinjdad,Tissa,Tit Mellil,Tizi Ouasli,Tiznit,Tiztoutine,Tnin Sidi Lyamani,Touissit,Tounfit,Wad Zam,Youssoufia,Zag,Zagora,Zaida,Zaio,Zaouiat Bougrin,Zawiyat cheikh,Zirara,Zmamra,Zoumi,Zrarda" ;
    }    
}
