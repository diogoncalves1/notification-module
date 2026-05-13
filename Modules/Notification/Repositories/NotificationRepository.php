<?php
namespace Modules\Notification\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Events\NotificationCreated;

class NotificationRepository implements RepositoryInterface
{
    public function all()
    {
        return Notification::all();
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $request->user();

            $input            = $request->only(['type_code', 'data']);
            $input['user_id'] = $user->id;

            $preferences = $user->notificationPreferences()->code($input['type_code'])->first();

            $notification = Notification::create($input);

            if ($preferences['email']) {
                event(new NotificationCreated($notification));
            }
        });
    }

    public function update(Request $request, string $id)
    {
        throw new \Exception('Not implemented');
    }

    public function show(string $id)
    {
        throw new \Exception('Not implemented');
    }

    public function destroy(string $id)
    {
        throw new \Exception('Not implemented');
    }
}
