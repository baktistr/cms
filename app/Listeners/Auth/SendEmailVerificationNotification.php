<?php

namespace App\Listeners\Auth;

use App\Events\Auth\Registered;
use App\Notifications\Auth\EmailVerificationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $event->user->notify(new EmailVerificationNotification($event->user));
    }
}
