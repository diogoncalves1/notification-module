<?php
namespace Modules\Notification\Actions\Notifications;

use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\NotificationRepository;

class ArchiveNotificationAction
{
    public function __construct(protected NotificationRepository $repository)
    {
    }

    public function execute(string $id): Notification
    {
        $notification = $this->repository->show($id);

        if ($notification->archived_at) {
            return $notification;
        }

        $notification->update([
            'archived_at' => now(),
        ]);

        return $notification;
    }
}
