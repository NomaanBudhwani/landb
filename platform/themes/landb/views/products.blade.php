{{--@dd($products['category'])--}}
@php $col='3'; @endphp
@if(auth('customer')->user())

    {!! Theme::partial('breadcrumb', ['category' =>  get_category(request()->path('c_slug'))]) !!}
    <?php /*dd(request()->getQueryString()); */?>
    <section class="shoplisting_wrap">
        <div class="container">
            <div class="filterbar mb-2 d_flex">
                <ul class="leftbar">
                    <li>Showing <span id="products-count">{{ count($products) }}</span> results</li>
                    <li class="seprator"></li>
                    <li>
                        <div class="dropdown">
                            <button class="sortdropdown" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                @switch(request()->query('sort_by'))
                                    @case('name-asc') Name @break
                                    @case('price-asc') Price: Low to High @break
                                    @case('price-desc') Price: High to Low @break
                                    @default Sort by @break

                                @endswitch
                                <i class="fal fa-angle-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'name-asc']) }}">Name</a>
                                <a class="dropdown-item"
                                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-asc']) }}">Price: Low to
                                    High</a>
                                <a class="dropdown-item"
                                   href="{{ request()->fullUrlWithQuery(['sort_by' => 'price-desc']) }}">Price: High to
                                    Low</a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="rightbar">
                    <li class="listingicon">
                        <a href="{{ request()->fullUrlWithQuery(['limit' => 3]) }}"><span
                                class="threedots {{ (request()->query('limit') == 3) ? '':'active' }}"></span></a>
                    </li>
                    <li class="listingicon">
                        <a href="{{ request()->fullUrlWithQuery(['limit' => 4]) }}"><span
                                class="fourdots {{ (request()->query('limit') == 4) ? '':'active' }}"></span></a>
                    </li>
                <!-- <li class="listingicon">
                    <a href="{{ request()->fullUrlWithQuery(['limit' => 5]) }}"><span class="fivedots {{ (request()->query('limit') == 5) ? '':'active' }}"></span></a>
                </li> -->
                    <li class="seprator"></li>
{{--                    <li class="filter"><a href="#" id="filtertoggle" class="filterbtn">Filter <span--}}
{{--                                class="filtericon"></span></a>--}}


