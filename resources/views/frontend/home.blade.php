@extends('frontend.layouts.main')
@section('content')
    <!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1">
            <div class="slick1">
                <div class="item-slick1" style="background-image: url({{ asset('frontend/images/slide-01.jpg') }});">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Women Collection 2018
								</span>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                    NEW SEASON
                                </h2>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                <a href="product.html"
                                   class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-slick1" style="background-image: url({{ asset('frontend/images/slide-02.jpg') }});">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Men New-Season
								</span>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn"
                                 data-delay="800">
                                <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                    Jackets & Coats
                                </h2>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
                                <a href="product.html"
                                   class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-slick1" style="background-image: url({{ asset('frontend/images/slide-03.jpg') }});">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft"
                                 data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Men Collection 2018
								</span>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight"
                                 data-delay="800">
                                <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                    New arrivals
                                </h2>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
                                <a href="product.html"
                                   class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner -->
    <div class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container">
            <div class="row">
                @if(getCategoryHome()->isNotEmpty())
                    @foreach(getCategoryHome() as  $category)
                        <div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
                            <!-- Block1 -->
                            <div class="block1 wrap-pic-w">
                                @if($category->image != "")
                                    <img src="{{ asset('uploads/category/thumb/'.$category->image ) }}"
                                         alt="IMG-BANNER">
                                @endif
                                <a href="product.html"
                                   class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                                    <div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{ $category->name }}
								</span>

                                        <span class="block1-info stext-102 trans-04">
									Spring 2018
								</span>
                                    </div>

                                    <div class="block1-txt-child2 p-b-4 trans-05">
                                        <div class="block1-link stext-101 cl0 trans-09">
                                            Shop Now
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


    <!-- Product -->
    <section class="bg0 p-t-23 p-b-140">
        @if(getProductByCategory()->isNotEmpty())
            @foreach(getProductByCategory() as  $category)
                <div class="container">
                    <div class="p-b-10">
                        <h3 class="ltext-101 cl5">
                            {{ $category->name }}
                        </h3>
                    </div>
                    <div class="row">
                        @if($category->product->isNotEmpty())
                            @foreach($category->product as $product)
                                @php
                                    $productImagee = $product->productImage->first()
                                @endphp
                                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 ">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            @if(!empty($productImagee))
                                                   <img src="{{ asset('uploads/products/small/'.$productImagee->image ) }}"
                                                         alt="IMG-PRODUCT">
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
                        <!-- Load more -->
                            <div class="flex-c-m flex-w w-full p-t-0">
                                <a href="{{ route('product-list.filter', $category->slug)}}" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                                    Xem tất cả
                                </a>
                            </div>
                    </div>
                    @endif
                </div>
            @endforeach
        @endif
        <div class="container">
        </div>
    </section>
@endsection
