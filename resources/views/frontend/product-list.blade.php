@extends('frontend.layouts.main')
@section('content')
    <div class="bg0 m-t-23 p-b-140 p-t-80 product-list">

        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <div class="sub-title text-center p-b-0">
                        <h2 class="font-weight-bold">{{ !empty($title) ? $title : "All Product"  }}</h2>
                    </div>
                </div>

                <div class="flex-w flex-c-m m-tb-10">

                    <div
                        class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search m-r-8">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Search
                    </div>
                    <div
                        class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Filter
                    </div>
                    <div
                        class="flex-c-m stext-106 cl6 size-104 bor4 pointer js-show-sort">
                        <!-- Sort -->
                        <select id="selectSort" class="form-select" name="sort">
                            <option selected>Sort by</option>
                            <option {{ $sort == 'new-product' ? 'selected' : '' }} value="new-product">Sản phẩm mới</option>
                            <option {{ $sort == 'price-high-to-low' ? 'selected' : '' }} value="price-high-to-low">Giá từ cao đến thấp</option>
                            <option {{ $sort == 'price-low-to-high' ? 'selected' : '' }} value="price-low-to-high">Giá từ thấp đến cao</option>
                            <option {{ $sort == 'name-a-z' ? 'selected' : '' }} value="name-a-z">Tên A-Z</option>
                            <option {{ $sort == 'name-z-a' ? 'selected' : '' }} value="name-z-a">Tên Z-A</option>
                        </select>
                    </div>

                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">
                        <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                            <i class="zmdi zmdi-search"></i>
                        </button>

                        <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
                               placeholder="Search">
                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                        <div class="filter-col1 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Category
                            </div>
                            <ul>
                                @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                        <li class="p-b-6">
                                            <a href="{{ route('product-list.filter',$category->slug) }}"
                                               class="filter-link stext-106 trans-04">
                                                {{ $category->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                <li class="p-b-6">
                                    <a href="{{ route('product-list') }}"
                                       class="filter-link stext-106 trans-04">
                                        All product
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="filter-col2 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Price
                            </div>

                            <input type="text" class="js-range-slider" name="my_range" value=""/>
                        </div>

                        <div class="filter-col3 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Color
                            </div>

                            <ul>
                                @if($colors->isNotEmpty())
                                    @foreach($colors as $color)
                                        <li class="p-b-6">
                                            <span class="fs-15 lh-12 m-r-6"
                                                  style="color: {{ $color->code }};">
                                                <i class="zmdi zmdi-circle"></i>
                                            </span>
                                            <a href="{{ Request::url() }}?color={{ $color->id }}"
                                               class="filter-link stext-106 trans-04">
                                                {{ $color->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="filter-col4 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Tags
                            </div>

                            <div class="flex-w p-t-4 m-r--5">
                                <a href="#"
                                   class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Fashion
                                </a>

                                <a href="#"
                                   class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Lifestyle
                                </a>

                                <a href="#"
                                   class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Denim
                                </a>

                                <a href="#"
                                   class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Streetstyle
                                </a>

                                <a href="#"
                                   class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Crafts
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                @if($products->isNotEmpty())
                    @foreach($products as $product)
                        @php
                            $productImagee = $product->productImage->first();
                        @endphp
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    @if(!empty($productImagee))
                                        <img src="{{ asset('uploads/products/small/'.$productImagee->image ) }}"
                                             alt="{{ asset('uploads/products/small/'.$productImagee->image ) }}">
                                    @else
                                        <img src="{{ asset('admin/img/default-150x150.png/') }}"
                                             class="img-thumbnail" width="50">
                                    @endif

                                    <a href="#"
                                       class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                        Quick View
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="{{ route('product-detail', $product->slug) }}"
                                           class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{ $product->title }}
                                        </a>

                                        <span class="stext-105 cl3">
                                             ${{ $product->price }}
                                        </span>
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04"
                                                 src="{{ asset('frontend/images/icons/icon-heart-01.png') }}"
                                                 alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                 src="{{ asset('frontend/images/icons/icon-heart-02.png') }}"
                                                 alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="container text-center">Không có sản phẩm nào</div>
                @endif
            </div>
            <!-- Load more -->
            <div class="flex-c-m flex-w w-full p-t-20 product-list-paginate">
                {{ $products->links() }}
            </div>
        </div>

    </div>

@endsection

@section('customJs')
    <script>
        rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: "double",
            grid: true,
            min: 0,
            max: 1000,
            step: 10,
            from: {{$priceMin}},
            to: {{$priceMax}},
            skin: "round",
            max_postfix: "+",
            prefix: "$",
            onFinish: function () {
                apply_filter();
            }
        });
        //saveing it's instance to var
        var slider = $(".js-range-slider").data("ionRangeSlider");

        $('#selectSort').change(function () {
            apply_filter();
        })
        function apply_filter() {
            var url = '{{ url()->current() }}?';
            url += '&price_min=' + slider.result.from + '&price_max=' + slider.result.to;

            //sort
            url += '&sort='+$('#selectSort').val();
            window.location.href = url.toString();
        }
    </script>
@endsection
