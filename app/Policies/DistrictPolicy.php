<?php

namespace App\Policies;

use App\District;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DistrictPolicy
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
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\District  $district
     * @return mixed
     */
    public function view(User $user, District $district)
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\District  $district
     * @return mixed
     */
    public function update(User $user, District $district)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\District  $district
     * @return mixed
     */
    public function delete(User $user, District $district)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\District  $district
     * @return mixed
     */
    public function restore(User $user, District $district)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\District  $district
     * @return mixed
     */
    public function forceDelete(User $user, District $district)
    {
        return false;
    }
}
