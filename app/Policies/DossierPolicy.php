<?php

namespace App\Policies;

use App\Models\Dossier;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class DossierPolicy
{
    use HandlesAuthorization;

    public function createDelai(User $user)
    {
        dd('') ;
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

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return mixed
     */
    public function view(User $user, Dossier $dossier)
    {
        return ($dossier->hasActe || $dossier->validate) 
                ? Response::allow()
                : Response::deny('L\' acte de réservation n\' est pas encore disponible car le client n\'a pas encore payé 30% du montant total du produit');        
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

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return mixed
     */
    public function update(Dossier $dossier)
    {
        //
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
        //
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
