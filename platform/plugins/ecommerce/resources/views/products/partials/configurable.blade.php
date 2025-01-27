<link media="all" type="text/css" rel="stylesheet" href="{{asset('vendor/core/core/base/libraries/bootstrap3-editable/css/bootstrap-editable.css')}}">
<script src="{{asset('vendor/core/core/base/libraries/bootstrap3-editable/js/bootstrap-editable.min.js')}}"></script>
<script>
    setTimeout(()=>{
        $(".editable").editable();
    }, 200);
</script>

<div id="product-variations-wrapper">
    <div class="variation-actions">
{{--        <a href="#" class="btn-trigger-select-product-attributes" data-target="{{ route('products.store-related-attributes', $product->id) }}">{{ trans('plugins/ecommerce::products.edit_attribute') }}</a>--}}
        <a href="#" class="btn-trigger-add-new-product-variation" data-target="{{ route('products.add-version', $product->id) }}">{{ trans('plugins/ecommerce::products.add_new_variation') }}</a>
{{--        <a href="#" class="btn-trigger-generate-all-versions" data-target="{{ route('products.generate-all-versions', $product->id) }}">{{ trans('plugins/ecommerce::products.generate_all_variations') }}</a>--}}
    </div>
    @if (!$productVariations->isEmpty())
        <table class="table table-hover-variants">
            <thead>
            <tr>
                <th>{{ trans('plugins/ecommerce::products.form.image') }}</th>
                @foreach ($productAttributeSets/*->where('is_selected', '<>', null)*/->whereIn('id', $productVariationsInfo->pluck('attribute_set_id')->all())->sortBy('id') as $attributeSet)
                    <th>{{ $attributeSet->title }}</th>
                @endforeach
                @foreach ($productAttributeSets->where('is_selected', '<>', null)->whereNotIn('id', $productVariationsInfo->pluck('attribute_set_id')->all())->sortBy('id') as $attributeSet)
                    <th>{{ $attributeSet->title }}</th>
                @endforeach
                <th>{{ trans('plugins/ecommerce::products.form.price') }}</th>
                <th>Cost</th>
                <th>Qty</th>
                <th>SKU</th>
                <th>UPC</th>
                <th>{{ trans('plugins/ecommerce::products.form.is_default') }}</th>
                <th>Status</th>
                <th class="text-center">{{ trans('plugins/ecommerce::products.form.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($productVariations as $variation)
                @php
                    $currentRelatedProduct = $productsRelatedToVariation->where('variation_id', $variation->id)->first();
                @endphp
                <tr>
                    <td>
                        <div class="wrap-img-product">
                           <a href="{{RvMedia::getImageUrl($currentRelatedProduct && $currentRelatedProduct->image ? $currentRelatedProduct->image : $product->image, null, false, RvMedia::getDefaultImage()) }}" target="_blank"> <img
                                src="{{ RvMedia::getImageUrl($currentRelatedProduct && $currentRelatedProduct->image ? $currentRelatedProduct->image : $product->image, null, false, RvMedia::getDefaultImage()) }}"
{{--                                alt="{{ trans('plugins/ecommerce::products.form.image')  }}"--}}
                            ></a>
                        </div>
                    </td>
                    @foreach ($productVariationsInfo->where('variation_id', $variation->id)->sortBy('attribute_set_id') as $key => $item)
                        <td>{{ strtok($item->title,'-') }}</td>
                    @endforeach
                    @for($index = 0; $index < ($productAttributeSets->where('is_selected', '<>', null)->count() - $productVariationsInfo->where('variation_id', $variation->id)->count()); $index++)
                        <td>--</td>
                    @endfor
                    <td>
                        @if ($currentRelatedProduct)
                            {{ format_price($currentRelatedProduct->front_sale_price) }}
                            @if ($currentRelatedProduct->front_sale_price != $currentRelatedProduct->price)
                                <del class="text-danger">{{ format_price($currentRelatedProduct->price) }}</del>
                            @endif
                        @else
                            {{ format_price($product->front_sale_price) }}
                            @if ($product->front_sale_price != $product->price)
                                <del class="text-danger">{{ format_price($product->price) }}</del>
                            @endif
                        @endif
                    </td>
                    <td>{{$variation->product->cost_price}}</td>
                    <td>{{$variation->product->quantity}}</td>
                    <td>{{$variation->product->sku}}</td>
                    <td>{{$variation->product->upc}}</td>
                    <td>
                        <label>
                            <input type="radio" class="hrv-radio"
                                   {{ $variation->is_default ? 'checked' : '' }}
                                   name="variation_default_id"
                                   value="{{ $variation->id }}">
                        </label>
                    </td>
                    <td>
                        {{--@if($variation->product->status == \Botble\Base\Enums\BaseStatusEnum::ACTIVE)
                            <a href="{{ route('products.updateVariationStatus', ['id' => $variation->product->id, 'status' => \Botble\Base\Enums\BaseStatusEnum::HIDDEN]) }}"
                               class="btn btn-xs btn-warning">{{ \Botble\Base\Enums\BaseStatusEnum::HIDDEN }}</a>
                            <a href="{{ route('products.updateVariationStatus', ['id' => $variation->product->id, 'status' => \Botble\Base\Enums\BaseStatusEnum::DISABLED]) }}"
                               class="btn btn-xs btn-danger">{{ \Botble\Base\Enums\BaseStatusEnum::DISABLED }}</a>

                        @elseif($variation->product->status == \Botble\Base\Enums\BaseStatusEnum::HIDDEN)
                            <a href="{{ route('products.updateVariationStatus', ['id' => $variation->product->id, 'status' => \Botble\Base\Enums\BaseStatusEnum::ACTIVE]) }}"
                               class="btn btn-xs btn-success">{{ \Botble\Base\Enums\BaseStatusEnum::ACTIVE }}</a>
                            <a href="{{ route('products.updateVariationStatus', ['id' => $variation->product->id, 'status' => \Botble\Base\Enums\BaseStatusEnum::DISABLED]) }}"
                               class="btn btn-xs btn-danger">{{ \Botble\Base\Enums\BaseStatusEnum::DISABLED }}</a>

                        @elseif($variation->product->status == \Botble\Base\Enums\BaseStatusEnum::DISABLED)
                            <a href="{{ route('products.updateVariationStatus', ['id' => $variation->product->id, 'status' => \Botble\Base\Enums\BaseStatusEnum::HIDDEN]) }}"
                               class="btn btn-xs btn-warning">{{ \Botble\Base\Enums\BaseStatusEnum::HIDDEN }}</a>
                            <a href="{{ route('products.updateVariationStatus', ['id' => $variation->product->id, 'status' => \Botble\Base\Enums\BaseStatusEnum::ACTIVE]) }}"
                               class="btn btn-xs btn-success">{{ \Botble\Base\Enums\BaseStatusEnum::ACTIVE }}</a>
                        @endif--}}
                        {{--{!! Form::select('status', \Botble\Base\Enums\BaseStatusEnum::$PRODUCT,  $variation->product->status, ['class' => 'form-control', 'placeholder'=>'Select Status']) !!}--}}

                        <a data-type="select"
                           data-source="{{ json_encode(\Botble\Base\Enums\BaseStatusEnum::$PRODUCT) }}"
                           data-pk="{{ $variation->product->id }}"
                           data-url="{{ route('products.changeStatus') }}"
                           data-value="{{ $variation->product->status }}"
                           data-title="Change Status"
                           class="editable"
                           href="#">
                            {{ $variation->product->status }}
                        </a>

                    </td>
                    <td style="width: 180px;" class="text-center">
                        <a href="#" class="btn btn-info btn-trigger-edit-product-version"
                           data-target="{{ route('products.update-version', [$variation->id]) }}"
                           data-load-form="{{ route('products.get-version-form', [$variation->id]) }}"
                        >{{ trans('plugins/ecommerce::products.edit_variation_item') }}</a>
                        <a href="#" data-target="{{ route('products.delete-version', [$variation->id]) }}"
                           class="btn-trigger-delete-version btn btn-danger">{{ trans('plugins/ecommerce::products.delete') }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>{{ trans('plugins/ecommerce::products.variations_box_description') }}</p>
    @endif
    {!! Form::modalAction('select-attribute-sets-modal', trans('plugins/ecommerce::products.select_attribute'), 'info', view('plugins/ecommerce::products.partials.attribute-sets', compact('productAttributeSets'))->render(), 'store-related-attributes-button', trans('plugins/ecommerce::products.save_changes')) !!}
    {!! Form::modalAction('add-new-product-variation-modal', trans('plugins/ecommerce::products.add_new_variation'), 'info', view('plugins/ecommerce::products.partials.product-variation-form', ['productAttributeSets' => $productAttributeSets, 'productAttributes' => $productAttributes, 'product' => null, 'originalProduct' => $product, 'productVariationsInfo' => null])->render(), 'store-product-variation-button', trans('plugins/ecommerce::products.save_changes')) !!}
    {!! Form::modalAction('edit-product-variation-modal', trans('plugins/ecommerce::products.edit_variation'), 'info', view('plugins/ecommerce::products.partials.product-variation-form', ['productAttributeSets' => $productAttributeSets, 'productAttributes' => $productAttributes, 'product' => null, 'originalProduct' => $product, 'productVariationsInfo' => null])->render(), 'update-product-variation-button', trans('plugins/ecommerce::products.save_changes')) !!}
    {!! Form::modalAction('generate-all-versions-modal', trans('plugins/ecommerce::products.generate_all_variations'), 'info', trans('plugins/ecommerce::products.generate_all_variations_confirmation'), 'generate-all-versions-button', trans('plugins/ecommerce::products.continue')) !!}
    {!! Form::modalAction('confirm-delete-version-modal', trans('plugins/ecommerce::products.delete_variation'), 'danger', trans('plugins/ecommerce::products.delete_variation_confirmation'), 'delete-version-button', trans('plugins/ecommerce::products.continue')) !!}
</div>
