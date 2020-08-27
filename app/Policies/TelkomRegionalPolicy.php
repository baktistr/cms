<?php

namespace App\Policies;

use App\TelkomRegional;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TelkomRegionalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('PIC');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\TelkomRegional  $telkomRegional
     * @return mixed
     */
    public function view(User $user, TelkomRegional $telkomRegional)
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return $telkomRegional->buildings()->where('pic_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\TelkomRegional  $telkomRegional
     * @return mixed
     */
    public function update(User $user, TelkomRegional $telkomRegional)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\TelkomRegional  $telkomRegional
     * @return mixed
     */
    public function delete(User $user, TelkomRegional $telkomRegional)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\TelkomRegional  $telkomRegional
     * @return mixed
     */
    public function restore(User $user, TelkomRegional $telkomRegional)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\TelkomRegional  $telkomRegional
     * @return mixed
     */
    public function forceDelete(User $user, TelkomRegional $telkomRegional)
    {
        //
    }
}
