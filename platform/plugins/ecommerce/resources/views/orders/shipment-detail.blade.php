<div class="shipment-info-panel hide-print">
    <div class="shipment-info-header">
        <a target="_blank" href="{{ route('ecommerce.shipments.edit', $shipment->id) }}">
            <h4>{{ get_shipment_code($shipment->id) }}</h4>
        </a>
        <span class="label carrier-status carrier-status-{{ $shipment->status }}">{{ $shipment->status->label() }}</span>
    </div>

    {{--<div class="pd-all-20 pt10">
        <div class="flexbox-grid-form flexbox-grid-form-no-outside-padding rps-form-767 pt10">
            <div class="flexbox-grid-form-item ws-nm">
                <span>{{ trans('plugins/ecommerce::shipping.shipping_method') }}: <span><i>{{ $shipment->order->shipping_method_name }}</i></span></span>
            </div>
            <div class="flexbox-grid-form-item rps-no-pd-none-r ws-nm">
                <span>{{ trans('plugins/ecommerce::shipping.weight_unit', ['unit' => ecommerce_weight_unit()]) }}:</span> <span><i>{{ $shipment->weight }} kg</i></span>
            </div>
        </div>
        <div class="flexbox-grid-form flexbox-grid-form-no-outside-padding rps-form-767 pt10">
            <div class="flexbox-grid-form-item ws-nm">
                <span>{{ trans('plugins/ecommerce::shipping.warehouse') }}:</span> <span><i>{{ $shipment->store->name }}</i></span>
            </div>
            <div class="flexbox-grid-form-item ws-nm rps-no-pd-none-r">
                <span>{{ trans('plugins/ecommerce::shipping.cod_amount') }}:</span>
                <span><i>{{ format_price($shipment->cod_amount) }}</i></span>
            </div>
        </div>
    </div>--}}
    @if ($shipment->status != \Botble\Ecommerce\Enums\ShippingStatusEnum::CANCELED)
        <div class="panel-heading order-bottom shipment-actions-wrapper">
            <div class="flexbox-grid-default">
                @if (in_array($shipment->status, [\Botble\Ecommerce\Enums\ShippingStatusEnum::NOT_APPROVED, \Botble\Ecommerce\Enums\ShippingStatusEnum::APPROVED]))
                    <div class="flexbox-content">
                        <button type="button" class="btn btn-secondary btn-destroy btn-cancel-shipment" data-action="{{ route('orders.cancel-shipment', $shipment->id) }}">{{ trans('plugins/ecommerce::shipping.cancel_shipping') }}</button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
