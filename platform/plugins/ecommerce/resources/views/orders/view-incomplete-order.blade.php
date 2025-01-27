@extends('core/base::layouts.master')
@section('content')
    <div class="max-width-1036">
        <div class="ui-layout__item mb20">
            <div class="ui-banner ui-banner--status-info">
                <div class="ui-banner__ribbon">
                    <svg class="svg-next-icon svg-next-icon-size-20">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-cart"></use>
                    </svg>
                </div>
                <div class="ui-banner__content ws-nm">
                    <h2 class="ui-banner__title">
                        {{ trans('plugins/ecommerce::order.incomplete_order_description_1') }}
                    </h2>
                    <h2 class="ui-banner__title">
                        {{ trans('plugins/ecommerce::order.incomplete_order_description_2') }}
                    </h2>
                    <div class="ws-nm">
                        <input type="text" class="next-input" onclick="this.focus(); this.select();" value="{{ route('public.checkout.recover', $order->token) }}">
                        <br>
                        <button class="btn btn-secondary btn-trigger-send-order-recover-modal" data-action="{{ route('orders.send-order-recover-email', $order->id) }}">{{ trans('plugins/ecommerce::order.send_an_email_to_recover_this_order') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flexbox-grid">
            <div class="flexbox-content">
                <div class="wrapper-content mb20">
                    <div class="pd-all-20">
                        <label class="title-product-main text-no-bold">{{ trans('plugins/ecommerce::order.order_information') }}</label>
                    </div>
                    <div class="pd-all-10-20 border-top-title-main">
                        <div class="clearfix">
                            <div class="table-wrapper p-none mb20 ps-relative">
                                <table class="table-normal">
                                    <tbody>
                                        @foreach ($order->products as $orderProduct)
                                            @php
                                                $product = get_products([
                                                    'condition' => [
                                                        //'ec_products.status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
                                                        'ec_products.id' => $orderProduct->product_id,
                                                    ],
                                                    'take' => 1,
                                                    'select' => [
                                                        'ec_products.id',
                                                        'ec_products.images',
                                                        'ec_products.name',
                                                        'ec_products.price',
                                                        'ec_products.sale_price',
                                                        'ec_products.sale_type',
                                                        'ec_products.start_date',
                                                        'ec_products.end_date',
                                                        'ec_products.sku',
                                                        'ec_products.is_variation',
                                                    ],
                                                ]);
                                            @endphp
                                            @if ($product)
                                                <tr>
                                                    <td class="width-60-px min-width-60-px">
                                                        <div class="wrap-img">
                                                            <img class="thumb-image thumb-image-cartorderlist" src="{{ image_fallback($product->original_product->image) }}" alt="{{ $product->name }}">
                                                        </div>
                                                    </td>
                                                    <td class="pl5 p-r5">
                                                        <a target="_blank" href="{{ route('products.edit', $product->original_product->id) }}" title="{{ $orderProduct->product_name }}">{{ $orderProduct->product_name }}</a>
                                                        <p>
                                                            @php $attributes = get_product_attributes($product->id) @endphp
                                                            @if (!empty($attributes))
                                                                @foreach ($attributes as $attr)
                                                                    @if (!$loop->last)
                                                                        {{ $attr->attribute_set_title }}: {{ $attr->title }} <br>
                                                                    @else
                                                                        {{ $attr->attribute_set_title }}: {{ $attr->title }}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                        @if ($product->sku)
                                                            <p>{{ trans('plugins/ecommerce::order.sku') }} : <span>{{ $product->sku }}</span></p>
                                                        @endif
                                                    </td>
                                                    <td class="pl5 p-r5 width-100-px min-width-100-px text-right">
                                                        <span>{{ format_price($orderProduct->price) }}</span>
                                                    </td>
                                                    <td class="pl5 p-r5 width-20-px min-width-20-px text-center"> x</td>
                                                    <td class="pl5 p-r5 width-30-px min-width-30-px text-left">
                                                        <span class="item-quantity text-right">{{ $orderProduct->qty }}</span>
                                                    </td>
                                                    <td class="pl5 p-r5 width-100-px min-width-130-px text-right">{{ format_price($orderProduct->price * $orderProduct->qty) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="flexbox-grid-default">
                            <div class="flexbox-auto-content"></div>
                            <div class="flexbox-auto-content">
                                <div class="table-wrapper">
                                    <table class="table-normal table-none-border">
                                        <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right p-sm-r">
                                                Sub amount:
                                            </td>
                                            <td class="text-right p-r5">{{ format_price($order->sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right p-sm-r">
                                                Discount:
                                            </td>
                                            <td class="text-right p-r5">{{ format_price($order->discount_amount) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right p-sm-r">
                                                Shipping fee:
                                            </td>
                                            <td class="text-right p-r5">{{ format_price($order->shipping_amount) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right p-sm-r">
                                                Total amount:
                                            </td>
                                            <td class="text-right p-r5">{{ format_price($order->amount) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper-content mb20">
                    <div class="pd-all-20 p-none-b">
                        <label class="title-product-main text-no-bold">{{ trans('plugins/ecommerce::order.additional_information') }}</label>
                    </div>
                    <div class="pd-all-10-20">
                        <form action="{{ route('orders.edit', $order->id) }}">
                            <label class="text-title-field">{{ trans('plugins/ecommerce::order.order_note') }}</label>
                            <textarea class="ui-text-area textarea-auto-height" name="description" placeholder="{{ trans('plugins/ecommerce::order.order_note_placeholder') }}" rows="2">{{ $order->description }}</textarea>
                            <div class="mt15 mb15 text-right">
                                <button type="button" class="btn btn-primary btn-update-order">{{ trans('plugins/ecommerce::order.save_note') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="flexbox-content flexbox-right">
                <div class="wrapper-content mb20">
                    <div class="next-card-section p-none-b">
                        <div class="flexbox-grid-default">
                            <div class="flexbox-auto-content">
                                <label class="title-product-main"><strong>{{ trans('plugins/ecommerce::order.customer_label') }}</strong></label>
                            </div>
                            <div class="flexbox-auto-left">
                                <img class="width-30-px radius-cycle" width="40" src="{{ $order->user->id ? $order->user->avatar_url : $order->address->avatar_url }}" alt="{{ $order->address->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="next-card-section border-none-t">
                        <ul class="ws-nm">
                            <li class="overflow-ellipsis">
                                <div class="mb5">
                                    <a class="hover-underline text-capitalize" href="#">{{ $order->user->name ? $order->user->name : $order->address->name }}</a>
                                </div>
                                @if ($order->user->id)
                                    <div><i class="fas fa-inbox mr5"></i><span>{{ $order->user->orders()->count() }}</span> {{ trans('plugins/ecommerce::order.orders') }}</div>
                                @endif
                                <ul class="ws-nm text-infor-subdued">
                                    <li class="overflow-ellipsis"><a class="hover-underline" href="mailto:{{ $order->user->email ? $order->user->email : $order->address->email }}">{{ $order->user->email ? $order->user->email : $order->address->email }}</a></li>
                                    @if ($order->user->id)
                                        <li><div>{{ trans('plugins/ecommerce::order.have_an_account_already') }}</div></li>
                                    @else
                                        <li><div>{{ trans('plugins/ecommerce::order.dont_have_an_account_yet') }}</div></li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="next-card-section">
                        <ul class="ws-nm">
                            <li class="clearfix">
                                <div class="flexbox-grid-default">
                                    <div class="flexbox-auto-content">
                                        <label class="title-text-second"><strong>{{ trans('plugins/ecommerce::order.shipping_address') }}</strong></label>
                                    </div>
                                </div>
                            </li>
                            <li class="text-infor-subdued mt15">
                                <div>{{ @$order->user->shippingAddress[0]->name }}</div>
                                <div>
                                    <a href="tel:{{ @$order->user->shippingAddress[0]->phone }}">
                                        <span><i class="fa fa-phone-square cursor-pointer mr5"></i></span>
                                        <span>{{ @$order->user->shippingAddress[0]->phone }}</span>
                                    </a>
                                </div>
                                <div>
                                    <div>{{ @$order->user->shippingAddress[0]->address }}</div>
                                    <div>{{ @$order->user->shippingAddress[0]->city }}</div>
                                    <div>{{ @$order->user->shippingAddress[0]->state }}</div>
                                    <div>{{ @$order->user->shippingAddress[0]->country_name }}</div>
                                    <div>
                                        <a target="_blank" class="hover-underline" href="https://maps.google.com/?q={{ @$order->user->shippingAddress[0]->address }}, {{ @$order->user->shippingAddress[0]->city }}, {{ @$order->user->shippingAddress[0]->state }}, {{ @$order->user->shippingAddress[0]->country_name }}">{{ trans('plugins/ecommerce::order.see_maps') }}</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="ws-nm">
                            <li class="clearfix">
                                <div class="flexbox-grid-default">
                                    <div class="flexbox-auto-content">
                                        <label class="title-text-second"><strong>Billing address</strong></label>
                                    </div>
                                </div>
                            </li>
                            <li class="text-infor-subdued mt15">
                                <div>{{ @$order->user->billingAddress[0]->name }}</div>
                                <div>
                                    <a href="tel:{{ @$order->billingAddress[0]->phone }}">
                                        <span><i class="fa fa-phone-square cursor-pointer mr5"></i></span>
                                        <span>{{ @$order->user->billingAddress[0]->phone }}</span>
                                    </a>
                                </div>
                                <div>
                                    <div>{{ @$order->user->billingAddress[0]->address }}</div>
                                    <div>{{ @$order->user->billingAddress[0]->city }}</div>
                                    <div>{{ @$order->user->billingAddress[0]->state }}</div>
                                    <div>{{ @$order->user->billingAddress[0]->country_name }}</div>
                                    <div>
                                        <a target="_blank" class="hover-underline" href="https://maps.google.com/?q={{ @$order->user->billingAddress[0]->address }}, {{ @$order->user->billingAddress[0]->city }}, {{ @$order->user->billingAddress[0]->state }}, {{ @$order->user->billingAddress[0]->country_name }}">{{ trans('plugins/ecommerce::order.see_maps') }}</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        @if(Auth::user()->hasPermission('orders.editOrder'))
                            @if (!in_array($order->status, [\Botble\Ecommerce\Enums\OrderStatusEnum::CANCELED, \Botble\Ecommerce\Enums\OrderStatusEnum::COMPLETED]))
                                <a href="{{ route('orders.editOrder', $order->id) }}" class="btn btn-info"><i class="fa fa-edit"></i> Edit Order</a>&nbsp;
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::modalAction('send-order-recover-email-modal', trans('plugins/ecommerce::order.notice_about_incomplete_order'), 'info', trans('plugins/ecommerce::order.notice_about_incomplete_order_description', ['email' => $order->user->id ? $order->user->email : $order->address->email]), 'confirm-send-recover-email-button', trans('plugins/ecommerce::order.send')) !!}
@stop
