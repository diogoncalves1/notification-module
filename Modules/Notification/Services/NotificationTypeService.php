<?php
namespace Modules\Notification\Services;

use Illuminate\Support\Facades\DB;
use Modules\Notification\Actions\NotificationType\ProcessMailFieldsAction;
use Modules\Notification\Entities\NotificationType;
use Modules\Notification\Repositories\NotificationTypeRepository;
use Modules\User\Entities\User;

class NotificationTypeService
{
    public function __construct(
        public NotificationTypeRepository $repo,
        public ProcessMailFieldsAction $processMailFields
    ) {}

    public function create(array $data, User $user): NotificationType
    {
        return DB::transaction(function () use ($data, $user) {
            $typeData = array_merge(
                $data,
                $this->processMailFields->execute($data)
            );

            $typeData['created_by_id'] = $user->id;

            return $this->repo->store($typeData);
        });
    }

    public function update(array $data, string $id): NotificationType
    {
        return DB::transaction(function () use ($data, $id) {
            $type = $this->repo->update($data, $id);

            return $type;
        });
    }

    public function destroy($id): NotificationType
    {
        return DB::transaction(function () use ($id) {
            $type = $this->repo->destroy($id);

            return $type;
        });
    }
}
