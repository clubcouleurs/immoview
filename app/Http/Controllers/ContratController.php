<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Contrat;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
        ]);
        $type = $validated['type'] ;
        $projet = session('projet_id') ;
        $contrat = Contrat::where('type_produit', $type)->where('projet_id', $projet)->first();
        $projets = Projet::whereHas('contrats', function ($query) use ($type)
                            {
                                $query->where('type_produit', '=', $type);
                            })->get();

        if($projets->isEmpty())
        {
            $projets = Projet::whereHas('contrats')->get();
        }

        if (is_null($contrat)) {
            return view('contrats.create',
                [
                    'type' => $type,
                    'projets' => $projets,
                ]);
        }
            else
        {
            $articles = $contrat->articles->sortBy('classement');
            $articles = $articles->map(function ($article){
                $article->texte =  substr(htmlspecialchars($article->texte), 0 ,200) ;
                return $article ;
            });
        }

        return view('contrats.edit', [
            'contrat' => $contrat,
            'articles' => json_encode($articles->values()->all()),
            'articlesIndexes' => $articles->keys()->toArray(),

            
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        if (! Gate::allows('editer contrats')) {
                abort(403);
        }

        $validated = $request->validate([
        'type' => 'required|string',
        ]);
        $type = $validated['type'] ;

        return $type ;

        return view('contrats.create',
            [
                'type' => $type,
                
            ]) ;
    }

    public function getTypeConstructible()
    {
        $validated = $request->validate([
        'type' => 'required|string',
        ]);
        $type = $validated['type'] ;

        return $type ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (! Gate::allows('editer contrats')) {
                abort(403);
        }
            $validated = $request->validate([
                'type' => 'required|string',
            ]);
            $type = $validated['type'] ;

        // updating classement des articles
        if ($request->has('classement')) {
            $validated = $request->validate([
                'classement.*' => 'required|integer',
            ]);
            $article_ids = $validated['classement'];
            foreach($article_ids as $id => $classement){
                Article::where('id',$id)->update(['classement' => $classement]);
            }
        return redirect()->action([ContratController::class, 'index'], ['type' => $type])
        ->with('message','Contrat modifiée !');
        }


        $projet_id = session('projet_id') ;
        $projet = Projet::findOrFail($projet_id) ;

        $contrat = new Contrat() ;
        $contrat->type_produit = $type ;
        $projet->contrats()->save($contrat);

        return redirect()->action([ContratController::class, 'index'], ['type' => $type])
        ->with('message','Contrat ajouté !');


        //     $validated = $request->validate([
        //         'titre.*' => 'required|string',
        //         'texte.*' => 'required|string',
        //     ]);

        // $projet_id = session('projet_id') ;
        // $projet = Projet::findOrFail($projet_id) ;

        // $articles_titles = $validated['titre'] ;
        // $articles_textes = $validated['texte'] ;

        // $contrat = new Contrat() ;
        // $contrat->type_produit = 'lot';
        // $projet->contrats()->save($contrat);

        // for ($i=0; $i<count($articles_textes) ; $i++)
        // { 
        //     $article = new Article() ;
        //     $article->titre = $articles_titles[$i] ;
        //     $article->texte = $articles_textes[$i] ;
        //     $article->classement = $contrat->articles->count() ;
        //     $contrat->articles()->save($article) ;
        // }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function show(Contrat $contrat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrat $contrat)
    {

        if (! Gate::allows('editer contrats')) {
                abort(403);
        }
        return view('contrats.articles.create', [
            'contrat' => $contrat,
        ]);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contrat $contrat)
    {
        
        if (! Gate::allows('editer contrats')) {
                abort(403);
        }
            $validated = $request->validate([
                'titre' => 'required|string',
                'texte' => 'required|string',
            ]);
            $article = new Article() ;
            $article->titre = $validated['titre'] ;
            $article->texte = $validated['texte'] ;
            $article->classement = $contrat->articles()->count() + 1 ;
            $contrat->articles()->save($article) ;

        return redirect()->action([ContratController::class, 'index'], ['type' => $contrat->type_produit])
        ->with('message','Article ajouté !');

// ancien code pour updater tous les articles d'un seul coup

        //     $validated = $request->validate([
        //         'titre.*' => 'required|string',
        //         'texte.*' => 'required|string',
        //         'id.*' => 'required|integer',
        //     ]);
        // $articles_ids = $validated['id'] ;
        // $articles_titles = $validated['titre'] ;
        // $articles_textes = $validated['texte'] ;
        // $idsArticlesFromDb = $contrat->articles->map(function ($article)
        // {
        //     return collect($article->toArray())->only(['id'])->all();
        // })->flatten()->toArray() ;

        // $idsArticlesToUpdate = array_intersect($idsArticlesFromDb, $articles_ids) ;
        // $idsArticlesToDelete = array_diff($idsArticlesFromDb, $idsArticlesToUpdate) ;
        // $idsArticlesToAdd = array_diff($articles_ids, $idsArticlesToUpdate) ;
        // $contrat->articles()->whereIn('id', $idsArticlesToDelete)->delete() ;

        // foreach ($idsArticlesToUpdate as $key => $value)
        // { 
        //     $article = Article::findOrFail($value) ;
        //      $article->titre = $articles_titles[$key] ;
        //      $article->texte = $articles_textes[$key] ;
        //      $article->update() ;
        // }

        // foreach ($idsArticlesToAdd as $key => $value)
        // { 
        //     $article = new Article() ;
        //     $article->titre = $articles_titles[$key] ;
        //     $article->texte = $articles_textes[$key] ;
        //     $contrat->articles()->save($article) ;
        // }

        // return redirect()->action([ContratController::class, 'index'], ['type' => 'lot'])
        // ->with('message','Contrat ajouté !');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request, Contrat $contrat, Projet $projet)
    {
        if (! Gate::allows('editer contrats')) {
                abort(403);
        }

            $validated = $request->validate([
                'type' => 'required|string',
                'projet' => 'required|string'
            ]);

            $type = $validated['type'] ;
            $projetOrigin = $validated['projet'] ;

            $projet_id = session('projet_id');
            $projetOrigin = Projet::findOrFail($projetOrigin) ;
            $contratOrigin = $projetOrigin->contrats()
                ->where('type_produit', $type)
                ->first();  

            if(is_null($contratOrigin))
            {
                $contratOrigin = $projetOrigin->contrats()->first(); 
            }


                          
    if (!$projet_id) {
        return redirect()->back()->with('error', "Aucun projet actif en session.");
    }

    DB::transaction(function () use ($contratOrigin, $projet_id, $type) {
        
        // 1. Utilisez bien findOrFail (renvoie UN SEUL modèle), pas get()
        // 2. Dupliquer le contrat parent
        $nouveauContrat = $contratOrigin->replicate();
        $nouveauContrat->projet_id = $projet_id;
        $nouveauContrat->type_produit = $type ;
        $nouveauContrat->save(); // On sauvegarde pour générer le nouvel ID de contrat
        // 3. Récupérer et boucler sur les articles du contrat original
        // On passe par la relation 'articles()' pour faire la boucle
        foreach ($contratOrigin->articles as $article) {
            
            // On réplique chaque article UNIQUE (Modèle Eloquent)
            $nouvelArticle = $article->replicate();
            
            // On lui assigne l'ID du contrat fraîchement créé
            $nouvelArticle->contrat_id = $nouveauContrat->id; 
            
            $nouvelArticle->save();
        }
    });

    return redirect()->back()->with('success', "Le contrat et ses articles ont été dupliqués !");




        //     $validated = $request->validate([
        //         'titre' => 'required|string',
        //         'texte' => 'required|string',
        //     ]);
        //     $article = new Article() ;
        //     $article->titre = $validated['titre'] ;
        //     $article->texte = $validated['texte'] ;
        //     $article->classement = $contrat->articles()->count() + 1 ;
        //     $contrat->articles()->save($article) ;

        // return redirect()->action([ContratController::class, 'index'], ['type' => $contrat->type_produit])
        // ->with('message','Article ajouté !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrat $contrat)
    {
        //
    }
}
