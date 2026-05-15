<?php
namespace Modules\Notification\Listeners;

use Illuminate\Support\Facades\Notification;
use Modules\Notification\Events\NotificationCreated;
use Modules\Notification\Notifications\NotificationCreatedNotification;

class NotificationCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotificationCreated $event)
    {
        $notification = $event->notification;

        $preferences = $notification->user
            ->notificationPreferences()
            ->where('type_code', $notification->type_code)
            ->first();

        if (! $preferences?->email) {
            return;
        }

        Notification::send($notification, new NotificationCreatedNotification($notification));
    }
}
