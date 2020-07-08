<?php

namespace App\Policies;

use App\Area;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AreaPolicy
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
     * @param  \App\Area  $area
     * @return mixed
     */
    public function view(User $user, Area $area)
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return $area->assets()->where('pic_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Area  $area
     * @return mixed
     */
    public function update(User $user, Area $area)
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Area  $area
     * @return mixed
     */
    public function delete(User $user, Area $area)
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Area  $area
     * @return mixed
     */
    public function restore(User $user, Area $area)
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Area  $area
     * @return mixed
     */
    public function forceDelete(User $user, Area $area)
    {
        return $user->hasRole('Super Admin');
    }
}
