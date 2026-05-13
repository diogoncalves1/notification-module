<?php
namespace Modules\Notification\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use Modules\Notification\DataTables\NotificationKeywordDataTable;
use Modules\Notification\Repositories\NotificationKeywordRepository;

class NotificationKeywordController extends AppController
{

    public function __construct(protected NotificationKeywordRepository $repository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(NotificationKeywordDataTable $dataTable)
    {
        $this->allowedAction('superAdmin');

        return $dataTable->render('notification::notification-keywords.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->allowedAction('superAdmin');

        return view('notification::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->allowedAction('superAdmin');

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
     */
    public function edit($id)
    {
        $this->allowedAction('superAdmin');

        return view('notification::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->allowedAction('superAdmin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->allowedAction('superAdmin');
    }
}
