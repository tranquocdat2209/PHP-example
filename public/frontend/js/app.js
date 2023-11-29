var page = 2;

function toSlug(str) {
	// Chuyển hết sang chữ thường
	str = str.toLowerCase();

	// xóa dấu
	str = str
		.normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
		.replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp

	// Thay ký tự đĐ
	str = str.replace(/[đĐ]/g, 'd');

	// Xóa ký tự đặc biệt
	str = str.replace(/([^0-9a-z-\s])/g, '');

	// Xóa khoảng trắng thay bằng ký tự -
	str = str.replace(/(\s+)/g, '-');

	// Xóa ký tự - liên tiếp
	str = str.replace(/-+/g, '-');

	// xóa phần dư - ở đầu & cuối
	str = str.replace(/^-+|-+$/g, '');

	// return
	return str;
}

function loadMore(){
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/services/load-product',
        data: {page},
        success: function(res){
            if(res.error === false){
                if(res.products.length != 0){
                    page ++;
                    var html = '';
                    res.products.forEach(function(item){
                        html += `<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="${item.thumb}" alt="${item.title}">
                        
                                    <a href="#"
                                       class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                        Quick View
                                    </a>
                                </div>
                        
                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="/${toSlug(item.title)}-${item.id}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            Herschel supply
                                        </a>
                        
                                        <div class="stext-105 cl3">
<!--                                            <?= \\App\\Helpers\\Helper::handlePrice($product['price'], $product['price_sale'])?>-->
                                        </div>
                                    </div>
                        
                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04"
                                                 src="/template/frontend/images/icons/icon-heart-01.png" alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                 src="/template/frontend/images/icons/icon-heart-02.png" alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>`
                    })

                    $('#items-product').append(html);
                }else {
                    alert('Đã tải xong dữ liệu')
                }
            }
        }
    })
}

function quickView(id = 0){
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/services/quick-view',
        data: {id},
        success: function (res){
            if(res.error === false){
                var html = `<div class="container">
                        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                           <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                           <img src="/template/frontend/images/icons/icon-close.png" alt="CLOSE">
                           </button>
                           <div class="row">
                              <div class="col-md-6 col-lg-7 p-b-30">
                                 <div class="p-l-25 p-r-30 p-lr-0-lg">
                                    <div class="wrap-slick3 flex-sb flex-w">
                                       <div class="wrap-slick3-dots">
                                           <ul class="slick3-dots" role="tablist" style="">
                                              <li class="slick-active" role="presentation">
                                                 <img src="${res.products.thumb}">
                                                 <div class="slick3-dot-overlay"></div>
                                              </li>
                                              <li role="presentation">
                                                 <img src="${res.products.thumb}">
                                                 <div class="slick3-dot-overlay"></div>
                                              </li>
                                              <li role="presentation">
                                                 <img src="${res.products.thumb}">
                                                 <div class="slick3-dot-overlay"></div>
                                              </li>
                                           </ul>
                                       </div>
                                       <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                                       <div class="slick3 gallery-lb">
                                          <div class="item-slick3" data-thumb="images/product-detail-01.jpg">
                                             <div class="wrap-pic-w pos-relative">
                                                <img src="/template/frontend/images/product-detail-01.jpg" alt="IMG-PRODUCT">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                   href="/template/frontend/images/product-detail-01.jpg">
                                                <i class="fa fa-expand"></i>
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6 col-lg-5 p-b-30">
                                 <div class="p-r-50 p-t-5 p-lr-0-lg">
                                    <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                       Lightweight Jacket
                                    </h4>
                                    <span class="mtext-106 cl2">
                                    $58.79
                                    </span>
                                    <p class="stext-102 cl3 p-t-23">
                                       Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare
                                       feugiat.
                                    </p>
                                    <!--  -->
                                    <div class="p-t-33">
                                       <div class="flex-w flex-r-m p-b-10">
                                          <div class="size-203 flex-c-m respon6">
                                             Size
                                          </div>
                                          <div class="size-204 respon6-next">
                                             <div class="rs1-select2 bor8 bg0">
                                                <select class="js-select2" name="time">
                                                   <option>Choose an option</option>
                                                   <option>Size S</option>
                                                   <option>Size M</option>
                                                   <option>Size L</option>
                                                   <option>Size XL</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="flex-w flex-r-m p-b-10">
                                          <div class="size-203 flex-c-m respon6">
                                             Color
                                          </div>
                                          <div class="size-204 respon6-next">
                                             <div class="rs1-select2 bor8 bg0">
                                                <select class="js-select2" name="time">
                                                   <option>Choose an option</option>
                                                   <option>Red</option>
                                                   <option>Blue</option>
                                                   <option>White</option>
                                                   <option>Grey</option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="flex-w flex-r-m p-b-10">
                                          <div class="size-204 flex-w flex-m respon6-next">
                                             <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                   <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>
                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                   name="num-product" value="1">
                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                   <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                             </div>
                                             <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                             Add to cart
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                    <!--  -->
                                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                       <div class="flex-m bor9 p-r-10 m-r-11">
                                          <a href="#"
                                             class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                             data-tooltip="Add to Wishlist">
                                          <i class="zmdi zmdi-favorite"></i>
                                          </a>
                                       </div>
                                       <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                          data-tooltip="Facebook">
                                       <i class="fa fa-facebook"></i>
                                       </a>
                                       <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                          data-tooltip="Twitter">
                                       <i class="fa fa-twitter"></i>
                                       </a>
                                       <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                          data-tooltip="Google Plus">
                                       <i class="fa fa-google-plus"></i>
                                       </a>
                                    </div>
                                 </div>
                             </div>
                          </div>
                        </div>
                    </div>`
            }
             $('.wrap-modal1').append(html);
        }
    })
}