{{--                    </li>--}}
                </ul>
            </div>
            <div class="" id="filtermenu">
                <nav class="main-nav filter_nav">
                    {{--<div class="nav-col">
                        <h5>Color</h5>
                        <ul class="colorbox">
                            <li>
                                <a class="black" href="#">
                                    Black
                                </a>
                            </li>
                            <li>
                                <a class="green" href="#">
                                    Green
                                </a>
                            </li>

                            <li>
                                <a class="gray" href="#">
                                    Grey
                                </a>
                            </li>
                            <li>
                                <a class="red" href="#">
                                    Red
                                </a>
                            </li>
                            <li>
                                <a class="white" href="#">
                                    White
                                </a>
                            </li>
                            <li>
                                <a class="yellow" href="#">
                                    Yellow
                                </a>
                            </li>
                        </ul>
                    </div>--}}
                    {{--                <div class="nav-col">--}}
                    {{--                    <h5>Size</h5>--}}
                    {{--                    <div class="d-flex">--}}
                    {{--                    @php $sizes = category_sizes() @endphp--}}
                    {{--                    @foreach($sizes->chunk(10) as $chunk)--}}
                    {{--                        <ul class="ml-4">--}}
                    {{--                            @foreach($chunk as $size)--}}
                    {{--                                @php--}}
                    {{--                                    $selected = (request()->query('size') == $size->id) ? true:false;--}}
                    {{--                                    if($selected){--}}
                    {{--                                        $url = request()->fullUrlWithQuery(['size' => null]);--}}
                    {{--                                    }else{--}}
                    {{--                                        $url = request()->fullUrlWithQuery(['size' => $size->id]);--}}
                    {{--                                    }--}}
                    {{--                                @endphp--}}
                    {{--                                <li>--}}
                    {{--                                    <a class="{{ ($selected) ? 'selected':''  }}" href="{{ $url }}">--}}
                    {{--                                        {{ $size->name }}--}}
                    {{--                                    </a>--}}
                    {{--                                </li>--}}
                    {{--                            @endforeach--}}
                    {{--                        </ul>--}}
                    {{--                    @endforeach--}}
                    {{--                    </div>--}}
                    {{--                </div>--}}
                    <div class="nav-col">
                        <h5>Price</h5>
                        @php $price_ranges =[ ['0', '20'],['20', '40'],['40', '50'],['50', '60'],['60'] ];  @endphp
                        <ul>
                            @foreach($price_ranges as $price_range)
                                @php
                                    $selected = (request()->query('price') == $price_range[0].'-'.@$price_range[1]) ? true:false;
                                    if($selected){
                                        $url = request()->fullUrlWithQuery(['price' => null]);
                                    }else{
                                        $url = request()->fullUrlWithQuery(['price' => $price_range[0].'-'.@$price_range[1]]);
                                    }
                                @endphp
                                <li>
                                    <a class="{{ ($selected) ? 'selected':'' }}" href="{{ $url }}">
                                        ${{ $price_range[0] }} {!! isset($price_range[1]) ? '- $'.$price_range[1] : '+' !!}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="nav-col">
                        <h5>Categories</h5>
                        <ul>
                            @php $categories = parent_categories() @endphp
                            @foreach($categories as $category)
                                @php
                                    $selected = (request()->query('c_slug') == $category->key) ? true:false;
                                    if($selected){
                                        $url = request()->fullUrlWithQuery(['c_slug' => null]);
                                    }else{
                                        $url = request()->fullUrlWithQuery(['c_slug' => $category->key]);
                                    }
                                @endphp
                                <li>
                                    <a class="{{ ($selected) ? 'selected':''  }}" href="{{ $url }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="nav-col">
                        <h5>Tags</h5>
                        <ul class="tags">
                            <li>
                                @php $tags_filter = product_tags() @endphp
                                @foreach($tags_filter as $tag)
                                    @php
                                        $selected = (request()->query('t_slug') == $tag->key)? true:false;
                                        if($selected){
                                            $url = request()->fullUrlWithQuery(['t_slug' => null]);
                                        }else{
                                            $url = request()->fullUrlWithQuery(['t_slug' => $tag->key]);
                                        }
                                    @endphp
                                    <a class="{{ ($selected) ? 'selected':''  }}" href="{{ $url }}">
                                        {{ $tag->name }}{{ ($loop->last) ? '': ',' }}
                                    </a>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </nav>


            </div>
            <div class="shoplisting row" id="paginated-posts">
                @if(count($products))
                    <?php
                    $limit = isset($_GET['limit']) ? $_GET['limit'] : '3';
                    $col = ($limit == '3') ? '4' : $limit;
                    $col = ($limit == '4') ? '3' : $col;
                    $col = ($limit == '5') ? 'custom-5' : $col;
                    ?>
                    @foreach($products as $key => $product)
                        {!! Theme::partial('product-card', ['product' => $product , 'col' => $col]) !!}
                    @endforeach
                @else
                    <h3>No Matching Product Found!</h3>
                @endif
            </div>
            <div class="row text-center" id="products-loader" style="display: none;">
                <div class="spinner-border" role="status" style="margin: auto;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            @if($products->hasPages())
                <hr>
                <div class="row text-center" id="load_more_products">
                    <button type="submit" class="product-tile__add-to-cart m-auto w-25"><span>Load More</span></button>
                </div>
            @endif
            {{--{!! $products->appends($_GET)->links() !!}--}}
            {{-- <div class="pagination">

                 <ul>
                     <li>
                         <a href="#" class="prev"> <i class="fal fa-long-arrow-left"></i> Prev</a>
                     </li>
                     <li>
                         <a href="#" class="">1</a>
                     </li>
                     <li>
                         <a href="#" class="">2</a>
                     </li>
                     <li>
                         <a href="#" class="">3</a>
                     </li>
                     <li>
                         <a href="#" class="">4</a>
                     </li>
                     <li>
                         <a href="#" class="">5</a>
                     </li>
                     <li>
                         <a href="#" class="">6</a>
                     </li>
                     <li>
                         <a href="#" class="next">Next <i class="fal fa-long-arrow-right"></i></a>
                     </li>
                 </ul>
                 <ul>
                     <li>2-16</li>
                 </ul>
             </div>--}}


        </div>


    </section>

@else
    <section class="shoplisting_wrap">
        @php $categories = get_category(request()->path('c_slug')) @endphp
        <div class="">
            <div class="filterbar mb-2">
                {!! Theme::partial('login-partial') !!}
                {!!@$categories->description!!}
            </div>
        </div>
    </section>
@endif()

