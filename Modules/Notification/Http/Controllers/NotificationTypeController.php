<?php
namespace Modules\Notification\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Language\Repositories\LanguageRepository;
use Modules\Notification\DataTables\NotificationTypeDataTable;
use Modules\Notification\Http\Requests\NotificationTypeRequest;
use Modules\Notification\Repositories\NotificationKeywordRepository;
use Modules\Notification\Repositories\NotificationTypeRepository;
use Modules\Notification\Services\NotificationTypeService;

class NotificationTypeController extends ApiController
{

    public function __construct(protected NotificationTypeRepository $repository, protected NotificationKeywordRepository $keywordRepository, protected NotificationTypeService $service, protected LanguageRepository $languageRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(NotificationTypeDataTable $dataTable)
    {
        $this->allowedAction('viewNotificationTypes');

        return $dataTable->render('notification::notification-types.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->allowedAction('createNotificationTypes');

        $keywordsList = $this->keywordRepository->all();

        return view('notification::notification-types.create', compact('keywordsList'));
    }

    /**
     * Store a newly created resource in storage.
     * @param NotificationTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NotificationTypeRequest $request)
    {
        $this->allowedAction('createNotificationTypes');

        $this->service->create($request->validated(), $request->user());

        return redirect()->route('admin.notification-types.index');
    }

    /**
     * Show the specified resource.
     */
    // public function show($id)
    // {
    //     return view('notification::show');
    // }

    /**
     * Show the form for editing the specified resource.
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        $this->allowedAction('editNotificationTypes');

        $notifcationType = $this->repository->show($id);
        $languages       = $this->languageRepository->all();

        return view('notification::notification-types.create', compact('notifcationType', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(NotificationTypeRequest $request, string $id)
    {
        $this->allowedAction('editNotificationTypes');

        $this->repository->update($request->validated(), $id);

        return redirect()->route('admin.notification-types.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            $this->allowedAction('destroyNotificationTypes');

            $this->repository->destroy($id);

            return $this->ok(message: 'Tipo de notificação apagado com sucesso');
        } catch (\Exception $e) {
            Log::error($e);
            return $this->fail('Erro ao apagar tipo de notificação', $e);
        }

    }

    /**
     * Check if a code is available.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkCode(Request $request)
    {
        try {
            $exists = $this->repository->checkIfCodeExists($request->get('code'), $request->get('id'));

            return $this->ok(['is_available' => ! $exists]);
        } catch (\Exception $e) {
            return $this->fail('Erro ao verificar código', $e);
        }
    }
}
