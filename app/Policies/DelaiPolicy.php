<?php

namespace App\Policies;

use App\Models\Delai;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DelaiPolicy
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
     * @param  \App\Models\Delai  $delai
     * @return mixed
     */
    public function view(User $user, Delai $delai)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        dd('') ;
        return (!$dossier->isVente) 
                ? Response::allow()
                : Response::deny('Cette vente est déjà conclue'); 
    }
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delai  $delai
     * @return mixed
     */
    public function update(User $user, Delai $delai)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delai  $delai
     * @return mixed
     */
    public function delete(User $user, Delai $delai)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delai  $delai
     * @return mixed
     */
    public function restore(User $user, Delai $delai)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Delai  $delai
     * @return mixed
     */
    public function forceDelete(User $user, Delai $delai)
    {
        //
    }
}
