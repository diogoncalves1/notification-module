<?php
namespace Modules\Notification\Actions\Notifications;

use Modules\Notification\Repositories\NotificationRepository;

class DeleteNotificationAction
{
    public function __construct(protected NotificationRepository $repository)
    {
    }

    public function execute(string $id): void
    {
        $notification = $this->repository->show($id);

        $notification->delete();
    }
}
