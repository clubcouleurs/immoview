<?php

namespace App\Policies;

use App\Models\Dossier;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;


class DossierPolicy
{
    use HandlesAuthorization;

    public function createDelai(User $user)
    {
        
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    public function index(User $user)
    {
   
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return mixed
     */
    public function view(User $user, Dossier $dossier)
    {
        if ( ($user->id == $dossier->user_id
                && Gate::allows('voir actes ses dossiers'))
                || (Gate::allows('voir actes')) )
        {
            return ($dossier->hasActe || $dossier->validate) 
                    ? Response::allow()
                    : Response::deny('L\' acte de réservation n\' est pas encore disponible car le client n\'a pas encore payé 30% du montant total du produit');              
        }
        else
        {
            Response::deny('Vous n\'avez pas le droit de voir ce dossier');              
        }
    }


    public function show(User $user, Dossier $dossier)
    {
        return ( ($user->id == $dossier->user_id
                && Gate::allows('voir ses propres dossiers'))
                || (Gate::allows('voir dossiers ' . p($dossier->produit->constructible_type))) ) 

                ? Response::allow()
                : Response::deny('Vous n\'avez pas le droit de voir ce dossier');        
    }

    public function showPaiement(User $user, Dossier $dossier)
    {
        return ( ($user->id == $dossier->user_id
                && Gate::allows('voir ses paiements'))
                || (Gate::allows('voir paiements')) ) 

                ? Response::allow()
                : Response::deny('Vous n\'avez pas le droit de voir les paiements ou les bordereaux pour ce dossier');        
    }

    public function ajoutPaiement(User $user, Dossier $dossier)
    {
        return ( ($user->id == $dossier->user_id
                && Gate::allows('editer ses paiements'))
                || (Gate::allows('editer paiements')) ) 

                ? Response::allow()
                : Response::deny('Vous n\'avez pas le droit d\'ajouter un paiement ou un bordereau pour ce dossier');        
    }    

    public function edit(User $user, Dossier $dossier)
    {
        return ( ($user->id == $dossier->user_id
                && Gate::allows('editer ses propres dossiers'))
                || (Gate::allows('editer dossiers ' . p($dossier->produit->constructible_type))) ) 

                ? Response::allow()
                : Response::deny('Vous n\'avez pas le droit de modifier ce dossier');        
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Dossier $dossier)
    {
        return ($dossier->hasActe || $dossier->validate) 
                ? Response::deny('Ce dossier est déjà validé ou le client a déjà payé 30% du montant total du produit')
                : Response::allow();
        
    }

    public function createWithoutClient(User $user)
    {
         if (! Gate::allows('Ajouter dossiers ' . p($produit->constructible_type))) {
                abort(403);
        }

        return $produit->etiquette->label === 'En stock'
                ? Response::allow()
                : Response::deny('Ce produit immobilier est déjà réservé ou vendu');
    }
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return mixed
     */
    public function update(Dossier $dossier)
    {
        return ( ($user->id == $dossier->user_id
                && Gate::allows('editer ses propres dossiers'))
                || (Gate::allows('editer dossiers ' . p($dossier->produit->constructible_type))) ) 

                ? Response::allow()
                : Response::deny('Vous n\'avez pas le droit de modifier ce dossier'); 
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return mixed
     */
    public function delete(User $user, Dossier $dossier)
    {
        return ( ($user->id == $dossier->user_id
                && Gate::allows('supprimer ses propres dossiers'))
                || (Gate::allows('supprimer dossiers ' . p($dossier->produit->constructible_type))) ) 

                ? Response::allow()
                : Response::deny('Vous n\'avez pas le droit de supprimer ce dossier'); 
    }

    public function actes(User $user, Dossier $dossier)
    {
      
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return mixed
     */
    public function restore(User $user, Dossier $dossier)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return mixed
     */
    public function forceDelete(User $user, Dossier $dossier)
    {
        //
    }
}
