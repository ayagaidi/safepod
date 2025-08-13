@extends('front.app')
@section('content')
@section('title', __('menu.category') )
<section id="subscribe" class="container-grid padding-large position-relative overflow-hidden">
    <div class="container">
      <div class="row">
        <div class="subscribe-content d-flex flex-wrap justify-content-center align-items-center ">
          <div class="col-md-12 col-sm-12">
            <div class="display-header pe-3" style="text-align: center">
                <h3 style="color: #717171;">@lang('menu.category')</h3>
                       </div>
          </div>
         
        </div>
      </div>
    </div>
  </section>
<section id="mobile-products" class="product-store position-relative padding-large no-padding-top">
    <div class="container">
      <div class="row">
        
        <div class="swiper product-swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
          <div class="swiper-wrapper" id="swiper-wrapper-102dd5e6dd10d859d" aria-live="polite">
            <div class="swiper-slide swiper-slide-active" style="width: 315px; margin-right: 20px;" role="group" aria-label="1 / 5">
              <div class="product-card position-relative">
                <div class="image-holder">
                  <img src="images/product-item1.jpg" alt="product-item" class="img-fluid">
                </div>
                <div class="cart-concern position-absolute">
                  <div class="cart-button d-flex">
                    <a href="#" class="btn btn-medium btn-black">Add to Cart<svg class="cart-outline"><use xlink:href="#cart-outline"></use></svg></a>
                  </div>
                </div>
                <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                  <h3 class="card-title text-uppercase">
                    <a href="#">Iphone 10</a>
                  </h3>
                  <span class="item-price text-primary">$980</span>
                </div>
              </div>
            </div>
            <div class="swiper-slide swiper-slide-next" style="width: 315px; margin-right: 20px;" role="group" aria-label="2 / 5">
              <div class="product-card position-relative">
                <div class="image-holder">
                  <img src="images/product-item2.jpg" alt="product-item" class="img-fluid">
                </div>
                <div class="cart-concern position-absolute">
                  <div class="cart-button d-flex">
                    <a href="#" class="btn btn-medium btn-black">Add to Cart<svg class="cart-outline"><use xlink:href="#cart-outline"></use></svg></a>
                  </div>
                </div>
                <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                  <h3 class="card-title text-uppercase">
                    <a href="#">Iphone 11</a>
                  </h3>
                  <span class="item-price text-primary">$1100</span>
                </div>
              </div>
            </div>
            <div class="swiper-slide" style="width: 315px; margin-right: 20px;" role="group" aria-label="3 / 5">
              <div class="product-card position-relative">
                <div class="image-holder">
                  <img src="images/product-item3.jpg" alt="product-item" class="img-fluid">
                </div>
                <div class="cart-concern position-absolute">
                  <div class="cart-button d-flex">
                    <a href="#" class="btn btn-medium btn-black">Add to Cart<svg class="cart-outline"><use xlink:href="#cart-outline"></use></svg></a>
                  </div>
                </div>
                <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                  <h3 class="card-title text-uppercase">
                    <a href="#">Iphone 8</a>
                  </h3>
                  <span class="item-price text-primary">$780</span>
                </div>
              </div>
            </div>
            <div class="swiper-slide" style="width: 315px; margin-right: 20px;" role="group" aria-label="4 / 5">
              <div class="product-card position-relative">
                <div class="image-holder">
                  <img src="images/product-item4.jpg" alt="product-item" class="img-fluid">
                </div>
                <div class="cart-concern position-absolute">
                  <div class="cart-button d-flex">
                    <a href="#" class="btn btn-medium btn-black">Add to Cart<svg class="cart-outline"><use xlink:href="#cart-outline"></use></svg></a>
                  </div>
                </div>
                <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                  <h3 class="card-title text-uppercase">
                    <a href="#">Iphone 13</a>
                  </h3>
                  <span class="item-price text-primary">$1500</span>
                </div>
              </div>
            </div>
            <div class="swiper-slide" style="width: 315px; margin-right: 20px;" role="group" aria-label="5 / 5">
              <div class="product-card position-relative">
                <div class="image-holder">
                  <img src="images/product-item5.jpg" alt="product-item" class="img-fluid">
                </div>
                <div class="cart-concern position-absolute">
                  <div class="cart-button d-flex">
                    <a href="#" class="btn btn-medium btn-black">Add to Cart<svg class="cart-outline"><use xlink:href="#cart-outline"></use></svg></a>
                  </div>
                </div>
                <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                  <h3 class="card-title text-uppercase">
                    <a href="#">Iphone 12</a>
                  </h3>
                  <span class="item-price text-primary">$1300</span>
                </div>
              </div>
            </div>
          </div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
      </div>
    </div>
    <div class="swiper-pagination position-absolute text-center swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span></div>
  </section>
@endsection
