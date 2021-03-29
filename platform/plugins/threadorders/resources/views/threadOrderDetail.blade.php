@extends('core/base::layouts.master')

@section('content')
    <div class="p-3 bg-white" >
        <div class="clearfix"></div>

        <div id="main">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <h5 class="order-detail">ORDER DETAIL </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <p class="m-0 heading">Vendor</p>
                    <p>{{$orderDetail->vendor->getFullName()}}</p>
                </div>
                <div class="col-lg-3">
                    <p class="m-0 heading">Order No.</p>
                    <p>{{$orderDetail->order_no}}</p>
                </div>
                <div class="col-lg-3">
                    <p class="m-0 heading"> Regular Category</p>
                    <p>{{@$orderDetail->threadOrderVariations(\Botble\Thread\Models\Thread::REGULAR)[0]->cat_name}}</p>
                </div>
                @if(isset($orderDetail->threadOrderVariations(\Botble\Thread\Models\Thread::PLUS)[0]->cat_name))
                    <div class="col-lg-3">
                        <p class="m-0 heading"> Plus Category</p>
                        <p>{{@$orderDetail->threadOrderVariations(\Botble\Thread\Models\Thread::PLUS)[0]->cat_name}}</p>
                    </div>
                @endif
                <div class="col-lg-3">
                    <p class="m-0 heading">Description</p>
                    <p>{{$orderDetail->name}}</p>
                </div>
                <div class="col-lg-3">
                    <p class="m-0 heading">PP Sample Date</p>
                    @if($orderDetail->pp_sample == \Botble\Thread\Models\Thread::YES)
                        <p>{{date('d F, Y', strtotime($orderDetail->pp_sample_date))}}</p>
                    @else
                        <p>N/A</p>
                    @endif
                </div>
                <div class="col-lg-3">
                    <p class="m-0 heading"> PP Sample</p>
                    <p>{{$orderDetail->pp_sample}}</p>
                </div>
                @if($orderDetail->material)
                    <div class="col-lg-3">
                        <p class="m-0 heading">Fabric</p>
                        <p>{{$orderDetail->material}}</p>
                    </div>
                @endif
                <div class="col-lg-3">
                    <p class="m-0 heading">Select Shipping Method</p>
                    <p>{{$orderDetail->shipping_method}}</p>
                </div>
            </div>

            <div class="p-3 mb-3 thread-area">
            <div class="row">
                <div class="col-lg-12 ">
                    <h6 class="mb-1 thread-head"> THREAD VARIATIONS </h6>
                </div>
            </div>
            <br>
            @foreach($orderDetail->threadOrderVariations() as $variation)
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <h5 class="variation-text">{{$loop->iteration}}. {{$variation->name}} </h5>
                    </div>
                    <div class="col-lg-3">
                        <p class="m-0 heading">SKU</p>
                        <p>{{$variation->sku}}</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="m-0 heading">Type</p>
                        <p>{{$variation->category_type}}</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="m-0 heading">Qty</p>
                        <p>{{$variation->quantity}}</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="m-0 heading">Cost</p>
                        <p>{{$variation->cost}}</p>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12 text-right">
                    <a href="{{url('/admin/threads/details', $orderDetail->thread_id)}}" target="_blank" class="btn btn-icon btn-sm btn-red pl-4 pr-4">View Tech Pack</a>
                </div>
            </div>
        </div>

    </div>
@stop

<style>
    .heading{
        color: #d64635;
        font-weight: 600;
    }
    .variation-text {
        color: #696969;
    }
    .btn-red {
        background-color: #d64635 !important;
        border-color: #d64635 !important;
        color: #fff !important;
    }
    .thread-area {
        background: #f3f3f3;
        border-radius: 10px;
        -moz-box-shadow: 0 0 5px #999;
        -webkit-box-shadow: 0 0 5px #999;
        box-shadow: 0 0 5px #999;
    }
    .thread-head {
        font-size:16px !important;
    }
    .order-detail {
        font-size:20px !important;
    }
</style>
