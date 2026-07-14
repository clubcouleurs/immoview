<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProjectSelected
{
    public function handle(Request $request, Closure $next)
    {
        // Si la session n'a pas de project_id
        if (!session()->has('project_id')) {
            // On redirige vers la liste des projets avec un message
            // Change 'projects.index' par le nom de TA route de sélection
            return redirect()->route('projects.index')
                             ->with('error', 'Veuillez sélectionner un projet pour continuer.');
        }

        return $next($request);
    }
}