<?php

namespace App\Policies;

use App\Models\Etiquette;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EtiquettePolicy
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
     * @param  \App\Models\Etiquette  $etiquette
     * @return mixed
     */
    public function view(User $user, Etiquette $etiquette)
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
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Etiquette  $etiquette
     * @return mixed
     */
    public function update(User $user, Etiquette $etiquette)
    {
        return in_array($etiquette->id, [2,3])
                ? Response::deny('Impossible de modifier cette étiquette')
                : Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Etiquette  $etiquette
     * @return mixed
     */
    public function delete(User $user, Etiquette $etiquette)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Etiquette  $etiquette
     * @return mixed
     */
    public function restore(User $user, Etiquette $etiquette)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Etiquette  $etiquette
     * @return mixed
     */
    public function forceDelete(User $user, Etiquette $etiquette)
    {
        //
    }
}
