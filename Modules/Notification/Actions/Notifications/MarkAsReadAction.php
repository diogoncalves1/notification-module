<?php
namespace Modules\Notification\Actions\Notifications;

use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\NotificationRepository;

class MarkAsReadAction
{
    public function __construct(protected NotificationRepository $repository)
    {
    }

    public function execute(string $id): Notification
    {
        $notification = $this->repository->show($id);

        if ($notification->read_at) {
            return $notification;
        }

        $notification->update([
            'read_at' => now(),
        ]);

        return $notification;
    }
}
