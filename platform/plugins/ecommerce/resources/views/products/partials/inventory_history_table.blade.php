@extends('core/base::layouts.master')

@section('content')
    <p>
        Product: <strong><a href="{{ route('products.edit', ['product' => $data->id]) }}">{{ $data->name }}</a></strong>
    </p>

    <ul class="nav nav-tabs" id="prodSkuTab" role="tablist">
        @foreach($prodVariations as $variation)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{$loop->first ? 'active' : ''}}" id="{{$variation->sku}}-tab" data-toggle="tab" href="#{{$variation->sku}}"><strong>{{ $variation->sku }}</strong></button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="prodSkuTabContent">
        @foreach($prodVariations as $variation)
            @php $histories = $data->inventory_history()->where('product_id', $variation->id)->orderBy('id', 'DESC')->get(); @endphp
            <div class="tab-pane fade show {{$loop->first ? 'active' : ''}}" id="{{$variation->sku}}" role="tabpanel" aria-labelledby="{{$variation->sku}}-tab">
                @php
                    $soldQty = \Botble\Ecommerce\Models\Order::join('ec_order_product', 'ec_orders.id', 'ec_order_product.order_id')
                    ->where('ec_orders.order_type',\Botble\Ecommerce\Models\Order::NORMAL)
                    ->where('ec_orders.status' ,'!=',\Botble\Base\Enums\BaseStatusEnum::CANCELLED)
                    ->where('ec_order_product.product_id', $variation->id)
                    ->sum('ec_order_product.qty');
                @endphp
                <span>In Stock : {{$variation->quantity}} qty</span><br>
                <span>Sold : {{$soldQty}} qty</span>
                <table width="100%" class="table table-middle">
                    <thead>
                    <tr>
                        <th width="10%" class="center">Qty</th>
                        <th width="10%" class="center">New stock</th>
                        <th width="10%" class="center">Old stock</th>
                        {{--<th><span>Options</span></th>--}}
                        <th>User</th>
                        <th>Detailed information</th>
                        <th>Reference</th>
                        <th width="10%">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($histories as $history)
                        <tr class="cm-row-status-a">
                            @php
                                $sign = ($history->reference == \App\Models\InventoryHistory::PROD_ORDER_QTY_DEDUCT) ? '-' : '+';
                            @endphp
                            <td class="center">
                            <strong>{{ ($history->quantity > 0) ? $sign.$history->quantity : 0 }}</strong></td>
                            <td class="center">{{ $history->new_stock ? $history->new_stock : 0 }}</td>
                            <td class="center">{{ $history->old_stock ? $history->old_stock : 0 }}</td>
                            {{--<td class="nowrap"><p class="muted"><small></small></p></td>--}}
                            <td class="nowrap">{{ @$history->user->first_name. ' ' . @$history->user->last_name }}</td>
                            <td class="nowrap">
                                @if(!empty($history->thread_order_id))
                                    <a href="{{ route('threadorders.threadOrderDetail', ['id' => @$history->thread_order->id]) }}"
                                       target="_blank">Thread Order #{{ @$history->thread_order->order_no }}</a>
                                    <p class="muted">
                                        <small>Status: ThreadOrder &gt; {{ $history->thread_order->status }}</small>
                                    </p>
                                @elseif(@$history->order_id)
                                    <a href="{{ route('orders.edit', @$history->order_id) }}" target="_blank">
                                        Order #{{ @$history->order_id }}
                                    </a>
                                    <p class="muted">
                                        <small>Status: Order &gt; {{ @$history->order->status }}</small>
                                    </p>
                                @elseif(!empty($history->inventory_id))
                                    <a href="{{ route('inventory.edit', ['inventory' => @$history->inventory->id]) }}"
                                       target="_blank">Inventory ID: {{ @$history->inventory->id }}</a>
                                    <p class="muted">
                                        <small>Status: Inventory &gt; {{ @$history->inventory->status }}</small>
                                    </p>
                                @endif
                            </td>
                            <td class="nowrap"><p class="muted">{{ $history->reference }}</p></td>
                            <td class="nowrap">{{ date('d/m/Y, h:m A', strtotime($history->created_at)) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@endsection
