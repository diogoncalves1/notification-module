<?php
namespace Modules\Notification\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Notification\Entities\Notification;

class NotificationCacheService
{
    public function get(int $userId)
    {
        return Cache::remember(
            "notifications:feed:{$userId}",
            now()->addMinutes(5),
            function () use ($userId) {
                return Notification::where('user_id', $userId)
                    ->latest()
                    ->take(20)
                    ->get();
            }
        );
    }

    public function incrementUnread(int $userId): void
    {
        Cache::increment("notifications:unread:${userId}");
    }

    public function decrementUnread(int $userId): void
    {
        $key = "notifications:unread:{$userId}";

        if ((int) Cache::get($key) > 0) {
            Cache::decrement($key);
        }
    }

    public function resetUnread(int $userId): void
    {
        Cache::put("notifications:unread:${userId}", 0);
    }

    public function push(Notification $notification)
    {
        $key = "notifications:feed:{$notification->user_id}";

        $feed = Cache::get($key, []);

        array_unshift($feed, $notification);

        $feed = array_slice($feed, 0, 20);

        Cache::put($key, $feed, now()->addHour());
    }
}
