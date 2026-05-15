<?php
namespace Modules\Notification\Listeners;

use Modules\Notification\Events\NotificationCreated;
use Modules\Notification\Services\NotificationCacheService;

class UpdateNotificationCacheListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected NotificationCacheService $cache)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotificationCreated $event): void
    {
        $notification = $event->notification;
        $notification->notificationType;

        $this->cache->incrementUnread($notification->user_id);

        $this->cache->push($notification);
    }
}
