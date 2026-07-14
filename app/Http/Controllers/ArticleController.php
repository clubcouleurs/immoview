<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ContratController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        if (! Gate::allows('editer contrats')) {
                abort(403);
        }        
        return view('contrats.articles.edit', [
            'article'   => $article, 
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {

        if (! Gate::allows('editer contrats')) {
                abort(403);
        }         
        $request->validate([
            'titre'    => 'required|string|max:255',
            'texte'       => 'required|string',
        ]);

        $article->titre        = $request['titre'] ;
        $article->texte        = $request['texte'] ;

        $article->update();

        return redirect()->action([ContratController::class, 'index'], ['type' => $article->contrat->type_produit])
            ->with('message','Article modifié') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if (! Gate::allows('supprimer contrats')) {
                abort(403);
        }
        $article->delete() ;
        return redirect()->action([ContratController::class, 'index'], ['type' => 'lot'])
        ->with('message','Article supprimé !');
    }
}
