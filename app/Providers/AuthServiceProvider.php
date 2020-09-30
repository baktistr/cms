<?php

namespace App\Providers;

use App\Area;
use App\Building;
use App\District;
use App\Policies\AreaPolicy;
use App\Policies\BuildingPolicy;
use App\Policies\DistrictPolicy;
use App\Policies\ProvincePolicy;
use App\Policies\RegencyPolicy;
use App\Policies\StaticPagePolicy;
use App\Policies\UserPolicy;
use App\Province;
use App\StaticPage;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class          => UserPolicy::class,
        Province::class      => ProvincePolicy::class,
        RegencyPolicy::class => RegencyPolicy::class,
        District::class      => DistrictPolicy::class,
        Building::class      => BuildingPolicy::class,
        StaticPage::class    => StaticPagePolicy::class,
        Area::class          => AreaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
