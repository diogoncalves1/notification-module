<?php
namespace Modules\Notification\Actions\Notifications;

use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Entities\User;

class MarkAllAsReadAction
{
    public function __construct(protected NotificationRepository $repository)
    {
    }

    public function execute(User $user): void
    {
        $this->repository->query()
            ->where('user_id', $user->id)
            ->unread()
            ->update([
                'read_at' => now(),
            ]);
    }
}
