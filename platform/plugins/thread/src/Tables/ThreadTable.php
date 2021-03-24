<?php

namespace Botble\Thread\Tables;

use Auth;
use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Thread\Repositories\Interfaces\ThreadInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Botble\Thread\Models\Thread;
use Html;


class ThreadTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * ThreadTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param ThreadInterface $threadRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ThreadInterface $threadRepository)
    {
        $this->repository = $threadRepository;
        $this->setOption('id', 'plugins-thread-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['thread.edit', 'thread.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            /*->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('thread.edit')) {
                    return $item->name;
                }
                return Html::link(route('thread.edit', $item->id), $item->name);
            })*/
            ->editColumn('designer_id', function ($item) {
                return $item->designer ? $item->designer->getFullName() : null;
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('order', function ($item) {
              $html = '<a href="javascript:void(0)" onclick="confirm_start()" class="btn btn-icon btn-sm btn-info" data-toggle="tooltip" data-original-title="Order">Order</a><script>function confirm_start(){
                      swal({
                          title: \'Are you sure?\',
                          text: "Do you want to push this thread to Ecommerce!",
                          icon: \'info\',
                          buttons:{
                              cancel: {
                                text: "Cancel",
                                value: null,
                                visible: true,
                                className: "",
                                closeModal: true,
                              },
                              confirm: {
                                text: "Push",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: true
                              }
                            }
                          }).then((result) => {
                              if (result) {
                                  location.replace("'.route('thread.orderItem', $item->id).'")
                              }
                          });
                  }</script>';
              return $html;
            })
            ->editColumn('status', function ($item) {
                //return $item->status->toHtml();
                return view('plugins/thread::threadStatus', ['item' => $item])->render();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                $html = '<a href="'.route('thread.cloneItem', $item->id).'" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-original-title="Clone"><i class="fa fa-copy"></i></a>';
                if ($item->vendor_id > 0 && $item->status == BaseStatusEnum::PUBLISHED) {
                    $html .= '<a href="'.route('threadorders.createThreadOrder', $item->id).'" class="btn btn-icon btn-sm btn-info" data-toggle="tooltip" data-original-title="Order"><i class="fa fa-shopping-cart"></i></a>';
                }
                $html .= '<a href="'.route('thread.details', $item->id).'" class="btn btn-icon btn-sm btn-success" data-toggle="tooltip" data-original-title="Details"><i class="fa fa-eye"></i></a>';
                return $this->getOperations('thread.edit', 'thread.destroy', $item, $html);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'threads.id',
            'threads.name',
            'threads.designer_id',
            'threads.vendor_id',
            'threads.created_at',
            'threads.status',
        ];

        $query = $model
            ->with([
                'designer' => function ($query) {
                    $query->select(['id', 'first_name', 'last_name']);
                },
            ])
            ->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'threads.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'threads.name',
                'title' => 'Description',
                'class' => 'text-left',
            ],
            'designer_id'  => [
                'name'      => 'threads.designer_id',
                'title'     => 'Designer',
                'class'     => 'no-sort text-left',
                'orderable' => false,
            ],
            'order' => [
                'name'  => 'threads.order',
                'title' => 'Order',
                'width' => '100px',
            ],
            'created_at' => [
                'name'  => 'threads.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'threads.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('thread.create'), 'thread.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Thread::class);
    }

    /**
     * {@inheritDoc}
     */
    public function htmlDrawCallbackFunction(): ?string
    {
        return parent::htmlDrawCallbackFunction() . '$(".editable").editable();';
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('thread.deletes'), 'thread.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'threads.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'threads.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'threads.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->getBulkChanges();
    }
}
