<?php

namespace App\Providers;

use App\Events\Auth\Registered;
use App\Events\DieselFuelConsumptionCreated;
use App\Listeners\Auth\SendEmailVerificationNotification;
use App\Listeners\DieselFuelConsumption\UpdateTotalRemainFuel;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        DieselFuelConsumptionCreated::class => [
            UpdateTotalRemainFuel::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
