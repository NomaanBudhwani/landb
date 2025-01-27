<?php $thread = $options['data']['thread']; ?>
<?php $variations = $options['data']['variations']; ?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-toggle="tab" href="#home">Details</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-toggle="tab" href="#ppsample">PP Sample</button>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" href="{{route('thread.edit', $thread->id)}}">Edit</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

        <div class="box box-widget widget-user">

            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="profile-area">
                <div class="row">
                    <div class="col-lg-2 col-4 mt-2 mb-2">
                        <div class="widget-user-image ml-2">
                            <img class="img-circle"
                                 src="http://laravel.landbw.co/api/resize/users/user.png?w=100&amp;h=100"
                                 alt="User Avatar">
                        </div>
                    </div>
                    <div class="col-lg-10 col-8  mt-2 mb-2">
                        <div class="widget-user-header bg-black">
                            <h3 class="widget-user-username widget-title-color-red font-bold profile-name">{{ $thread->designer->first_name.' '.$thread->designer->last_name }}</h3>
                            <h5 class="widget-user-desc text-dark">Designer</h5>
                            @if ($thread->is_denim == 1 )
                                <input style="position: absolute; top: 0px; right: 25px;"
                                       class="btn btn-primary mt-3 mb-1" type="button" id="btnPrintDenim"
                                       value="Print" onclick='printDenimDiv();'>
                            @else
                                <input style="position: absolute; top: 0px;right: 25px;"
                                       class="btn btn-primary mt-3 mb-1" type="button" id="btnPrint" value="Print"
                                       onclick='printDiv();'>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="widget-user-header">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="mr-2">{{trans('core/base::tables.status')}}</label>
                                        </div>
                                        <div class="col-lg-8">
                                            {!!
                                               Form::select('status',\Botble\Thread\Models\Thread::$STATUS, ($thread->status) ? $thread->status:null, [
                                                   'class' => '',
                                                   'id'    => 'thread_status',
                                               ])
                                           !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <div class="widget-user-header">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="mr-2">Ready to Order</label>

                                        </div>
                                        <div class="col-lg-8">
                                            {!!
                                    Form::select('ready',\Botble\Thread\Models\Thread::$READY, ($thread->ready) ? $thread->ready:null, [
                                        'class' => '',
                                        'id'    => 'ready',
                                    ])
                                !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">0</h5>
                            <span class="description-text font-bold font-12">Category Count</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{ get_total_designs($thread->designer_id) }}</h5>
                            <span class="description-text font-bold font-12">Total Design</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">{{ get_approved_designs($thread->designer_id) }}</h5>
                            <span class="description-text font-bold font-12">Approved Design</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            {{--            Normal Print--}}
            <div class="d-none" id="DivIdToPrint">
                <table style="border: 1px solid #333;
                        border-collapse: collapse; border-spacing: 0;    width: 100%;
                        margin-top: 15px;">
                    <tbody>
                    <tr>
                        <td style="border: 1px solid #333;text-align: center;" colspan="1" rowspan="3"
                            class="tablelogo">
                            <img src="http://localhost/landb/public/images/lucky&amp;blessed_logo_sign_Black 1.png"
                                 alt="">
                        </td>
                        <td style="width: 12%; border: 1px solid #333; padding:10px;" colspan="1" rowspan="1">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif; margin: 0px;">
                                Order Date:<br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ parse_date($thread->order_date) }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" rowspan="1" colspan="1">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Description <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ $thread->name }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="1">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Designer: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ $thread->designer->first_name.' '.$thread->designer->last_name }}</span>
                            </p>
                        </td>
                        <td style="width: 8%; border: 1px solid #333; vertical-align: top;" colspan="1" rowspan="2"
                            class="p-0">
                            <div class="regpack">
                                <h6 style="font-size: 12px; margin:0px; background: #333;  font-family: Madeglin, sans-serif; color: #fff; padding: 4px; text-align: center; text-transform: uppercase; font-weight: 400;">{{$thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? 'Sizes' : 'Reg Pack Size Run'}}</h6>
                                @if(isset($options['data']['reg_cat']->category_sizes))
                                    @foreach($options['data']['reg_cat']->category_sizes as $key => $reg_cat)
                                        <div class="sizediv">
                                            {{ $thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? strtok($reg_cat->name,'-') : $reg_cat->full_name }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        @if(!empty($options['data']['plus_cat']))
                            <td style="width: 8%;border: 1px solid #333; vertical-align: top;" colspan="1" rowspan="2"
                                class="p-0">
                                <div class="regpack">
                                    <h6 style="font-size: 12px; margin:0px; background: #333;  font-family: Madeglin, sans-serif; color: #fff; padding: 4px; text-align: center; text-transform: uppercase; font-weight: 400;">
                                        Plus Pack Size</h6>
                                    @if(isset($options['data']['plus_cat']->category_sizes))
                                        @foreach($options['data']['plus_cat']->category_sizes as $key => $plus_cat)
                                            <div class="sizediv">
                                                {{ $thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? strtok($plus_cat->name,'-') : $plus_cat->name }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        @endif
                        <td style="width: 13%;border: 1px solid #333;  padding:0px 10px;" rowspan="1" colspan="2">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                PP Sample Due Date <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ parse_date($thread->pp_sample_date) }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="2">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Request PP Sample: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ @$thread->pp_sample }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                PP Sample Size: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ @$thread->pp_sample_size }} </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 14%;border: 1px solid #333;  padding:0px 10px;">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Style # <br>
                                <span style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">  Reg Pack:  {{ $options['data']['reg_sku'] }} <br>
                                            @if(!empty($options['data']['plus_sku']))
                                        Plus Pack:  {{ $options['data']['plus_sku'] }}
                                    @endif
                     </span>
                            </p>
                        </td>
                        <td colspan="2" style="width: 14%;border: 1px solid #333;  padding:0px 10px;">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Category <br>

                                <span style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">
                     Reg Pack: {{ @$options['data']['reg_cat']->name }}<br>
                     <span style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">
                     @if(!empty($options['data']['plus_cat']))
                             Plus Pack: {{ @$options['data']['plus_cat']->name }}
                         @endif
                     </span>
                     </span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="2">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Season: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">  {{ @$thread->season->name }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="2">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Vendor: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ @$thread->vendor->first_name.' '.@$thread->vendor->last_name }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="1">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Status: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ $thread->thread_status }}</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="3">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Shipping Method: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ $thread->shipping_method }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="3">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Ship Date: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ parse_date($thread->ship_date) }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="4">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                No Later Than <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ parse_date($thread->cancel_date) }}</span>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div style="    margin: 30px 0;
         border: solid 1px #333;
         padding: 15px;
         border-radius: 5px;">
                    <div style=" display: flex;
            margin-right: -15px;
            margin-left: -15px;">
                        <div style=" flex: 0 0 20.333333%;
               max-width: 20.333333%;    position: relative;
               width: 100%;
               padding-right: 15px;
               padding-left: 15px;">
                            <h4 style=" text-align: center;
                  font-size: 16px;
                  text-transform: uppercase;
                  margin: 0; font-family: Madeglin, sans-serif;">Style</h4>
                            @if(!is_null($thread->spec_files))
                                @if(count($thread->spec_files))
                                    <div style=" max-width: 1000px;
                  position: relative;
                  margin: auto; margin-top: 1.5rem !important;">
                                        @foreach($thread->spec_files as $file)
                                            <div>
                                                <img
                                                    src="{{ asset($file->spec_file) }}"
                                                    style="width:100%; height:310px;">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                            <br>
                        </div>
                        <div style="    flex: 0 0 73.76667%;
               max-width: 73.76667%;     position: relative;
               width: 100%;
               padding-right: 15px;
               padding-left: 15px;">
                            <div>
                                <h4 style="    text-align: center;
                     font-size: 16px;
                     text-transform: uppercase;
                     margin: 0; font-family: Madeglin, sans-serif;">Order</h4>
                                <div>
                                    <table style="border: 1px solid #333;
                        border-collapse: collapse;
                        height: 100%;border-spacing: 0;    width: 100%;
                        margin-top: 15px;">
                                        <tbody>
                                        <tr>
                                            <td style="border: 1px solid #333;  padding:0px 10px;">
                                                <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                                    Material:
                                                    <span
                                                        style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ @$thread->material }}</span>
                                                </p>
                                            </td>
                                            <td style="border: 1px solid #333;  padding:0px 10px;" rowspan="2">
                                                <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                                    Label:
                                                    <span
                                                        style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ @$thread->label }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #333;  padding:0px 10px;">
                                                <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                                    Sleeve Length:
                                                    <span
                                                        style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ @$thread->sleeve }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 8px; vertical-align: top; font-size: 14px;"
                                                colspan="12">
                                                <div style="background: #f5f5f5; padding: 10px; border-radius: 5px;">

                                                    <div
                                                        style="display: flex;flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">
                                                        @foreach($variations as $variation)
                                                            @if($variation->status == 'active' && $variation->is_denim == 0)
                                                                <div
                                                                    style=" flex: 0 0 44.333333%; max-width: 44.333333%; position: relative; width: 100%; padding-right: 15px; padding-left: 15px;">
                                                                    <div
                                                                        style=" min-height: 445px; background: #ffffff;  border: 1px solid #d0d0d0;  border-radius: 10px; padding-left: 1rem !important; padding-right: 1rem !important; ">
                                                                        <h5 style=" margin-top: 0.5rem !important; font-family: Madeglin, sans-serif;">
                                                                            {{$loop->iteration}}.
                                                                            Variation: {{ $variation->name }}
                                                                        </h5>
                                                                        <div
                                                                            style=" display: flex; flex-wrap:wrap;  margin-right: -15px; margin-left: -15px;">
                                                                            <div
                                                                                style=" min-height: 245px; flex: 0 0 40%;max-width: 40%; position: relative; width: 100%; padding-right: 15px;  padding-left: 15px;">
                                                                                <p style="margin-top: 0.5rem !important;margin-bottom: 0 !important; font-family: Madeglin, sans-serif;">
                                                                                    <label for="">Print/Color:</label>
                                                                                    {{ @$variation->printdesign->name }}
                                                                                </p>
                                                                                <img style=" width: 70% !important;"
                                                                                     src="{{ asset('storage/'.strtolower(@$variation->printdesign->file)) }}"
                                                                                     height="120" width="120"
                                                                                     style="object-fit: cover">
                                                                                <p style=" font-size: 12px !important; font-family: Madeglin, sans-serif; margin:0px !important;">
                                                                                    <span for="">Notes:</span>
                                                                                    {{ $variation->notes ?? 'None' }}
                                                                                </p>
                                                                            </div>
                                                                            @if($variation->trim->count() > 0)
                                                                                @foreach($variation->trim as $trim)
                                                                                    <div
                                                                                        style=" flex: 0 0 40%;max-width: 40%; position: relative; width: 100%; padding-right: 15px;  padding-left: 15px;">
                                                                                        <p style="margin-top: 0.5rem !important;margin-bottom: 0 !important; font-family: Madeglin, sans-serif;">
                                                                                            <label for="">Trim:</label>
                                                                                        </p>
                                                                                        <img
                                                                                            style=" width: 70% !important;"
                                                                                            src="{{ asset(strtolower(@$trim->trim_image)) }}"
                                                                                            height="120" width="100%"
                                                                                            style="object-fit: cover">
                                                                                        <p style=" font-size: 12px !important; font-family: Madeglin, sans-serif; margin:0px !important;">
                                                                                            <span for="">Notes:</span>
                                                                                            {{@$trim->trim_note}}
                                                                                        </p>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>

                                                                        <div
                                                                            style="margin-bottom: 0.5rem !important; margin-top: 5px !important !important;">
                                                                            <p style="font-size: 10px !important; text-transform: uppercase !important; margin: 0 !important; font-family: Madeglin, sans-serif;">
                                                                                <span for="">REG. Packs:</span>
                                                                                {{ $variation->regular_qty }} |
                                                                                <span
                                                                                    class="widget-title-color-red ">
                                                    Sku: {{ $variation->sku }}
                                                </span>
                                                                            </p>
                                                                            <p style="font-size: 10px !important; text-transform: uppercase !important; margin: 0 !important; font-family: Madeglin, sans-serif;">
                                                                                {{ $variation->plus_qty }} |
                                                                                <span
                                                                                    class="widget-title-color-red">
                                                    Plus Sku: {{ $variation->plus_sku }}
                                                </span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @if($thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE)
                                        <h6>PRIVATE LABEL SIZES</h6>
                                        <div style="display:flex;">
                                            @foreach($thread->regular_product_categories()->get() as $cat)
                                                @if(isset($cat->category_sizes))
                                                    @foreach($cat->category_sizes as $catSize)
                                                        <div
                                                            style=" margin: 0px 5px;background: #e8e8e8 !important; padding: 10px  !important;width: 65px  !important; border-radius: 5px  !important;    border: 1px solid #9a9a9a  !important;">
                                                            <label for="name">{{$catSize->full_name}}</label>
                                                            <p>{{get_pvt_cat_size_qty($thread->id,$cat->id,$catSize->id)}}</p>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif()
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--            Denim Print --}}
            <div class="d-none" id="DivDenimToPrint">
                <table style="border: 1px solid #333;
                        border-collapse: collapse; border-spacing: 0;    width: 100%;
                        margin-top: 15px;">
                    <tbody>
                    <tr>
                        <td style="border: 1px solid #333;text-align: center;" colspan="1" rowspan="3"
                            class="tablelogo">
                            <img src="http://localhost/landb/public/images/lucky&amp;blessed_logo_sign_Black 1.png"
                                 alt="">
                        </td>
                        <td style="width: 12%; border: 1px solid #333; padding:10px;" colspan="1" rowspan="1">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif; margin: 0px;">
                                Order Date:<br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ parse_date($thread->order_date) }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" rowspan="1" colspan="1">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Description <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ $thread->name }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="1">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Designer: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ $thread->designer->first_name.' '.$thread->designer->last_name }}</span>
                            </p>
                        </td>
                        <td style="width: 8%; border: 1px solid #333; vertical-align: top;" colspan="1" rowspan="2"
                            class="p-0">
                            <div class="regpack">
                                <h6 style="font-size: 12px; margin:0px; background: #333;  font-family: Madeglin, sans-serif; color: #fff; padding: 4px; text-align: center; text-transform: uppercase; font-weight: 400;">{{$thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? 'Sizes' : 'Reg Pack Size Run'}}</h6>
                                @if(isset($options['data']['reg_cat']->category_sizes))
                                    @foreach($options['data']['reg_cat']->category_sizes as $key => $reg_cat)
                                        <div class="sizediv">
                                            {{ $thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? strtok($reg_cat->name,'-') : $reg_cat->name }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </td>


                        @if(!empty($options['data']['plus_cat']))

                            <td style="width: 8%;border: 1px solid #333; vertical-align: top;" colspan="1" rowspan="2"
                                class="p-0">
                                <div class="regpack">
                                    <h6 style="font-size: 12px; margin:0px; background: #333;  font-family: Madeglin, sans-serif; color: #fff; padding: 4px; text-align: center; text-transform: uppercase; font-weight: 400;">
                                        Plus Pack
                                        Size</h6>
                                    @if(isset($options['data']['plus_cat']->category_sizes))
                                        @foreach($options['data']['plus_cat']->category_sizes as $key => $plus_cat)
                                            <div class="sizediv">
                                                {{ $thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? strtok($plus_cat->name,'-') : $plus_cat->full_name }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>

                        @endif

                        <td style="width: 13%;border: 1px solid #333;  padding:0px 10px;" rowspan="1" colspan="2">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                PP Sample Due Date <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ parse_date($thread->pp_sample_date) }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="2">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Request PP Sample: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ @$thread->pp_sample }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                PP Sample Size: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ @$thread->pp_sample_size }} </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 14%;border: 1px solid #333;  padding:0px 10px;">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Style # <br>
                                <span style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">  Reg Pack:  {{ $options['data']['reg_sku'] }} <br>
                                            @if(!empty($options['data']['plus_sku']))
                                        Plus Pack:  {{ $options['data']['plus_sku'] }}
                                    @endif
                     </span>
                            </p>
                        </td>
                        <td colspan="2" style="width: 14%;border: 1px solid #333;  padding:0px 10px;">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Category <br>

                                <span style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">
                     Reg Pack: {{ @$options['data']['reg_cat']->name }}<br>
                     <span style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">
                     @if(!empty($options['data']['plus_cat']))
                             Plus Pack: {{ @$options['data']['plus_cat']->name }}
                         @endif
                     </span>
                     </span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="2">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Season: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">  {{ @$thread->season->name }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="2">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Vendor: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ @$thread->vendor->first_name.' '.@$thread->vendor->last_name }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="1">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Status: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ $thread->thread_status }}</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="3">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Shipping Method: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ $thread->shipping_method }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="3">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                Ship Date: <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ parse_date($thread->ship_date) }}</span>
                            </p>
                        </td>
                        <td style="border: 1px solid #333;  padding:0px 10px;" colspan="4">
                            <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                No Later Than <br>
                                <span
                                    style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ parse_date($thread->cancel_date) }}</span>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div style="    margin: 30px 0;
         border: solid 1px #333;
         padding: 15px;
         border-radius: 5px;">
                    <div style=" display: flex;
            margin-right: -15px;
            margin-left: -15px;">
                        <div style=" flex: 0 0 20.333333%;
               max-width: 20.333333%;    position: relative;
               width: 100%;
               padding-right: 15px;
               padding-left: 15px;">
                            <h4 style=" text-align: center;
                  font-size: 16px;
                  text-transform: uppercase;
                  margin: 0; font-family: Madeglin, sans-serif;">Style</h4>


                            @if(!is_null($thread->spec_files))
                                @if(count($thread->spec_files))
                                    <div style=" max-width: 1000px;
                  position: relative;
                  margin: auto; margin-top: 1.5rem !important;">
                                        @foreach($thread->spec_files as $file)
                                            <div>
                                                <img
                                                    src="{{ asset($file->spec_file) }}"
                                                    style="width:100%; height:310px;">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                            <br>
                        </div>
                        <div style="    flex: 0 0 74.76667%;
               max-width: 74.76667%;     position: relative;
               width: 100%;
               padding-right: 15px;
               padding-left: 15px;">
                            <div>
                                <h4 style="    text-align: center;
                     font-size: 16px;
                     text-transform: uppercase;
                     margin: 0; font-family: Madeglin, sans-serif;">SPECIFICATIONS</h4>
                                <div class="denim_table">
                                    <table style="border: 1px solid #333;
                        border-collapse: collapse;
                        height: 100%; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th style=" font-weight: 600; font-family: Madeglin, sans-serif;padding: 8px; vertical-align: top;  font-size: 14px;"
                                                colspan="1" rowspan="1">Inseam: {{ $thread->inseam }}</th>
                                            <th style=" font-weight: 600; font-family: Madeglin, sans-serif;padding: 8px; vertical-align: top;  font-size: 14px;"
                                                colspan="1" rowspan="1">Label: {{ @$thread->label }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="background: #ff442e; font-weight: 600; font-family: Madeglin, sans-serif; border: 1px solid #333; padding: 8px; vertical-align: top;  font-size: 14px;"
                                                colspan="12">
                                                <div
                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif;display: flex; justify-content: space-between;">
                                                    <b>Fit</b>
                                                    @foreach(array_chunk($options['data']['fits'], 5, true) as $fits)
                                                        <div class="item">
                                                            @foreach($fits as $key => $fit)
                                                                <div
                                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif;display: flex;  justify-content: space-between; align-items: baseline;">
                                                                    <label for=""> {{ $fit }}</label>
                                                                    <input style=" font-weight: 600; font-family: Madeglin, sans-serif;background-color: #ffffff; background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFAQMAAAC3obSmAAAABlBMVEUAAADw8PC5otm+AAAAAXRSTlMAQObYZgAAABJJREFUCNdj4GAQYFBgcGBoAAACogD5g5VHSAAAAABJRU5ErkJggg==); border-color: #ff0000;   color: #000000;
    cursor: default;  opacity: 1.65 !important;" type="checkbox" type="checkbox"
                                                                           disabled {!! ($key == $thread->fit_id) ? 'checked' : '' !!}>
                                                                           <img src="'. asset('images/checked.png') .'" alt="">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background: #ff442e; font-weight: 600; font-family: Madeglin, sans-serif; border: 1px solid #333; padding: 8px; vertical-align: top;  font-size: 14px;"
                                                colspan="12">
                                                <div
                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif;display: flex; justify-content: space-between;">
                                                    <b>Rise</b>
                                                    @foreach(array_chunk($options['data']['rises'], 1, true) as $rises)
                                                        <div class="item">
                                                            @foreach($rises as $key => $rise)
                                                                <div
                                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif;display: flex;  justify-content: space-between; align-items: baseline;">
                                                                    <label for=""> {{ $rise }}</label>
                                                                    <input style=" font-weight: 600; font-family: Madeglin, sans-serif;background-color: #ffffff; background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFAQMAAAC3obSmAAAABlBMVEUAAADw8PC5otm+AAAAAXRSTlMAQObYZgAAABJJREFUCNdj4GAQYFBgcGBoAAACogD5g5VHSAAAAABJRU5ErkJggg==); border-color: #ff0000;   color: #000000;
    cursor: default;  opacity: 1.65 !important;" type="checkbox"
                                                                           disabled {!! ($key == $thread->rise_id) ? 'checked' : '' !!}>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style=" font-weight: 600; font-family: Madeglin, sans-serif; border: 1px solid #333; padding: 8px; vertical-align: top;  font-size: 14px;"
                                                colspan="12">
                                                <div
                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif;display: flex; justify-content: space-between;">
                                                    <b>Reg Pack Qty: </b>{{ $thread->reg_pack_qty }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style=" font-weight: 600; font-family: Madeglin, sans-serif; border: 1px solid #333; padding: 8px; vertical-align: top;  font-size: 14px;"
                                                colspan="12">
                                                <div
                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif;display: flex; justify-content: space-between;">
                                                    <b>Plus Pack Qty: </b>{{ $thread->plus_pack_qty }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style=" font-weight: 600; font-family: Madeglin, sans-serif; border: 1px solid #333; padding: 8px; vertical-align: top;  font-size: 14px;"
                                                colspan="12">
                                                <div
                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif;display: flex; justify-content: space-between;">
                                                    <b>Fabric Print Direction: </b>
                                                    {{ $thread->fabric_print_direction }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style=" font-weight: 600; font-family: Madeglin, sans-serif; border: 1px solid #333; padding: 8px; vertical-align: top;  font-size: 14px;"
                                                colspan="12">
                                                {{--<div style=" font-weight: 600; font-family: Madeglin, sans-serif;display: flex; justify-content: space-between;">
                                                    <b>Additional Notes: </b>
                                                    {{ $thread->description }}
                                                </div>--}}
                                                <div
                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif; display: flex !important;">
                                                    <div style="    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;">
                                                        <div style=" font-weight: 600; font-family: Madeglin, sans-serif; flex: 0 0 50%;
    max-width: 50%;    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;">
                                                            <div
                                                                style="background: #ffffff;
    border: 1px solid #d0d0d0;
    border-radius: 10px; margin-bottom: 1rem !important; padding-right: 1rem !important; padding-left: 1rem !important; font-weight: 600; font-family: Madeglin, sans-serif;">
                                                                @foreach($variations as $variation)
                                                                    @if($variation->status == 'active' && $variation->is_denim == 1)
                                                                        {{--<h5 class=" mt-2">{{$loop->iteration}}. Variation: {{$variation->name}}</h5>--}}


                                                                        <div style=" font-weight: 600; font-family: Madeglin, sans-serif; display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;">
                                                                            <div style=" font-weight: 600; font-family: Madeglin, sans-serif;flex: 0 0 40%;
    max-width: 40%;    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;">
                                                                                <p style=" font-weight: 600; font-family: Madeglin, sans-serif; margin-bottom: 0 !important; margin-top: 0.5rem !important;">
                                                                                    <label
                                                                                        for="">Print/Color:</label>
                                                                                    {{ @$variation->printdesign->name }}
                                                                                </p>
                                                                                <img height="120"
                                                                                     style=" font-weight: 600; font-family: Madeglin, sans-serif;object-fit: cover;width: 100% !important;"
                                                                                     src="{{ asset('storage/'.strtolower(@$variation->printdesign->file)) }}"/>

                                                                            </div>
                                                                            @foreach($variation->fabrics as $fabric)
                                                                                <div style=" font-weight: 600; font-family: Madeglin, sans-serif;flex: 0 0 40%;
    max-width: 40%;    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;">
                                                                                    <p style=" font-weight: 600; font-family: Madeglin, sans-serif; margin-bottom: 0 !important; margin-top: 0.5rem !important;">
                                                                                        <label
                                                                                            for="">Print/Color:</label>
                                                                                        {{ @$fabric->printdesign->name }}
                                                                                        <a href="{{ route('thread.removeFabric', $fabric->id) }}">
                                                                                            <strong
                                                                                                style=" font-weight: 600; font-family: Madeglin, sans-serif;float: right !important;">
                                                                                                <i class="fa fa-times"></i>
                                                                                            </strong>
                                                                                        </a>
                                                                                    </p>
                                                                                    <img
                                                                                        src="{{ asset('storage/'.strtolower(@$fabric->printdesign->file)) }}"
                                                                                        height="120"
                                                                                        style=" font-weight: 600; font-family: Madeglin, sans-serif;object-fit: cover;width: 100% !important;">
                                                                                </div>
                                                                            @endforeach
                                                                            @if($variation->trim->count() > 0)
                                                                                @foreach($variation->trim as $trim)
                                                                                    <div
                                                                                        style=" font-weight: 600; font-family: Madeglin, sans-serif;flex: 0 0 40%;
    max-width: 40%;    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;">
                                                                                        <p style=" font-weight: 600; font-family: Madeglin, sans-serif; margin-bottom: 0 !important; margin-top: 0.5rem !important;">
                                                                                            <label
                                                                                                for="">Trim:</label>
                                                                                            <a href="{{ route('thread.removeVariationTrim',$trim->id) }}">
                                                                                                <strong
                                                                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif;float: right !important;">
                                                                                                    <i class="fa fa-times"></i>
                                                                                                </strong>
                                                                                            </a>
                                                                                        </p>
                                                                                        <img
                                                                                            src="{{ asset(strtolower(@$trim->trim_image)) }}"
                                                                                            height="120"
                                                                                            style=" font-weight: 600; font-family: Madeglin, sans-serif;object-fit: cover;width: 100% !important;">
                                                                                        <p style=" font-weight: 600; font-family: Madeglin, sans-serif; margin-bottom: 0 !important; margin-top: 0.5rem !important;">
                                                                                            <label for="">
                                                                                                NOTES:{{@$trim->trim_note}}
                                                                                            </label>
                                                                                        </p>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>

                                                                        <div
                                                                            style=" font-weight: 600; font-family: Madeglin, sans-serif;margin-bottom: 0.5rem !important; margin-top: 1rem !important;">
                                                                            <p style=" font-weight: 600; font-family: Madeglin, sans-serif; margin-bottom: 0 !important; margin-top: 0.5rem !important;">
                                                                                <label for="">Fabric:</label>
                                                                                {{ @$variation->fabric->name }}
                                                                            </p>
                                                                            <p style=" font-weight: 600; font-family: Madeglin, sans-serif;color: #000000 !important; margin: 0 !important; text-transform: uppercase !important; font-size: 12px !important;">
                                                                                <span for="">REG. Packs:</span>
                                                                                {{ $variation->regular_qty }} |
                                                                                <span
                                                                                    style=" font-weight: 600; font-family: Madeglin, sans-serif; color: #f36a5a;">
                                                                                            Sku: {{ $variation->sku }}
                                                                                        </span>
                                                                            </p>
                                                                            @if($variation->plus_sku)
                                                                                <p style=" font-weight: 600; font-family: Madeglin, sans-serif;color: #000000 !important; margin: 0 !important; text-transform: uppercase !important; font-size: 12px !important;">
                                                                                            <span
                                                                                                for="">PLUS Packs:</span>
                                                                                    {{ $variation->plus_qty }} |
                                                                                    <span
                                                                                        style=" font-weight: 600; font-family: Madeglin, sans-serif; color: #f36a5a;">
                                                                                                Plus Sku: {{ $variation->plus_sku }}
                                                                                            </span>
                                                                                </p>
                                                                            @endif
                                                                            <p style=" font-weight: 600; font-family: Madeglin, sans-serif;color: #000000 !important; margin: 0 !important; text-transform: uppercase !important; font-size: 12px !important;">
                                                                                        <span
                                                                                            for="">Notes:</span> {{ $variation->notes ?? 'None' }}
                                                                            </p>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @if($thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE)
                                        <h6>PRIVATE LABEL SIZES</h6>
                                        <div style="display:flex;">
                                            @foreach($thread->regular_product_categories()->get() as $cat)
                                                @if(isset($cat->category_sizes))
                                                    @foreach($cat->category_sizes as $catSize)
                                                        <div
                                                            style=" margin: 0px 5px;background: #e8e8e8 !important; padding: 10px  !important;width: 65px  !important; border-radius: 5px  !important;    border: 1px solid #9a9a9a  !important;">
                                                            <label for="name">{{$catSize->full_name}}</label>
                                                            <p>{{get_pvt_cat_size_qty($thread->id,$cat->id,$catSize->id)}}</p>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                @endif()
                                <!-- <table style="border: 1px solid #333;
                        border-collapse: collapse;
                        height: 100%;border-spacing: 0;    width: 100%;
                        margin-top: 15px;">
                                        <tbody>
                                        <tr>
                                            <td style="border: 1px solid #333;  padding:0px 10px;">
                                                <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                                    Material:
                                                    <span
                                                        style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ @$thread->material }}</span>
                                                </p>
                                            </td>
                                            <td style="border: 1px solid #333;  padding:0px 10px;" rowspan="2">
                                                <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                                    Label:
                                                    <span
                                                        style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; "> {{ @$thread->label }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #333;  padding:0px 10px;">
                                                <p style="font-size: 12px !important; font-weight: 600; font-family: Madeglin, sans-serif;margin: 0px;">
                                                    Sleeve Length:
                                                    <span
                                                        style="color: #f36a5a; text-transform: uppercase !important; font-weight: 400; ">{{ @$thread->sleeve }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 8px; vertical-align: top; font-size: 14px;"
                                                colspan="12">
                                                <div style="background: #f5f5f5; padding: 10px; border-radius: 5px;">

                                                    <div
                                                        style="display: flex;flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">
                                                        @foreach($variations as $variation)
                                    @if($variation->status == 'active' && $variation->is_denim == 0)
                                        <div
                                            style=" flex: 0 0 44.333333%; max-width: 44.333333%; position: relative; width: 100%; padding-right: 15px; padding-left: 15px;">
                                            <div
                                                style=" min-height: 445px; background: #ffffff;  border: 1px solid #d0d0d0;  border-radius: 10px; padding-left: 1rem !important; padding-right: 1rem !important; ">
                                                <h5 style=" margin-top: 0.5rem !important; font-family: Madeglin, sans-serif;">
{{$loop->iteration}}.
                                                                            Variation: {{ $variation->name }}
                                            </h5>
                                            <div
                                                style=" display: flex; flex-wrap:wrap;  margin-right: -15px; margin-left: -15px;">
                                                <div
                                                    style=" min-height: 245px; flex: 0 0 40%;max-width: 40%; position: relative; width: 100%; padding-right: 15px;  padding-left: 15px;">
                                                    <p style="margin-top: 0.5rem !important;margin-bottom: 0 !important; font-family: Madeglin, sans-serif;">
                                                        <label for="">Print/Color:</label>
{{ @$variation->printdesign->name }}
                                            </p>
                                            <img style=" width: 70% !important;"
                                                 src="{{ asset('storage/'.strtolower(@$variation->printdesign->file)) }}"
                                                                                     height="120" width="120"
                                                                                     style="object-fit: cover">
                                                                                <p style=" font-size: 12px !important; font-family: Madeglin, sans-serif; margin:0px !important;">
                                                                                    <span for="">Notes:</span>
                                                                                    {{ $variation->notes ?? 'None' }}
                                            </p>
                                        </div>
@if($variation->trim->count() > 0)
                                            @foreach($variation->trim as $trim)
                                                <div
                                                    style=" flex: 0 0 40%;max-width: 40%; position: relative; width: 100%; padding-right: 15px;  padding-left: 15px;">
                                                    <p style="margin-top: 0.5rem !important;margin-bottom: 0 !important; font-family: Madeglin, sans-serif;">
                                                        <label for="">Trim:</label>
                                                    </p>
                                                    <img
                                                        style=" width: 70% !important;"
                                                        src="{{ asset(strtolower(@$trim->trim_image)) }}"
                                                                                            height="120" width="100%"
                                                                                            style="object-fit: cover">
                                                                                        <p style=" font-size: 12px !important; font-family: Madeglin, sans-serif; margin:0px !important;">
                                                                                            <span for="">Notes:</span>
                                                                                            {{@$trim->trim_note}}
                                                    </p>
                                                </div>
@endforeach
                                        @endif
                                            </div>

                                            <div
                                                style="margin-bottom: 0.5rem !important; margin-top: 5px !important !important;">
                                                <p style="font-size: 10px !important; text-transform: uppercase !important; margin: 0 !important; font-family: Madeglin, sans-serif;">
                                                    <span for="">REG. Packs:</span>
{{ $variation->regular_qty }} |
                                                                                <span
                                                                                    class="widget-title-color-red ">
                                                    Sku: {{ $variation->sku }}
                                            </span>
                                                                        </p>
                                                                        <p style="font-size: 10px !important; text-transform: uppercase !important; margin: 0 !important; font-family: Madeglin, sans-serif;">
{{ $variation->plus_qty }} |
                                                                                <span
                                                                                    class="widget-title-color-red">
                                                    Plus Sku: {{ $variation->plus_sku }}
                                            </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
@endif
                                @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="denim_table new_clothing">
                <div class="">

                    <div class="table-responsive">
                        <table>
                            <tbody>
                            <tr>
                                <td colspan="1" rowspan="3" class="tablelogo">
                                    <img src="{{ asset('images/lucky&blessed_logo_sign_Black 1.png') }}" alt="">
                                </td>
                                <td style="width: 12%;" colspan="1" rowspan="1">
                                    <p class="font-bold font-12">Order Date:<br>
                                        <span
                                            class="widget-title-color-red text-uppercase">{{ parse_date($thread->order_date) }}</span>
                                    </p>
                                </td>
                                <td rowspan="1" colspan="1">
                                    <p class="font-bold font-12">Description <br>
                                        <span class="widget-title-color-red text-uppercase">{{ $thread->name }}</span>
                                    </p>
                                </td>
                                <td colspan="1">
                                    <p class="font-bold font-12">Designer: <br>
                                        <span
                                            class="widget-title-color-red text-uppercase"> {{ $thread->designer->first_name.' '.$thread->designer->last_name }}</span>
                                    </p>
                                </td>
                                <td style="width: 8%;" colspan="1" rowspan="2" class="p-0">
                                    <div class="regpack">
                                        <h6>{{$thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? 'Sizes' : 'Reg Pack Size Run'}}</h6>
                                        @if(isset($options['data']['reg_cat']->category_sizes))
                                            @foreach($options['data']['reg_cat']->category_sizes as $key => $reg_cat)
                                                <div class="sizediv">
                                                    {{ $thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? strtok($reg_cat->name,'-') : $reg_cat->full_name }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td style="width: 8%;" colspan="1" rowspan="2" class="p-0">
                                    @if(!empty($options['data']['plus_cat']))
                                        <div class="regpack">
                                            <h6 style="font-size: 12px; margin:0px; background: #333;  font-family: Madeglin, sans-serif; color: #fff; padding: 4px; text-align: center; text-transform: uppercase; font-weight: 400;">
                                                Plus Pack Size Run</h6>
                                            @if(isset($options['data']['plus_cat']->category_sizes))
                                                @foreach($options['data']['plus_cat']->category_sizes as $key => $plus_cat)
                                                    <div class="sizediv">
                                                        {{ $thread->thread_status == \Botble\Thread\Models\Thread::PRIVATE ? strtok($plus_cat->name,'-') : $plus_cat->full_name }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    @endif
                                </td>
                                <td style="width: 13%;" rowspan="1" colspan="2">
                                    <p class="font-bold font-12">PP Sample Due Date <br>
                                        <span
                                            class="widget-title-color-red"> {{ parse_date($thread->pp_sample_date) }}</span>
                                    </p>
                                </td>
                                <td colspan="2">
                                    <p class="font-bold font-12">Request PP Sample: <br>
                                        <span
                                            class="widget-title-color-red text-uppercase">{{ @$thread->pp_sample }}</span>
                                    </p>
                                </td>
                                <td>
                                    <p class="font-bold font-12">PP Sample Size: <br>
                                        <span
                                            class="widget-title-color-red text-uppercase"> {{ @$thread->pp_sample_size }}</span>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 14%;">
                                    <p class="font-bold font-12">Style # <br>
                                        <span class="widget-title-color-red text-uppercase"> Reg Pack:  {{ $options['data']['reg_sku'] }} <br>
                                            @if(!empty($options['data']['plus_sku']))
                                                Plus Pack:  {{ $options['data']['plus_sku'] }}
                                            @endif
                                        </span>
                                    </p>
                                </td>
                                <td colspan="2" style="width: 14%;">
                                    <p class="font-bold font-12">Category <br>
                                        <span class="widget-title-color-red text-uppercase">
                                            Reg Pack: {{ @$options['data']['reg_cat']->name }}<br>
                                            <span class="widget-title-color-red text-uppercase">
                                                @if(!empty($options['data']['plus_cat']))
                                                    Plus Pack: {{ @$options['data']['plus_cat']->name }}
                                                @endif
                                            </span>
                                        </span>
                                    </p>
                                </td>
                                <td colspan="2">
                                    <p class="font-bold font-12">Season: <br>
                                        <span
                                            class="widget-title-color-red text-uppercase"> {{ @$thread->season->name }}</span>
                                    </p>
                                </td>
                                <td colspan="2">
                                    <p class="font-bold font-12">Vendor: <br>
                                        <span
                                            class="widget-title-color-red text-uppercase">{{ @$thread->vendor->first_name.' '.@$thread->vendor->last_name }}</span>
                                    </p>
                                </td>
                                <td colspan="1">
                                    <p class="font-bold font-12">Status: <br>
                                        <span
                                            class="widget-title-color-red text-uppercase">{{ $thread->thread_status }}</span>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p class="font-bold font-12">Shipping Method: <br>
                                        <span
                                            class="widget-title-color-red text-uppercase"> {{ $thread->shipping_method }}</span>
                                    </p>
                                </td>
                                <td colspan="3">
                                    <p class="font-bold font-12">Ship Date: <br>
                                        <span
                                            class="widget-title-color-red text-uppercase"> {{ parse_date($thread->ship_date) }}</span>
                                    </p>
                                </td>
                                <td colspan="4">
                                    <p class="font-bold font-12">No Later Than <br>
                                        <span
                                            class="widget-title-color-red text-uppercase"> {{ parse_date($thread->cancel_date) }}</span>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="style_specification">
                        <div class="row ">
                            <div class="col-md-4 ">
                                <h4>Style</h4>
                                @if(!is_null($thread->spec_files))
                                    @if(count($thread->spec_files))
                                        <div class="slideshow-container mt-4">
                                            @foreach($thread->spec_files as $file)
                                                <div class="mySlides1 images">
                                                    <img src="{{ asset($file->spec_file) }}"
                                                         style="width:100%; height:669px;">
                                                    {{--<div class="text">Caption Text</div>--}}
                                                </div>
                                            @endforeach
                                            <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                                            <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                                        </div>
                                        <div id="image-viewer">
                                            <span class="close">X</span>
                                            <img class="viewer-modal-content" id="full-image">
                                        </div>
                                        <br>
                                        <div style="text-align:center">
                                            @foreach($thread->spec_files as $file)
                                                <span class="dot"></span>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-8">
                                @if($thread->is_denim == 1)
                                    <div class="specificationwrap">
                                        <h4>Specifications</h4>
                                        <div class="table-responsive">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th colspan="1" rowspan="1">Inseam: {{ $thread->inseam }}</th>
                                                    <th colspan="1" rowspan="1">Label: {{ @$thread->label }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="tabrow">
                                                            <b>Fit</b>
                                                            @foreach(array_chunk($options['data']['fits'], 5, true) as $fits)
                                                                <div class="item">
                                                                    @foreach($fits as $key => $fit)
                                                                        <div class="checkbox">
                                                                            <label for=""> {{ $fit }}</label>
                                                                            <input type="checkbox"
                                                                                   disabled {!! ($key == $thread->fit_id) ? 'checked' : '' !!}>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="tabrow">
                                                            <b>Rise</b>
                                                            @foreach(array_chunk($options['data']['rises'], 1, true) as $rises)
                                                                <div class="item">
                                                                    @foreach($rises as $key => $rise)
                                                                        <div class="checkbox">
                                                                            <label for=""> {{ $rise }}</label>
                                                                            <input type="checkbox"
                                                                                   disabled {!! ($key == $thread->rise_id) ? 'checked' : '' !!}>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                    <td colspan="12">
                                                        <div style="display: flow-root;" class="tabrow">
                                                            <b>Fabric:</b>
                                                            @foreach(array_chunk($options['data']['fabrics'], 1, true) as $fabrics)
                                                    <div class="item">
@foreach($fabrics as $key => $fabric)
                                                        <div class="checkbox">
                                                            <label for=""> {{ $fabric }}</label>
                                                                            <input type="checkbox"
                                                                                   disabled {!! ($key == $thread->fabric_id) ? 'checked' : '' !!}>
                                                                        </div>
                                                                    @endforeach
                                                        </div>
@endforeach
                                                    </div>
                                                </td>
                                            </tr> -->
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="tabrow">
                                                            <b>Reg Pack Qty: </b>{{ $thread->reg_pack_qty }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="tabrow">
                                                            <b>Plus Pack Qty: </b>{{ $thread->plus_pack_qty }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="tabrow">
                                                            <b>Fabric Print Direction: </b>
                                                            {{ $thread->fabric_print_direction }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">
                                                        {{--<div class="tabrow ">
                                                            <b>Additional Notes: </b>
                                                            {{ $thread->description }}
                                                        </div>--}}
                                                        <div class="d-flex">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div
                                                                        class="variationdiv variation-div pl-3 pr-3 mb-3">
                                                                        @foreach($variations as $variation)
                                                                            @if($variation->status == 'active' && $variation->is_denim == 1)
                                                                                {{--<h5 class=" mt-2">{{$loop->iteration}}. Variation: {{$variation->name}}</h5>--}}

                                                                                <div class="box w-100">
                                                                                    <h6>{{ $variation->name }}
                                                                                        <button type="button"
                                                                                                class="btn btn-warning add_print"
                                                                                                data-toggle="modal"
                                                                                                data-target="#modal-default"
                                                                                                data-id="{{ $variation->id }}"
                                                                                                data-name="{{ $variation->name }}">
                                                                                            Add Fabric
                                                                                        </button>
                                                                                        <button type="button"
                                                                                                class="btn btn-primary add_trim"
                                                                                                data-toggle="modal"
                                                                                                data-target="#modal-var-trim"
                                                                                                data-id="{{ $variation->id }}">
                                                                                            Add Trim
                                                                                        </button>
                                                                                    </h6>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-lg-6 images">
                                                                                        <p class="mb-0 mt-2">
                                                                                            <label
                                                                                                for="">Print/Color:</label>
                                                                                            {{ @$variation->printdesign->name }}
                                                                                        </p>
                                                                                        <img class="w-100" height="120"
                                                                                             width="120"
                                                                                             style="object-fit: cover"
                                                                                             src="{{ asset('storage/'.strtolower(@$variation->printdesign->file)) }}"/>
                                                                                        <div id="image-viewer">
                                                                                            <span class="close">X</span>
                                                                                            <img
                                                                                                class="viewer-modal-content"
                                                                                                id="full-image">
                                                                                        </div>
                                                                                    </div>
                                                                                    @foreach($variation->fabrics as $fabric)
                                                                                        <div class="col-lg-6 images">
                                                                                            <p class="mb-0 mt-2">
                                                                                                <label for="">Print/Color:</label>
                                                                                                {{ @$fabric->printdesign->name }}
                                                                                                <a href="{{ route('thread.removeFabric', $fabric->id) }}">
                                                                                                    <strong
                                                                                                        class="float-right">
                                                                                                        <i class="fa fa-times"></i>
                                                                                                    </strong>
                                                                                                </a>
                                                                                            </p>
                                                                                            <img class="w-100"
                                                                                                 src="{{ asset('storage/'.strtolower(@$fabric->printdesign->file)) }}"
                                                                                                 height="120"
                                                                                                 width="120"
                                                                                                 style="object-fit: cover">
                                                                                        </div>
                                                                                    @endforeach
                                                                                    @if($variation->trim->count() > 0)
                                                                                        @foreach($variation->trim as $trim)
                                                                                            <div
                                                                                                class="col-lg-6 images">
                                                                                                <p class="mb-0 mt-2">
                                                                                                    <label
                                                                                                        for="">Trim:</label>
                                                                                                    <a href="{{ route('thread.removeVariationTrim',$trim->id) }}">
                                                                                                        <strong
                                                                                                            class="float-right">
                                                                                                            <i class="fa fa-times"></i>
                                                                                                        </strong>
                                                                                                    </a>
                                                                                                </p>
                                                                                                <img class="w-100"
                                                                                                     src="{{ asset(strtolower(@$trim->trim_image)) }}"
                                                                                                     height="120"
                                                                                                     width="120"
                                                                                                     style="object-fit: cover">
                                                                                                <p class="mb-0 mt-2">
                                                                                                    <label for="">
                                                                                                        NOTES:{{@$trim->trim_note}}
                                                                                                    </label>
                                                                                                </p>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>

                                                                                <div class="mt-3 mb-2">
                                                                                    <p class="mb-0 mt-2">
                                                                                        <label for="">Fabric:</label>
                                                                                        {{ @$variation->fabric->name }}
                                                                                    </p>
                                                                                    <p class="text-black font-12 text-uppercase m-0">
                                                                                        <span for="">REG. Packs:</span>
                                                                                        {{ $variation->regular_qty }} |
                                                                                        <span
                                                                                            class="widget-title-color-red ">
                                                                                            Sku: {{ $variation->sku }}
                                                                                        </span>
                                                                                    </p>
                                                                                    @if($variation->plus_sku)
                                                                                        <p class="text-black font-12 text-uppercase m-0">
                                                                                            <span
                                                                                                for="">PLUS Packs:</span>
                                                                                            {{ $variation->plus_qty }} |
                                                                                            <span
                                                                                                class="widget-title-color-red">
                                                                                                Plus Sku: {{ $variation->plus_sku }}
                                                                                            </span>
                                                                                        </p>
                                                                                    @endif
                                                                                    <p class="text-black font-12 text-uppercase m-0">
                                                                                        <span
                                                                                            for="">Notes:</span> {{ $variation->notes ?? 'None' }}
                                                                                    </p>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="specificationwrap">
                                        <h4>Order</h4>
                                        <div class="table-responsive">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="font-bold font-12"> Material:
                                                            <span
                                                                class="widget-title-color-red text-uppercase">{{ @$thread->material }}</span>
                                                        </p>
                                                    </td>
                                                    <td rowspan="2">
                                                        <p class="font-bold font-12">Label:
                                                            <span
                                                                class="widget-title-color-red text-uppercase"> {{ @$thread->label }}</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p class="font-bold font-12">Sleeve Length:
                                                            <span
                                                                class="widget-title-color-red text-uppercase">{{ @$thread->sleeve }}</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="order-box mb-2 mt-2">
                                                            @foreach($variations as $variation)
                                                                @if($variation->status == 'active' && $variation->is_denim == 0)
                                                                    <div class="box w-100">
                                                                        <h6>{{ $variation->name }}
                                                                            <button type="button"
                                                                                    class="btn btn-warning add_print"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-default"
                                                                                    data-id="{{ $variation->id }}"
                                                                                    data-name="{{ $variation->name }}">
                                                                                Add Fabric
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="btn btn-primary add_trim"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modal-var-trim"
                                                                                    data-id="{{ $variation->id }}">
                                                                                Add Trim
                                                                            </button>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="box row d-mt-block">
                                                                        <div
                                                                            class="col-lg-{{ count($variation->fabrics) ? '12' : '6' }}">
                                                                            <div
                                                                                class="variationdiv variation-div pl-3 pr-3 mb-3">
                                                                                <h5 class=" mt-2">
                                                                                    {{$loop->iteration}}.
                                                                                    Variation: {{ $variation->name }}</h5>
                                                                                <div class="row">
                                                                                    <div class="col-lg-6 images">
                                                                                        <p class="mb-0 mt-2">
                                                                                            <label
                                                                                                for="">Print/Color:</label>
                                                                                            {{ @$variation->printdesign->name }}
                                                                                        </p>
                                                                                        <img class="w-100"
                                                                                             src="{{ asset('storage/'.strtolower(@$variation->printdesign->file)) }}"
                                                                                             height="120" width="120"
                                                                                             style="object-fit: cover">
                                                                                        <div id="image-viewer">
                                                                                            <span class="close">X</span>
                                                                                            <img
                                                                                                class="viewer-modal-content"
                                                                                                id="full-image">
                                                                                        </div>
                                                                                        <p class="text-black font-12 text-uppercase m-0">
                                                                                            <span for="">Notes:</span>
                                                                                            {{ $variation->notes ?? 'None' }}
                                                                                        </p>
                                                                                    </div>
                                                                                    @foreach($variation->fabrics as $fabric)
                                                                                        <div class="col-lg-6 images">
                                                                                            <p class="mb-0 mt-2">
                                                                                                <label for="">Print/Color:</label>
                                                                                                {{ @$fabric->printdesign->name }}
                                                                                                <a href="{{ route('thread.removeFabric', $fabric->id) }}">
                                                                                                    <strong
                                                                                                        class="float-right">
                                                                                                        <i class="fa fa-times"></i>
                                                                                                    </strong>
                                                                                                </a>
                                                                                            </p>
                                                                                            <img class="w-100"
                                                                                                 src="{{ asset('storage/'.strtolower(@$fabric->printdesign->file)) }}"
                                                                                                 height="120"
                                                                                                 width="120"
                                                                                                 style="object-fit: cover">
                                                                                        </div>
                                                                                    @endforeach
                                                                                    @if($variation->trim->count() > 0)
                                                                                        @foreach($variation->trim as $trim)
                                                                                            <div
                                                                                                class="col-lg-6 images">
                                                                                                <p class="mb-0 mt-2">
                                                                                                    <label
                                                                                                        for="">Trim:</label>
                                                                                                    <a href="{{ route('thread.removeVariationTrim',$trim->id) }}">
                                                                                                        <strong
                                                                                                            class="float-right">
                                                                                                            <i class="fa fa-times"></i>
                                                                                                        </strong>
                                                                                                    </a>
                                                                                                </p>
                                                                                                <img class="w-100"
                                                                                                     src="{{ asset(strtolower(@$trim->trim_image)) }}"
                                                                                                     height="120"
                                                                                                     width="120"
                                                                                                     style="object-fit: cover">
                                                                                                <p class="mb-0 mt-2">
                                                                                                    <label for="">
                                                                                                        NOTES:{{@$trim->trim_note}}
                                                                                                    </label>
                                                                                                </p>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>

                                                                                <div class="mt-3 mb-2">
                                                                                    <p class="text-black font-12 text-uppercase m-0">
                                                                                        <span for="">REG. Packs:</span>
                                                                                        {{ $variation->regular_qty }} |
                                                                                        <span
                                                                                            class="widget-title-color-red ">
                                                                                            Sku: {{ $variation->sku }}
                                                                                        </span>
                                                                                    </p>
                                                                                    @if($variation->plus_sku)
                                                                                        <p class="text-black font-12 text-uppercase m-0">
                                                                                            <span
                                                                                                for="">PLUS Packs:</span>
                                                                                            {{ $variation->plus_qty }} |
                                                                                            <span
                                                                                                class="widget-title-color-red">
                                                                                                Plus Sku: {{ $variation->plus_sku }}
                                                                                            </span>
                                                                                        </p>
                                                                                    @endif
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <div class="tab-pane fade" id="ppsample" role="tabpanel" aria-labelledby="ppsample">
        <div class="p-3">
            <div class="">
                @foreach($variations as $pp_sample)
                    <div class="row">
                        <div class="col-lg-12 ">
                            <h6 class="mb-1 thread-head"> THREAD VARIATIONS ({{@$pp_sample->name}}) </h6>
                        </div>
                    </div>
                    <br>
                    <div class="row p-3 mb-3 thread-area">
                        <div class="col-lg-4 mb-3">
                            <h5 class="variation-text">PP Sample </h5>
                            <img class="w-100"
                                 src="{{ asset('storage/'.strtolower(@$pp_sample->printDesign->file)) }}"
                                 height="250" width="120"
                                 style="object-fit: cover">
                        </div>
                        <div class="col-lg-8 mb-3">
                            @foreach($pp_sample->ppSample as $sample)
                                <div class="row">
                                    <div class="col-lg-3 mt-3">
                                        <p class="m-0 heading">Receive Date</p>
                                        <p>{{date('M-d ,Y', strtotime($sample->receive_date))}}</p>
                                    </div>
                                    <div class="col-lg-3 mt-3">
                                        <p class="m-0 heading">Comments</p>
                                        <p>{{@$sample->comments}}</p>
                                    </div>
                                    <div class="col-lg-3 mt-3">
                                        <p class="m-0 heading">Status</p>
                                        <p>{{@$sample->status}}</p>
                                    </div>
                                    {{--<div class="col-lg-3 mt-3">--}}
                                    {{--    <p class="m-0 heading">image</p>--}}
                                    {{--    <p>Vendor</p>--}}
                                    {{--</div>--}}
                                </div>
                            @endforeach
                            <a data-toggle="modal" data-target="#thVarSampleModal"
                               class="btn btn-primary btn-sm thVarSampleModal" data-var-id="{{$variation->id}}">
                                <i class="fa fa-paper-plane"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="thVarSampleModal" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex w-100">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                    <h4 class="modal-title text-center w-100 thread-pop-head">
                        Thread Variation Sample
                        <span class="variation-name"></span>
                    </h4>
                    <div></div>
                </div>
            </div>
            <form method="post" action="{{route('threadvariationsamples.create')}}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="thread_id" class="th_id" value="{{$thread->id}}">
                    <input type="hidden" name="thread_variation_id" class="th_var_id" value="">
                    <div class="mt-3">
                        <label class="font-bold">Select Date:</label>
                        <input type="date" name="assign_date" class="form-control assign_date" required>
                    </div>
                    <div class="mt-3">
                        <label class="font-bold">Select Photographer:</label>
                        <select name="photographer_id" class="form-control photographer_id" required>
                            <option value="" disabled selected>Select Photographer</option>
                            @foreach($options['data']['photographers'] as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary th_var_sample_submit" value="Submit">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<link rel="stylesheet" href="{{ asset('css/style.css') }}"/>

<style>

    .col-md-3.right-sidebar {
        display: none;
    }

    .details-table td {
        border: 1px solid black;
    }

    .widget.meta-boxes.form-actions.form-actions-default.action-horizontal {
        display: none;
    }

    @media screen and (min-width: 992px) and (max-width: 2500px) {
        .main-form {
            width: 135% !important;
        }
    }

    .mySlides1, .mySlides2 {
        display: none
    }

    .slideshow-container img {
        vertical-align: middle;
    }

    /* Slideshow container */
    .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
    }

    /* Next & previous buttons */
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 0px 7px;
        margin-top: -22px;
        color: black;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
        border: 1px solid #fff;
        box-shadow: 0px 0px 10px 5px #4c4c4c;
        margin-right: 4px;
    }

    .prev {
        border: 1px solid #fff;
        box-shadow: 0px 0px 10px 5px #4c4c4c;
        margin-left: 4px;
    }

    /* On hover, add a grey background color */
    .prev:hover, .next:hover {
        background-color: #f1f1f1;
        color: black;
    }

    /* IMAGE SLIDER VIEWER CSS */
    #image-viewer {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .viewer-modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .viewer-modal-content {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }
        to {
            transform: scale(1)
        }
    }

    #image-viewer .close {
        position: absolute;
        top: 74px;
        right: 40px;
        color: #ffffff;
        font-size: 25px;
        font-weight: bold;
        transition: 0.3s;
        width: 25px;
        text-indent: inherit;
        height: 25px;
    }

    #image-viewer .close:hover,
    #image-viewer .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    .images img {
        cursor: -moz-zoom-in;
        cursor: -webkit-zoom-in;
        cursor: zoom-in;
    }

    @media only screen and (max-width: 700px) {
        .viewer-modal-content {
            width: 100%;
        }
    }

    /* IMAGE SLIDER VIEWER CSS */
</style>

<script>


    var slideIndex = [1, 1];
    var slideId = ["mySlides1", "mySlides2"];
    showSlides(1, 0);
    showSlides(1, 1);

    function plusSlides(n, no) {
        showSlides(slideIndex[no] += n, no);
    }

    function showSlides(n, no) {
        var i;
        var x = document.getElementsByClassName(slideId[no]);
        if (n > x.length) {
            slideIndex[no] = 1
        }
        if (n < 1) {
            slideIndex[no] = x.length
        }
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        x[slideIndex[no] - 1].style.display = "block";
    }
</script>

<script>
    function printDiv() {

        var divToPrint = document.getElementById('DivIdToPrint');

        var newWin = window.open('', 'Print-Window');

        newWin.document.open();

        newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        //
        // newWin.document.close();
        //
        // setTimeout(function () {
        //     newWin.close();
        // }, 10);

    }

    function printDenimDiv() {

        var divToPrint = document.getElementById('DivDenimToPrint');

        var newWin = window.open('', 'Print-Window');

        newWin.document.open();

        newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

        // newWin.document.close();
        //
        // setTimeout(function () {
        //     newWin.close();
        // }, 10);

    }

    $(document).ready(function () {


        $(".images img").click(function () {
            $("#full-image").attr("src", $(this).attr("src"));
            $('#image-viewer').show();
        });

        $("#image-viewer .close").click(function () {
            $('#image-viewer').hide();
        });

        $("#thread_status").on('change', function () {
            $.ajax({
                url: '{{ route('thread.changeStatus') }}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'pk': {{$thread->id}},
                    'value': $("select#thread_status option:selected").val(),
                },
                success: function (data) {
                    location.reload();
                },
                error: function (request, status, error) {
                    toastr['warning']('Notification Unreadable', 'Reading Error');
                }
            });
        });

        $("#ready").on('change', function () {
            $.ajax({
                url: '{{ route('thread.changeStatus') }}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'pk': {{$thread->id}},
                    'ready': $("select#ready option:selected").val(),
                },
                success: function (data) {
                    location.reload();
                },
                error: function (request, status, error) {
                    toastr['warning']('Notification Unreadable', 'Reading Error');
                }
            });
        });

        $(document).on('click', 'a.thVarSampleModal', function () {
            $('input.th_var_id').val($(this).data('var-id'));
        });

        $(document).on('click', 'input.th_var_sample_submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('threadvariationsamples.create') }}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'thread_id': $('input.th_id').val(),
                    'thread_variation_id': $('input.th_var_id').val(),
                    'assign_date': $('input.assign_date').val(),
                    'photographer_id': $('select.photographer_id').val(),
                },
                success: function (data) {
                    toastr['success']('Successfully Added', 'Success');
                    location.reload();
                },
                error: function (request, status, error) {
                    toastr['warning']('Something went wrong', 'Error');
                    location.reload();
                }
            });
        });

    });
</script>

