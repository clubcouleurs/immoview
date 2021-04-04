<?php

namespace App\Policies;

use App\Models\Paiement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class PaiementPolicy
{
    use HandlesAuthorization;

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
     * @param  \App\Models\Paiement  $paiement
     * @return mixed
     */
    public function edit(User $user, Paiement $paiement)
    {
        return ( ($user->id == $paiement->dossier->user_id
                && Gate::allows('editer ses paiements'))
                || (Gate::allows('editer paiements')) ) 

                ? Response::allow()
                : Response::deny('Vous n\'avez pas le droit d\'éditer ce paiement ou ce bordereau');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paiement  $paiement
     * @return mixed
     */
    public function update(User $user, Paiement $paiement)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paiement  $paiement
     * @return mixed
     */
    public function delete(User $user, Paiement $paiement)
    {
        return ( ($user->id == $paiement->dossier->user_id
                && Gate::allows('supprimer ses paiements'))
                || (Gate::allows('supprimer paiements')) ) 

                ? Response::allow()
                : Response::deny('Vous n\'avez pas le droit de supprimer ce paiement ou ce bordereau');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paiement  $paiement
     * @return mixed
     */
    public function restore(User $user, Paiement $paiement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paiement  $paiement
     * @return mixed
     */
    public function forceDelete(User $user, Paiement $paiement)
    {
        //
    }
}
