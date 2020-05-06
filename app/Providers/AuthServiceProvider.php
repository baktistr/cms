<?php

namespace App\Providers;

use App\AssetCategory;
use App\District;
use App\Policies\AssetCategoryPolicy;
use App\Policies\DistrictPolicy;
use App\Policies\ProvincePolicy;
use App\Policies\RegencyPolicy;
use App\Province;
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
        Province::class      => ProvincePolicy::class,
        RegencyPolicy::class => RegencyPolicy::class,
        District::class      => DistrictPolicy::class,
        AssetCategory::class => AssetCategoryPolicy::class,
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
