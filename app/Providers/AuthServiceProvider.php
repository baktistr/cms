<?php

namespace App\Providers;

use App\Asset;
use App\AssetCategory;
use App\District;
use App\Policies\AssetCategoryPolicy;
use App\Policies\AssetPolicy;
use App\Policies\DistrictPolicy;
use App\Policies\ProvincePolicy;
use App\Policies\RegencyPolicy;
use App\Policies\UserPolicy;
use App\Province;
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
        AssetCategory::class => AssetCategoryPolicy::class,
        Asset::class         => AssetPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
