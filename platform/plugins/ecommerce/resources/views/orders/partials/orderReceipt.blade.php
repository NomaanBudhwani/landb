<section class="ml-5 mr-5 mt-3" style=" page-break-before: always;">
    <div class="row">
        <div style="width:70%;">
            <img height="50" src="{{ asset('landb/img/Logo.png') }}"/>
        </div>
        <div style="width:30%;">
            <p style="font-size:12px;" class="m-0">
                <b> ORDER # {{ $order->id }} </b>
            </p>
            <p style="font-size:12px;" class="m-0">
                <b>ORDER DATE </b> {{ date('d/m/Y, h:i A', strtotime($order->created_at)) }}
            </p>
            <p style="font-size:12px;" class="m-0">
                <b>PAYMENT</b> {{ ucfirst(str_replace(['-', '_'], ' ', @$order->payment->payment_channel)) }}
            </p>
            <p style="font-size:12px;" class="m-0">
                <b>STATUS</b> {{ ucfirst($order->status) }}
            </p>
        </div>
    </div>
    <div style="display:flex" class="row">
        <div style="width:34%">
            <div style="background: #eaeaea;" class="p-3">
                <h6>
                    <b>STORE</b>
                </h6>
                <hr style="border: 2px solid;">
                <p style="font-size:12px;" class="m-0">
                    12801 N, Stemmons Fwt, Suite 710 Farmers Branch,</br> Texas 78865 United States
                </p>
                <p style="font-size:12px;" class="m-0">
                    97251235552
                </p>
                <p style="font-size:12px;" class="m-0">
                    customerservice@landapparel.com
                </p>
                <p style="font-size:12px;" class="m-0">
                    https://landbapparel.com/
                </p>
            </div>
        </div>
        @if($order->billingAddress)
            <div style="width:33%">
                <div class="p-3">
                    <h6>
                        <b>BILL TO</b>
                    </h6>
                    <hr style="border: 2px solid #DDD;">
                    <p style="font-size:12px;" class="m-0">
                        <strong>{{ $order->user->detail->company}}</strong> </br>
                        {{ $order->billingAddress->name}}
                    </p>
                    <p style="font-size:12px;" class="m-0">
                        {{$order->billingAddress->address}}</br>
                        {{$order->billingAddress->city.' ,'.$order->billingAddress->state.' ,'.$order->billingAddress->country. ' ,'. $order->billingAddress->zip_code }}
                    </p>
                    <p style="font-size:12px;" class="m-0">
                        {{ $order->billingAddress->phone }}
                    </p>
                    <p style="font-size:12px;" class="m-0">
                        {{ $order->billingAddress->email }}
                    </p>
                    <p style="font-size:12px;" class="m-0">
                        https://landbapparel.com/
                    </p>
                </div>
            </div>
        @endif
        @if($order->shippingAddress)
            <div style="width:33%">
                <div class="p-3">
                    <h6>
                        <b>SHIP TO</b>
                    </h6>
                    <hr style="border: 2px solid #DDD;">
                    <p style="font-size:12px;" class="m-0">
                        <strong> {{ $order->user->detail->company}}</strong> </br>
                        {{$order->shippingAddress->name}}
                    </p>
                    <p style="font-size:12px;" class="m-0">
                        {{$order->shippingAddress->address}}</br>
                        {{$order->shippingAddress->city.' ,'.$order->shippingAddress->state.' ,'.$order->shippingAddress->country. ' ,'. $order->shippingAddress->zip_code }}
                    </p>
                    <p style="font-size:12px;" class="m-0">
                        {{ $order->shippingAddress->phone }}
                    </p>
                    <p style="font-size:12px;" class="m-0">
                        {{ $order->shippingAddress->email }}
                    </p>
                    <p style="font-size:12px;" class="m-0">
                        https://landbapparel.com
                    </p>
                </div>
            </div>
        @endif
        {{-- <div class="col-lg-4">
             <div class="p-3">
             <h3>
                 <b>SHIP TO</b>
                  </h3>
                  <hr style="border: 2px solid #DDD;">
             <p style="font-size:12px;" class="m-0">
                 12801 N, Stemmons Fwt, Suite 710 Farmers Branch, Texas 78865 United States
             </p>
             <p style="font-size:12px;" class="m-0">
                 97251235552
             </p>
             <p style="font-size:12px;" class="m-0">
                 customerservice@landapparel.com
             </p>
             <p style="font-size:12px;" class="m-0">
                 https://landbapparel.com/
             </p>
         </div>
         </div>  --}}
    </div>
