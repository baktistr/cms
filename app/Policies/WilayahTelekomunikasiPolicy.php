<?php

namespace App\Policies;

use App\User;
use App\WilayahTelekomunikasi;
use Illuminate\Auth\Access\HandlesAuthorization;

class WilayahTelekomunikasiPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\WilayahTelekomunikasi  $wilayahTelekomunikasi
     * @return mixed
     */
    public function view(User $user, WilayahTelekomunikasi $wilayahTelekomunikasi)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('Super Admin') ;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\WilayahTelekomunikasi  $wilayahTelekomunikasi
     * @return mixed
     */
    public function update(User $user, WilayahTelekomunikasi $wilayahTelekomunikasi)
    {
        return $user->hasRole('Super Admin') ;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\WilayahTelekomunikasi  $wilayahTelekomunikasi
     * @return mixed
     */
    public function delete(User $user, WilayahTelekomunikasi $wilayahTelekomunikasi)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\WilayahTelekomunikasi  $wilayahTelekomunikasi
     * @return mixed
     */
    public function restore(User $user, WilayahTelekomunikasi $wilayahTelekomunikasi)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\WilayahTelekomunikasi  $wilayahTelekomunikasi
     * @return mixed
     */
    public function forceDelete(User $user, WilayahTelekomunikasi $wilayahTelekomunikasi)
    {
        //
    }
}
