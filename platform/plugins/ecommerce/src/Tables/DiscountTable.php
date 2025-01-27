<?php

namespace Botble\Ecommerce\Tables;

use BaseHelper;
use Botble\Ecommerce\Models\Discount;
use Botble\Ecommerce\Repositories\Interfaces\DiscountInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class DiscountTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = false;

    /**
     * DiscountTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param DiscountInterface $discountRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, DiscountInterface $discountRepository)
    {
        $this->repository = $discountRepository;
        $this->setOption('id', 'table-discounts');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasPermission('discounts.destroy')) {
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
            ->editColumn('detail', function ($item) {
                return view('plugins/ecommerce::discounts.detail', compact('item'))->render();
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('total_used', function ($item) {
                if ($item->type === 'promotion') {
                    return '-';
                }
                if ($item->quantity === null) {
                    return $item->total_used;
                }
                return $item->total_used . '/' . $item->quantity;
            })
            ->editColumn('start_date', function ($item) {
                return BaseHelper::formatDate($item->start_date);
            })
            ->editColumn('end_date', function ($item) {
                if (!$item->end_date) {
                    return '-';
                }
                return $item->end_date;
            })
            ->editColumn('status', function ($item) {
                return view('plugins/ecommerce::discounts.discountStatus', ['item' => $item])->render();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations(null, 'discounts.destroy', $item);
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
            'ec_discounts.*',
        ];

        $query = $model->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
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
    public function columns()
    {
        return [
            'id'         => [
                'name'  => 'ec_discounts.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
                'class' => 'text-left',
            ],
            'detail'     => [
                'name'  => 'ec_discounts.title',
                'title' => trans('plugins/ecommerce::discount.detail'),
                'class' => 'text-left',
            ],
            'total_used' => [
                'name'  => 'ec_discounts.total_used',
                'title' => trans('plugins/ecommerce::discount.used'),
                'width' => '100px',
            ],
            'start_date' => [
                'name'  => 'ec_discounts.start_date',
                'title' => trans('plugins/ecommerce::discount.start_date'),
                'class' => 'text-center',
            ],
            'end_date'   => [
                'name'  => 'ec_discounts.end_date',
                'title' => trans('plugins/ecommerce::discount.end_date'),
                'class' => 'text-center',
            ],
            'status'    => [
                'name'  => 'ec_discounts.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
                'class' => 'text-center',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('discounts.create'), 'discounts.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Discount::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('discounts.deletes'), 'discounts.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function renderTable($data = [], $mergeData = [])
    {
        if ($this->query()->count() === 0 &&
            !$this->request()->wantsJson() &&
            $this->request()->input('filter_table_id') !== $this->getOption('id')
        ) {
            return view('plugins/ecommerce::discounts.intro');
        }

        return parent::renderTable($data, $mergeData);
    }
}