<!-- Modal Quick View -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg modal-quickview">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="row">
                    <!-- <div class="col-lg-1">
                        <img class="mt-2 side-img" src="./img//product/back.png" />
                        <img class="mt-2 side-img" src="./img//product/side.png" />
                    </div> -->
                    <div class="col-lg-6 mt-2">
                        <!-- <img class="front-img" src="./img//product/Front.png" /> -->
                        <div class="fancy-container clearfix">
                            <div class="gallery">
                                <div class="previews" id="product-detail-images">

                                </div>
                                <div class="full quick-full" id="product-detail-image">
                                    <!-- first image is viewable to start -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h1 class="detail-h1 mb-2" id="product-detail-name"> Coral Cut Out V-neck Basic Tee Plus
                            Size </h1>
                        <p class="detail-price mb-2">$ <span id="product-detail-price">0.0</span></p>
                        <p class="short-description mb-2" id="product-detail-desc"></p>
                        {{--<p class="detail-size-p mb-2"><span class="detail-size">Size</span> <span  id="product-detail-sizes"></span> </p>--}}

                        <form class="add_to_cart_form" id="product-detail-form" data-id="" method='POST'
                              action='{{ route('public.cart.add_to_cart') }}'>
                            <div class="row mt-4">
                                <div class="col-lg-6" hidden>
                                    <input type='button' value='-' class='qtyminus' data-update="0"
                                           field='quantity'/>
                                    <input id="product-detail-qty" type='text' name='quantity' value='1' class='qty'
                                           readonly/>
                                    <input type='button' value='+' class='qtyplus' data-update="0"
                                           field='quantity'/>
                                </div>
                                <div class="col-lg-6">
                                    <button class="cart-btn w-100 add-to-cart-button cart-submit"
                                            id="product-detail-button" data-id="">Add to cart
                                    </button>
                                </div>
                            </div>
                        </form>
                        <p class="mt-4 detail-basic">Basic Code &nbsp;&nbsp;&nbsp;<span class="detail-basic-p"
                                                                                        id="product-detail-sku"></span>
                        </p>
                        <p class="detail-category mt-2">Category: &nbsp;&nbsp;&nbsp;<span
                                class="detail-category-p mt-2"
                                id="product-detail-category"></span>
                        </p>
                        {{--<p class="detail-tag mt-2">Tag:&nbsp;&nbsp;&nbsp;<span class="detail-tag-p" id="product-detail-tags"></span> </p>--}}
                        <div class="d-flex mt-4">
                        <!-- <p class="share-text pt-1 mr-2"> Share this items :
                                </p>
                                <a href="#"><img class="social-img ml-2" src="{{ asset('landb/img/icons/snapchat.png') }}" /></a>
                                <a href="#"><img class="social-img ml-2" src="{{ asset('landb/img/icons/facebook.png') }}" /></a>
                                <a href="#"><img class="social-img ml-2" src="{{ asset('landb/img/icons/Twitter.png') }}" /></a>
                                <a href="#"><img class="social-img ml-2" src="{{ asset('landb/img/icons/instagram.png') }}" /></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Quick View -->

<script src="{{ asset('landb/js/jquery.js') }}"></script>
<script>
    var ENDPOINT = "{{ url()->current() }}";
    var page = 1;
    var haveMore = true;
    /*infinteLoadMore(page);*/

    /* $(window).scroll(function () {
         if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {

             if (haveMore === true) {
                 console.log('scrolling')
                 page++;
                 $('#products-loader').show();
                 haveMore = infinteLoadMore(page);
             }
         }
     });*/

    $('#load_more_products').on('click', function () {
        if (haveMore === true) {
            page++;
            $('#products-loader').show();
            haveMore = infinteLoadMore(page);
        } else {
            $(this).hide();
        }
    })

    function infinteLoadMore(page) {
        var _return = true;
        var str = '{{request()->getQueryString() }}';
        $.ajax({
            url: ENDPOINT + "?page=" + page + '&' + str.replace(/&amp;/g, '&')+'&col={{ isset($col) ? $col:'3' }}',
            type: "get",
            beforeSend: function () {
                showLoader();
                $('#load_more_products').hide();
            },
        })
            .done(function (response) {
                var posts = response.products
                if (posts.length == 0) {
                    $('#load_more_products').hide();
                    _return = false;
                } else {
                    $('#paginated-posts').append(posts);
                    $('#products-count').html(parseFloat($('#products-count').html()) + response.count);
                    $('#load_more_products').show();
                    _return = true;
                }
                hideLoader();
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
                hideLoader();
                return false;
            });
        return _return;
    }

    function showLoader() {
        $("#products-loader").css("display", "");
    }

    function hideLoader() {
        setTimeout(function () {
            $("#products-loader").css("display", "none");
        }, 1000);
    }


</script>
