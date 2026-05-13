<?php
namespace Modules\Notification\DataTables;

use Illuminate\Support\Facades\Auth;
use Modules\Notification\Entities\NotificationType;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NotificationTypeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $user       = Auth::user();
        $canEdit    = $user->can('authorization', 'editNotificationTypes');
        $canDestroy = $user->can('authorization', 'destroyNotificationTypes');
        $canManage  = $user->can('authorization', 'manageNotificationKeywords');

        return datatables()
            ->eloquent($query)
            ->addColumn('title', function (NotificationType $notificationType) {
                return $notificationType->title['pt'] ?? '';
            })
            ->addColumn('message', function (NotificationType $notificationType) {
                return $notificationType->message['pt'] ?? '';
            })
            ->addColumn('action', function (NotificationType $notificationType) use ($canEdit, $canDestroy, $canManage) {
                $btn = ' <div class="btn-group">';
                if ($canManage) {
                    $btn .= '<a title=\'Gerir Keywords\'
                data-toggle="tooltip" data-placement="top"
                class="btn btn-default mr-1"
                href="' . route("admin.notificationTypes.manage.form", $notificationType->id) . '">
                    <span class="m-l-5"><i class="fa fa-cogs"></i></span></a>';
                }
                if ($canEdit) {
                    $btn .= '<a title=\'Editar\'
                data-toggle="tooltip" data-placement="top"
                class="btn btn-default mr-1"
                href="' . route("admin.notificationTypes.edit", $notificationType->id) . '">
                    <span class="m-l-5"><i class="fa fa-pencil-alt"></i></span></a>';
                }
                if ($canDestroy) {
                    $btn .= '<a title=\'Remover\'
                data-toggle="tooltip" data-placement="top"
                class="btn btn-times btn-default mr-1"
                onclick="modalDelete(`' . route('admin.notificationTypes.destroy', $notificationType->id) . '`)">
                    <span class="m-l-5"><i class="fa fa-trash"></i></span></a>';
                }

                $btn .= '</div>';

                return $btn;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param County $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(NotificationType $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('data-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->postAjax()
            ->language('/vendor/datatables-portuguese.json')
            ->orderBy(1, 'asc')
            ->dom('Bfrtip')
            ->drawCallback(" function () {
                    $('[data-toggle=\"tooltip\"]').tooltip();
                }
                 ");
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('code')->title('Código'),
            Column::make('title')->title('Título'),
            Column::make('message')->title('Mensagem'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(55)
                ->title('Ações'),
        ];
    }
}
