<?php
$cross_related = get_cross_selling_products_modded($product);
?>
@if(count($cross_related))
    <div class="row">
        <div class="col-lg-12 mt-4">
            <h1 class="detail-subheading mt-4">Cross-Selling Products</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="shoplisting detail-listing detail-shoplist">
                @foreach($cross_related as $key => $product)
                    @if($loop->iteration < 5)
                    @php
                        $variationData = \Botble\Ecommerce\Models\ProductVariation::join('ec_products as ep', 'ep.id', 'ec_product_variations.product_id')
                                            ->where('ep.quantity', '>', 0)
                                            ->where('ec_product_variations.configurable_product_id', $product->id)
                                            ->orderBy('ec_product_variations.is_default', 'desc')
                                            ->select('ec_product_variations.id','ec_product_variations.product_id', 'ep.price' )
                                            ->where('ec_product_variations.is_default', 1)
                                            ->get();
                        $default = $variationData->first();

                     $productVariationsInfo = app(\Botble\Ecommerce\Repositories\Interfaces\ProductVariationItemInterface::class)
                                                 ->getVariationsInfo($variationData->pluck('id')->toArray());

                    @endphp
                    {!! Theme::partial('product-card', ['product' => $product , 'col' => '']) !!}
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
