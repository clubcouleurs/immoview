<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projets.index', [
            'projets' => Projet::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('editer projets')) {
                abort(403);
        }        
        $entreprises = Entreprise::All() ;
        $villes = explode(',', $this->villes());        
        $types_constructibles = ['lot','appartement','magasin','bureau'] ;
        return view('projets.create', [
            'villes' => $villes,
            'types_constructibles' => $types_constructibles,
            'entreprises' => $entreprises,
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
        if (! Gate::allows('editer projets')) {
                abort(403);
        }

        $validated = $request->validate([
            'nom'   => 'required|string|unique:projets',
            'entreprise'   => 'required|integer',
            'date'  => 'required|date',
            'default' => 'integer',
            'ville' => 'required|string',
            'type_constructible.*' => 'string',
            'type_constructible' => 'required|array|min:1',
            'titre' => 'string',
        ],
        [
            'type_constructible.required' => 'Vous devez cocher au moins un type de biens.',
        ]
    );
        $type_constructible = implode(',' , $validated['type_constructible']) ;
        $entreprise = Entreprise::findOrFail($validated['entreprise']) ;

        $projet = new Projet() ;
        $projet->nom                = $validated['nom'];
        $projet->date               = $validated['date'];
        $projet->default            = $request->exists('default') ? 1 : 0 ;
        $projet->ville              = $validated['ville'];
        $projet->type_constructible = $type_constructible ;
        $projet->titre              = $validated['titre'];
        $projet->save();
        $rslt = $entreprise->projets()->save($projet) ;
        if ($request->exists('default') && $request->exists('default') == 1 && $rslt ) {
             (Projet::whereNotIn('id', [$projet->id])->update(['default'=> 0])) ;
        }
        return redirect()->action([ProjetController::class, 'index'])
        ->with('message','Projet ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function show(Projet $projet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function edit(Projet $projet)
    {
        if (! Gate::allows('editer projets')) {
                abort(403);
        }
        $villes = explode(',', $this->villes());        
        $types_constructibles_projet = explode(',' , $projet->type_constructible) ;
        $types_constructibles = ['lot','appartement','magasin','bureau'] ;
        $entreprises = Entreprise::All() ;
        return view('projets.edit', [
            'projet' => $projet,
            'villes' => $villes,
            'types_constructibles' => $types_constructibles,
            'types_constructibles_projet' => $types_constructibles_projet,
            'entreprises' => $entreprises, 
        ]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projet $projet)
    {
        if (! Gate::allows('editer projets')) {
                abort(403);
        }

        $validated = $request->validate([
            'nom'   => 'required|string|unique:projets,nom,'.$projet->id,
            'entreprise'   => 'required|integer',
            'date'  => 'required|date',
            'default' => 'integer',
            'ville' => 'required|string',
            'type_constructible.*' => 'string',
            'type_constructible' => 'required|array|min:1',
            'titre' => 'string',
        ],
        [
            'type_constructible.required' => 'Vous devez cocher au moins un type de biens.',
        ]
    );
        $entreprise = Entreprise::findOrFail($validated['entreprise']) ;
        $type_constructible = implode(',' , $validated['type_constructible']) ;
        $projet->nom                = $validated['nom'];
        $projet->date               = $validated['date'];
        $projet->default            = $request->exists('default') ? 1 : 0 ;
        $projet->ville              = $validated['ville'];
        $projet->type_constructible = $type_constructible ;
        $projet->titre              = $validated['titre'];
        $projet->update();
        $rslt = $entreprise->projets()->save($projet) ;
        if ($request->exists('default') && $request->exists('default') == 1 && $rslt ) {
             (Projet::whereNotIn('id', [$projet->id])->update(['default'=> 0])) ;
        }
        return redirect()->action([ProjetController::class, 'index'])
        ->with('message','Projet modifié !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projet $projet)
    {
        //
    }

        public function villes()
    {
        return $villes = "Agadir,Aglou,Afourar,Agdz,Aghbala,Aghbalou Nssardane,Agourai,Aguelmous,Ahfir,Ahrara,Ain Bni Mathar,Ain Cheggag,Ain Dorij,Ain El Aouda,Ain Erreggada,Ain Harrouda,Ain Jemaa,Ain Karma,Ain Leuh,Ain Taoujdate,Ait Baha,Ait Daoud,Ait Iaaza,Ait Ishaq,Ait Melloul,Ait Ourir,Ajdir,Akka,Aklim,Aknoul,Al Aaroui,Alnif,Amalou Ighriben,Amizmiz,Aoufous,Aoulouz,Aourir,Arbaoua,Arfoud,Asilah,Assa,Assahrij,Azemmour,Azilal,Azrou,Bab Berrad,Bab Taza,Ben Ahmed,Ben Guerir,Ben Slimane,Ben Taieb,Beni Mellal,Beni Yakhlef,Berkane,Berrechid,Bhalil,Biougra,Bir Jdid,Bni Bouayach,Bni Chiker,Bni Drar,Bni Hadifa,Bni Tadjite,Bouanane,Bouarfa,Bouderbala,Boudnib,Bouguedra,Bouhdila,Bouizakarn,Boujad,Boujniba,Bouknadel,Boulanouare,Boulemane,Boumalne Dades,Boumia,Bouskoura,Bouznika,Bradia,Brikcha,Bzou,Cape Bojador,Casablanca,Chefchaouen,Chichaoua,Dakhla,Dar Bni Karrich,Dar El Kebdani,Dar Gueddari,Dar Ould Zidouh,Debdou,Demnate,Deroua,Drarga,Driouch,Echemmaia,El Aioun Sidi Mellouk,El Borouj,El Gara,El Guerdan,El Hajeb,El Hanchane,El Kbab,El Kelaa des Sraghna,El Ksiba,El Marsa,El Menzel,El Ouatia,Er-Rich,Errachidia,Essaouira,Fam El Hisn,Farkhana,Fes,Figuig,Fkih Ben Saleh,Fnideq,Foum Jamaa,Foum Zguid,Ghafsai,Goulmima,Gourrama,Guelmim,Guercif,Gueznaia,Guigou,Guisser,Had Bouhssoussen,Had Kourt,Hadj Kaddour,Harhoura,Hattane,Hoceima,Ifran,Ighoud,Imintanoute,Imouzzer Kandar,Imouzzer Marmoucha,Imzouren,Inzegan,Irherm,Issaguen,Itzer,Jaadar,Jdida,Jebha,Jerada,Jmaat Shaim,Jorf,Jorf El Melha,Karia,Karia,Karia Ba Mohamed,Kariat Arkmane,Kasbat Tadla,Kassita,Kehf Nsour,Kelat Megnouna,Kenitra,Kerouna,Kerrouchen,Kettara,Khemis Sahel,Khemisset,Khenifra,Khnichet,Khouribga,Ksar El Kbir,Laakarta,Laaounate,Laattaouia,Laayoune,Lagouira,Lahraouyine,Lakhsas,Lalla Mimouna,Lalla Takerkoust,Lamkansa,Larache,Loudaya,Loulad,Lqliaa,M'diq,M'Rirt,Maaziz,Madagh,Marrakesh,Martil,Massa,Matmata,Mechra Bel Ksiri,Mediouna,Mehdya,Meknes,Mhaya,Midar,Midelt,Missour,Mohammedia,Moqrisset,Moulay Abdallah,Moulay Bouazza,Moulay Bousselham,Moulay Brahim,Moulay Driss Zerhoun,Moulay Yacoub,N'Zalat Bni Amar,Nador,Naima,Nouaceur,Ouad Laou,Oualidia,Ouaouizert,Ouarzazate,Ouazzane,Oued Amlil,Oued El Heimar,Oujda,Oulad Abbou,Oulad Amrane,Oulad Ayad,Oulad Berhil,Oulad Ghadbane,Oulad Hriz Sahel,Oulad M'Rah,Oulad Mbarek,Oulad Said,Oulad Tayeb,Oulad Teima,Oulad Yaich,Oulad Zbair,Ouled Frej,Oulmes,Ounagha,Outat El Haj,Rabat,Ras El Ain,Ras Kebdana,Ribat El Kheir,Rissani,Rommani,Sabaa Aiyoun,Safi,Saidia,Sale,Sebt Gzoula,Sebt Jahjouh,Sebt Lamaarif,Sefrou,Segangan,Selouane,Settat,Sid L'Mokhtar,Sid Zouine,Sidi Abdallah Ghiat,Sidi Addi,Sidi Ahmed,Sidi Ali Ben Hamdouche,Sidi Allal El Bahraoui,Sidi Allal Tazi,Sidi Bennour,Sidi Bou Othmane,Sidi Boubker,Sidi Bouzid,Sidi Ifni,Sidi Jaber,Sidi Kacem,Sidi Rahal,Sidi Rahel Chatai,Sidi Slimane,Sidi Slimane Echcharraa,Sidi Smail,Sidi Taibi,Sidi Yahya El Gharb,Skhinate,Skhirat,Skhour Rhamna,Skoura,Smara,Smimou,Soualem,Souk El Had,Souk Larbaa,Suq Sebt Oulad Nama,Tabounte,Tafersit,Tafetachte,Tafrawt,Taghjijt,Tahannaout,Tahla,Tainaste,Taliouine,Talmest,Talsint,Tamallalt,Tamanar,Tamassint,Tameslouht,Tan-Tan,Tangier,Taouima,Taounate,Taourirt,Tarfaya,Targuist,Taroudant,Tata,Taza,Taznakht,Temara,Temsia,Tendrara,Tetouan,Thar Essouk,Tiddas,Tifelt,Tighassaline,Tighza,Timahdite,Tinghir,Tinjdad,Tissa,Tit Mellil,Tizi Ouasli,Tiznit,Tiztoutine,Tnin Sidi Lyamani,Touissit,Tounfit,Wad Zam,Youssoufia,Zag,Zagora,Zaida,Zaio,Zaouiat Bougrin,Zawiyat cheikh,Zirara,Zmamra,Zoumi,Zrarda" ;
    }
}