</section>
<section class="shoplisting_wrap pl-5 pr-5 mbtb-pl-2 mbtb-pr-2">
    <hr style="border: 2px solid; margin: 5px;">
    <table class="table">
        <thead>
        <tr>
            <th style="font-size:12px;" scope="col">Image</th>
            <th style="font-size:12px;" scope="col">Item Description</th>
            <th style="font-size:12px;" scope="col">SEC</th>
            <th style="font-size:12px;" scope="col">Quantity</th>
            <th style="font-size:12px;" scope="col">Price</th>
            <th style="font-size:12px;" scope="col">Item Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->products as $order_product)
            <tr>
                <td>

                    <img style="max-width: 50px;" class="split-img"
                         src="{{ RvMedia::getImageUrl($order_product->product->image, null, false, RvMedia::getDefaultImage()) }}"/>
                </td>
                <td>
                    {{--{!! image_html_generator(@$order_product->product->images[0], @$order_product->product->name, '95', '75' ) !!}--}}
                    <div class="ml-3">
                        <p style="font-size:12px;"
                           class="cart-product-name m-0">{{ $order_product->product->name }}</p>
                        <p style="font-size:12px;" class="cart-product-code m-0">
                            <strong>CODE:</strong> {{ $order_product->product->sku }}</p>
                        @php $sizes = get_category_sizes_by_id($order_product->product->category_id); @endphp
                        @php
                            $variation = \Botble\Ecommerce\Models\ProductVariation::where('product_id', $order_product->product_id)->join('ec_product_variation_items as epvi', 'epvi.variation_id', 'ec_product_variations.id')->join('ec_product_attributes as epa', 'epa.id', 'epvi.attribute_id')->where('epa.attribute_set_id', 2)->select('epa.*')->first();
if($order_product->product){
    $proID= \Botble\Ecommerce\Models\ProductVariation::where('product_id', $order_product->product->id)->value('configurable_product_id');
    $sec = \Botble\Ecommerce\Models\Product::where('id',$proID )->value('warehouse_sec');
}
                        @endphp
                        @if($variation)
                            @if($variation->title == 'Pack')
                                <p style="font-size:12px;" class="cart-product-size m-0">
                                    <strong>Type:</strong> {{ $variation->title }}</p>
                                <p style="font-size:12px;"
                                   class="cart-product-size m-0">
                                    <strong>SIZE:</strong> {{ $order_product->product->sizes }}</p>
                                <p style="font-size:14px; margin:0px;">
                                    <strong>Price Per Piece:
                                        ${{ ($order_product->product->prod_pieces) ? $order_product->price/$order_product->product->prod_pieces: $order_product->price}}
                                </p></strong>
                            @else
                                <p style="font-size:12px;" class="cart-product-size m-0">
                                    Type: Single</p>
                                <p style="font-size:12px;" class="cart-product-size m-0">
                                    Size: {{ substr($variation->title,0,-3) }}</p>
                            @endif
                        @endif
                    </div>
                </td>

                <td style="font-size:12px;">{{ ($order_product->product->warehouse_sec) ? $order_product->product->warehouse_sec : $sec }}</td>
                <td style="font-size:12px;">{{ $order_product->qty }}</td>
                <td style="font-size:12px;">$ {{ $order_product->price  }}</td>

                <td style="font-size:12px;">$ {{ $order_product->qty*$order_product->price  }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="row">
        <div class="col-lg-6 col-6">
            <p style="font-size:12px;" class="mt-2">Subtotal</p>
        </div>
        <div class="col-lg-6 col-6 text-right">
            <p style="font-size:12px;" class="mt-2">$ {{ $order->amount }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-6">
            <p style="font-size:12px;" class="mt-2">Shipping</p>
        </div>
        <div class="col-lg-6 col-6 text-right">
            <p style="font-size:12px;" class="mt-2">$ {{ $order->shipping_amount }}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-6 col-6">
            <h3 style="font-size:16px;">
                <b>Customer Notes</b>
            </h3>
        </div>
        <div class="col-lg-6 col-6 text-right">
            <p style="font-size:12px;">
                {{ $order->notes }}
            </p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-6 col-6">
            <h3 style="font-size:16px;">
                <b>TOTAL</b>
            </h3>
        </div>
        <div class="col-lg-6 col-6 text-right">
            <h3 style="font-size:16px;">
                <b>$ {{ $order->amount }}</b>
            </h3>
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <div class="col-lg-12 col-12">
            <p style="font-size:12px;" class="mt-2"> For return policy please visit landapparel.com/faq.html
            </p>
        </div>
    </div>
    <hr>
</section>
