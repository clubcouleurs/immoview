<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BanqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banques = Banque::select('id','num','nom','abreviation')->get();

        $arrBanques = $banques->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item ];
        });
        $arrBanques = $arrBanques->toArray() ;
        
        return view('banques.index', [
            'banques'          =>  $banques,
            'arrBanques'       => json_encode($arrBanques),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('editer banques')) {
                abort(403);
        }         
        return view('banques.create') ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('editer banques')) {
                abort(403);
        }

        $validated = $request->validate([
            'nom'           => 'required|string',
            'num'           => 'required|string|unique:banques',
            'abreviation'   => 'required|string'

        ],
        [
            
        ]
    );

        $banque = new Banque ;
        $banque->num = $validated['num'] ;
        $banque->nom = $validated['nom'] ;
        $banque->abreviation = $validated['abreviation'] ;

        $banque->save() ;
        return redirect('banques')
                    ->with('message','Compte ajouté !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function show(Banque $banque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function edit(Banque $banque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banque $banque)
    {
        if (! Gate::allows('editer banques')) {
                abort(403);
        }
        $validated = $request->validate([
            'nom'           => 'required|string',
            'num'           => 'required|string',
            'abreviation'   => 'required|string'

        ],
        [
            
        ]
    );
        $banque->num         = $validated['num'];
        $banque->nom         = $validated['nom'];
        $banque->abreviation = $validated['abreviation'];

        $banque->update();

        return redirect()->action([BanqueController::class, 'index'])
        ->with('message','Compte modifié !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banque $banque)
    {
        if (! Gate::allows('editer banques')) {
                abort(403);
        }
        if (count($banque->paiements) > 0 ) {
            return redirect()->back()
            ->with('error','Supression impossible. compte utilisé.');
        }
        if(count($banque->paiements) == 0)
        {
            $banque->delete() ;
        }
        return redirect()->action([BanqueController::class, 'index'])
        ->with('message','Compte supprimé !');
    }
}
