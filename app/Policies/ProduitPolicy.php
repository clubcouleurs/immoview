<?php

namespace App\Policies;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class ProduitPolicy
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
     * @param  \App\Models\Produit  $produit
     * @return mixed
     */
    public function view(User $user, Produit $produit)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Produit $produit)
    {
        if (! Gate::allows('Ajouter dossiers ' . p($produit->constructible_type)) 
            && ! Gate::allows('Ajouter dossiers ' . p($produit->constructible_type) . ' standing')
    ) {
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
     * @param  \App\Models\Produit  $produit
     * @return mixed
     */
    public function update(User $user, Produit $produit)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Produit  $produit
     * @return mixed
     */
    public function delete(User $user, Produit $produit)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Produit  $produit
     * @return mixed
     */
    public function restore(User $user, Produit $produit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Produit  $produit
     * @return mixed
     */
    public function forceDelete(User $user, Produit $produit)
    {
        //
    }
}
