<?php

namespace App\Listeners;

use App\Events\XMLUploadedEvent;
use App\Notifications\XMLUploadedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class XMLUploadedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(XMLUploadedEvent $event): void
    {
        $email = auth('sanctum')->user()->email;
        Notification::route('mail', $email)
            ->notify(new XMLUploadedNotification($event));
    }
}
