<?php

namespace App\Http\Middleware;

use App\Models\Projet;
use Closure;
use Illuminate\Http\Request;

class ResetIdProjetSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $projet_id = session('projet_id');
        if($projet->id == null && $projet_id == null){
            $projet = Projet::where('default' , true)->limit(1)->first() ;
           
        }
        if($projet_id != null && $projet->id == null)
        {
            $projet = Projet::where('id' , $projet_id)->limit(1)->first() ;
        }
        
        session(['projet_id' => $projet->id]);
        session(['projetConstructibles' => $projet->type_constructible]);
        session(['entreprise_id' => $projet->entreprise_id]);

        return $next($request);
    }
}
