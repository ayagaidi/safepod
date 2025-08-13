<!DOCTYPE html>
@if (\Session::get('language') == 'ar')
    <html lang="ar" dir="rtl">
@elseif(\Session::get('language') == 'en')
    <html lang="en" dir="ltr">
@else
    <html lang="ar" dir="rtl">
@endif

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('colorico.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>safePod-@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('front/assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/dist/output-scss.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/dist/output-tailwind.css') }}" />
    <style>
        .whatsapp-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-image: url('{{ asset('whatsapp(1).png') }}');
            background-size: cover;
            background-position: center;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }



        .whatsapp-icon:hover {
            transform: scale(1.1);
        }

        .linkedin-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-image: url('{{ asset('linkedin.png') }}');
            background-size: cover;
            background-position: center;
            width: 15px;
            height: 15px;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
    </style>

    @if (\Session::get('language') == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
        </style>
    @elseif (\Session::get('language') == 'en')
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
        </style>
    @endif
</head>
@if (\Session::get('language') == 'ar')

    <body dir="rtl">
    @elseif(\Session::get('language') == 'en')

        <body dir="ltr">
        @else

            <body dir="rtl">
@endif

    @php
        $cartItems = session('cart_items', []);
    @endphp

    <div id="top-nav" class="top-nav bg-[#263587] md:h-[44px] h-[30px] border-b border-surface1">
        <div class="container mx-auto h-full">
            <div class="top-nav-main flex justify-between max-md:justify-center h-full">
                <div class="left-content flex items-center gap-5 max-md:hidden">
                    <div class="choose-type choose-language flex items-center gap-1.5">
                        <div class="select relative">
                            @if (\Session::get('language') == 'en')
                                <a class="nav-link me-4 flex items-center gap-1.5" style="color: white;"
                                    href="{{ route('changeLanguage', 'language=ar') }}">
                                    <img src="{{ asset('libya.png') }}" alt="AR Flag" class="w-5 h-5">
                                    العربية
                                </a>
                            @elseif (\Session::get('language') == 'ar')
                                <a class="nav-link me-4 flex items-center gap-1.5" style="color: white;"
                                    href="{{ route('changeLanguage', 'language=en') }}">
                                    <img src="{{ asset('united-kingdom.png') }}" alt="EN Flag" class="w-5 h-5">
                                    English
                                </a>
                            @else
                                <a class="nav-link me-4 flex items-center gap-1.5" style="color: white;"
                                    href="{{ route('changeLanguage', 'language=ar') }}">
                                    <img src="{{ asset('libya.png') }}" alt="AR Flag" class="w-5 h-5">
                                    العربية
                                </a>
                            @endif
                        </div>
                    </div>


                </div>
                <div class="text-center text-button-uppercase text-white flex items-center">
                    @if (!empty($salesbanners))
                        {{ \Session::get('language') == 'ar' ? $salesbanners->tilte : $salesbanners->tilten }}
                    @endif
                </div>
                <div class="right-content flex items-center gap-5 max-md:hidden">
                    <a href="{{ $facebook ?? '#' }}" target="_blank">
                        <i class="icon-facebook text-white"></i>
                    </a>
                    <a href="{{ $instagram ?? '#' }}" target="_blank">
                        <i class="icon-instagram text-white"></i>
                    </a>
                    <a href="{{ $youtube ?? '#' }}" target="_blank">
                        <i class="icon-youtube text-white"></i>
                    </a>
                    <a href="{{ $twitter ?? '#' }}" target="_blank">
                        <i class="icon-twitter text-white"></i>
                    </a>
                    <a href="{{ $pinterest ?? '#' }}" target="_blank">
                        <i class="icon-pinterest text-white"></i>
                    </a>
                    <a href="{{ $linkedin ?? '#' }}" target="_blank">
                        <i class="linkedin-icon text-white"></i>
                    </a>
                    <a href="https://wa.me/{{ $whatsapp ?? '#' }}" target="_blank">
                        <i class="whatsapp-icon text-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="header" class="relative w-full style-marketplace">
        <div class="header-menu style-marketplace relative bg-[#263587] w-full md:h-[74px] h-[56px]">
            <div class="container mx-auto h-full">
                <div class="header-main flex items-center justify-between h-full">
                    <div class="menu-mobile-icon lg:hidden flex items-center">
                        <i class="icon-category text-white text-2xl"></i>
                    </div>
                    <a href="{{ route('/') }}" class="flex items-center" style="width: 150px;">

                        <img src="{{ asset('mlogo.png') }}" alt="">

                    </a>
                        <form method="GET" class="form-search w-2/3 pl-8 flex items-center h-[44px] max-lg:hidden" action="{{ route('search') }}">
                            @csrf
                        <div class="w-full flex items-center h-full">
                            <input type="text" name="q" class="search-input h-full px-4 w-full border border-line rounded-l"
                                placeholder="{{ trans('menu.wh') }}" />
                            <button
                                class="search-button button-main bg-red text-white h-full flex items-center px-7 rounded-none rounded-r">{{ trans('menu.search') }}</button>
                        </div>
                       </form>
                    
                    <div class="right flex gap-12">
                        <div class="list-action flex items-center gap-4">

                            <div class="max-md:hidden cart-icon flex items-center relative cursor-pointer">
                                <a href="{{ route('cart.index') }}">
                                    <i class="ph-bold ph-handbag text-white text-2xl"></i>
                                    <span
                                        class="quantity cart-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-red w-4 h-4 flex items-center justify-center rounded-full">
                                        {{ count($cartItems) }}
                                      
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="top-nav-menu relative bg-white border-b border-line h-[44px] max-lg:hidden z-10">
            <div class="container h-full">
                <div class="top-nav-menu-main flex items-center justify-between h-full">
                    <div class="left flex items-center h-full">
                        <div class="menu-department-block relative h-full" id="menu-department-block"
                            style="display: none">
                            <div
                                class="menu-department-btn relative flex items-center sm:gap-24 gap-4 h-full w-fit cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <i class="ph ph-list text-xl max-sm:text-base"></i>
                                    <div class="text-button whitespace-nowrap">{{ trans('menu.category') }}</div>
                                </div>
                                <i class="ph ph-caret-down text-xl max-sm:text-base"></i>
                            </div>
                            <div
                                class="sub-menu-department style-marketplace absolute top-[84px] left-0 right-0 px-[26px] py-[5px] bg-surface rounded-xl border border-line open">


                                @if ($categories)
                                    @foreach ($categories as $item)
                                        <a href="{{ route('product/category', encrypt($item->id)) }}"
                                            class="item py-3 whitespace-nowrap border-b border-line w-full flex items-center justify-between">
                                            <span class="flex items-center gap-2">
                                                <img src="{{ asset('images/category/' . $item->image) }}"
                                                    alt="Category Image" class="clickable-image w-6 h-6 object-contain">
                                                <span class="">
                                                    {{ \Session::get('language') == 'ar' ? $item->name : $item->englishname }}
                                                </span>
                                            </span>
                                            <i class="ph-bold ph-caret-right"></i>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="text-secondary text-center py-3">{{ trans('menu.no_categories') }}</p>
                                @endif


                            </div>
                        </div>
                        <div class="menu-main style-eight h-full pl-12 max-lg:hidden">
                            <ul class="flex items-center gap-8 h-full">

                                <li class="h-full">
                                    <a href="{{ route('/') }}"
                                        class="text-button-uppercase duration-300 h-full flex items-center justify-center">
                                        {{ trans('menu.home') }} </a>

                                </li>
                                <li class="h-full">
                                    <a href="{{ route('about') }}"
                                        class="text-button-uppercase duration-300 h-full flex items-center justify-center">
                                        {{ trans('menu.who_we_are') }} </a>

                                </li>
                                <li class="h-full">
                                    <a href="{{ route('all_products') }}"
                                        class="text-button-uppercase duration-300 h-full flex items-center justify-center">
                                        {{ trans('menu.product') }} </a>

                                </li>
                                <li class="h-full">
                                    <a href="{{ route('products/discount') }}"
                                        class="text-button-uppercase duration-300 h-full flex items-center justify-center">
                                        {{ __('products.discountprodact') }}</a>

                                </li>
                                <li class="h-full relative">
                                    <a href="#!"
                                        class="text-button-uppercase duration-300 h-full flex items-center justify-center">
                                        {{ trans('menu.categories') }} </a>
                                    <div class="sub-menu py-3 px-7 -left-10 absolute bg-white rounded-b-xl">
                                        <ul class="w-full">
                                            @if ($categories)
                                                @foreach ($categories as $item)
                                                    <li>

                                                        <a href="{{ route('product/category', encrypt($item->id)) }}" class="link text-secondary duration-300">
                                                            <span class="flex items-center gap-2">
                                                                <img src="{{ asset('images/category/' . $item->image) }}"
                                                                    alt="Category Image"
                                                                    class="clickable-image w-6 h-6 object-contain">
                                                                <span class="">
                                                                    {{ \Session::get('language') == 'ar' ? $item->name : $item->englishname }}
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <p class="text-secondary text-center py-3">
                                                    {{ trans('menu.no_categories') }}</p>
                                            @endif


                                        </ul>
                                    </div>
                                </li>


                                <li class="h-full">
                                    <a href="{{ route('contacts') }}"
                                        class="text-button-uppercase duration-300 h-full flex items-center justify-center">
                                        {{ trans('menu.contact_us') }} </a>

                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="right flex items-center gap-1">
                               </div>
                </div>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="menu-mobile" class="">
            <div class="menu-container bg-white h-full">
                <div class="container h-full">
                    <div class="menu-main h-full">
                        <ul>
                            <li>
                                <a href="{{ route('/') }}" class="text-xl font-semibold flex items-center justify-between mt-5">
                                    {{ trans('menu.home') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}" class="text-xl font-semibold flex items-center justify-between mt-5">
                                    {{ trans('menu.who_we_are') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all_products') }}" class="text-xl font-semibold flex items-center justify-between mt-5">
                                    {{ trans('menu.product') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products/discount') }}" class="text-xl font-semibold flex items-center justify-between mt-5">
                                    {{ __('products.discountprodact') }}
                                </a>
                            </li>
                            <li class="relative">
                                <a href="#" class="text-xl font-semibold flex items-center justify-between mt-5">
                                    {{ trans('menu.categories') }}
                                    <i class="ph ph-caret-down text-xl"></i>
                                </a>
                                <ul class="sub-menu-mobile pl-4 mt-2">
                                    @if ($categories)
                                        @foreach ($categories as $item)
                                            <li>
                                                <a href="{{ route('product/category', encrypt($item->id)) }}" class="text-secondary duration-300 block py-2">
                                                    {{ \Session::get('language') == 'ar' ? $item->name : $item->englishname }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <p class="text-secondary py-2">{{ trans('menu.no_categories') }}</p>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('contacts') }}" class="text-xl font-semibold flex items-center justify-between mt-5">
                                    {{ trans('menu.contact_us') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu bar -->
        <div class="menu_bar fixed bg-white bottom-0 left-0 w-full h-[70px] sm:hidden z-[101]">
            <div class="menu_bar-inner grid grid-cols-4 items-center h-full">
                <a href="{{route('/')}}" class="menu_bar-link flex flex-col items-center gap-1">
                    <span class="ph-bold ph-house text-2xl block"></span>
                    <span class="menu_bar-title caption2 font-semibold">{{ trans('menu.home') }}</span>
                </a>
             
                <a href="" class="menu_bar-link flex flex-col items-center gap-1">
                    <span class="ph-bold ph-magnifying-glass text-2xl block"></span>
                    <span class="menu_bar-title caption2 font-semibold">{{ trans('menu.search') }}</span>
                </a>
            
                <a href="{{ route('cart.index') }}" class=" menu_bar-link flex flex-col items-center gap-1">
                    <div class="cart-icon relative">
                        <span class="ph-bold ph-handbag text-2xl block"></span>
                        <span class="quantity cart-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">
                            {{count($cartItems) }}
                        </span>

                    </div>
                    <span class="menu_bar-title caption2 font-semibold">{{ trans('menu.cart') }}</span>
                </a>

                @if (\Session::get('language') == 'en')
                

                <a href="{{ route('changeLanguage', 'language=ar') }}" class="menu_bar-link flex flex-col items-center gap-1">
                    <span class="menu_bar-title caption2 font-semibold">   <img src="{{ asset('libya.png') }}" alt="AR Flag" class="w-5 h-5">
                        العربية</span>
                </a>
            @elseif (\Session::get('language') == 'ar')
            
                <a href="{{ route('changeLanguage', 'language=en') }}" class="menu_bar-link flex flex-col items-center gap-1">
                    <span class="menu_bar-title caption2 font-semibold">   <img src="{{ asset('united-kingdom.png') }}" alt="en Flag" class="w-5 h-5">
                        English</span>
                </a>
                   
                
            @else
            <a href="{{ route('changeLanguage', 'language=ar') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <span class="menu_bar-title caption2 font-semibold">   <img src="{{ asset('libya.png') }}" alt="AR Flag" class="w-5 h-5">
                    العربية</span>
            </a>
               
            @endif
            
            </div>
        </div>




    </div>

    @yield('content')



    <div class="container">
        <div class="benefit-block md:py-[60px] py-10 border-b border-line">
            <div class="list-benefit grid items-start lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-[30px]">
                <div style="color: #f78259;font-weight: bolder;text-align: center;"
                    class="benefit-item flex flex-col justify-center">
                    <i class="icon-phone-call lg:text-7xl text-5xl"></i>
                    <div class="heading6 mt-5">@lang('home.customer_service')</div>
                    <div class="caption1 text-secondary mt-3">@lang('home.customer_service_desc')</div>
                </div>
                <div style="color: #f78259;font-weight: bolder;text-align: center;"
                    class="benefit-item flex flex-col justify-center">
                    <i class="icon-return lg:text-7xl text-5xl"></i>
                    <div class="heading6 mt-5">@lang('home.money_back')</div>
                    <div class="caption1 text-secondary mt-3">@lang('home.money_back_desc')</div>
                </div>
                <div style="color: #f78259;font-weight: bolder;text-align: center;"
                    class="benefit-item flex flex-col justify-center">
                    <i class="icon-guarantee lg:text-7xl text-5xl"></i>
                    <div class="heading6 mt-5">@lang('home.guarantee')</div>
                    <div class="caption1 text-secondary mt-3">@lang('home.guarantee_desc')</div>
                </div>
                <div style="color: #f78259;font-weight: bolder;text-align: center;"
                    class="benefit-item flex flex-col justify-center">
                    <i class="icon-delivery-truck lg:text-7xl text-5xl"></i>

                    <div class="heading6 mt-5">@lang('home.shipping')</div>
                    <div class="caption1 text-secondary mt-3">@lang('home.shipping_desc')</div>
                </div>
            </div>
        </div>
    </div>


    <div id="footer" class="footer">
        <div class="footer-main bg-surface">
            <div class="container">

                <div
                    class="footer-bottom py-3 flex items-center justify-between gap-5 max-lg:justify-center max-lg:flex-col border-t border-line">
                    <div class="left flex items-center gap-8">
                        <div class="copyright caption1 text-secondary">©2024 Color Boutuque.
                            {{ trans('menu.all_rights_reserved') }}</div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top-btn" href="#top-nav"><i class="ph-bold ph-caret-up"></i></a>

    <div class="modal-search-block">
        <div class="modal-search-main md:p-10 p-6 rounded-[32px]">
            <div class="form-search relative w-full">
                <i class="ph ph-magnifying-glass absolute heading5 right-6 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                <input type="text" placeholder="{{ trans('menu.searching') }}"
                    class="text-button-lg h-14 rounded-2xl border border-line w-full pl-6 pr-12" />
            </div>
            <div class="keyword mt-8">
                <div class="heading5">{{ trans('menu.feature_keywords_today') }}</div>
                <div class="list-keyword flex items-center flex-wrap gap-3 mt-4">
                    <button
                        class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">{{ trans('menu.dress') }}</button>
                    <button
                        class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">{{ trans('menu.tshirt') }}</button>
                    <button
                        class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">{{ trans('menu.underwear') }}</button>
                    <button
                        class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">{{ trans('menu.top') }}</button>
                </div>
            </div>
            <div class="list-recent mt-8">
                <div class="heading6">{{ trans('menu.recently_viewed_products') }}</div>
                <div
                    class="list-product pb-5 hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 mt-4">
                    <div class="product-item grid-type" data-item="14">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div
                                    class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">
                                    {{ trans('menu.new') }}</div>
                                <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                                    <div
                                        class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">
                                            {{ trans('menu.add_to_wishlist') }}</div>
                                        <i class="ph ph-heart text-lg"></i>
                                    </div>
                                    <div
                                        class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">
                                            {{ trans('menu.compare_product') }}</div>
                                        <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                        <i class="ph ph-check-circle text-lg checked-icon"></i>
                                    </div>
                                </div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                   
                                </div>
                                <div
                                    class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                                    <div
                                        class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                        {{ trans('menu.quick_view') }}</div>
                                    <div
                                        class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white">
                                        {{ trans('menu.add_to_cart') }}</div>
                                </div>
                            </div>
                            <div class="product-infor mt-4 lg:mb-7">
                                <div class="product-sold sm:pb-4 pb-2">
                                    <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                        <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">{{ trans('menu.sold') }}:
                                            </span>
                                            <span class="max-sm:text-xs">12</span>
                                        </div>
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">{{ trans('menu.available') }}:
                                            </span>
                                            <span class="max-sm:text-xs">88</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-name text-title duration-300">Faux-leather trousers</div>
                                <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                                    <div class="color-item bg-black w-8 h-8 rounded-full duration-300 relative">
                                        <div
                                            class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                            {{ trans('menu.black') }}</div>
                                    </div>
                                    <div class="color-item bg-green w-8 h-8 rounded-full duration-300 relative">
                                        <div
                                            class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                            {{ trans('menu.green') }}</div>
                                    </div>
                                    <div class="color-item bg-red w-8 h-8 rounded-full duration-300 relative">
                                        <div
                                            class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                            {{ trans('menu.red') }}</div>
                                    </div>
                                </div>

                                <div
                                    class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">$40.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$50.00</del>
                                    </div>
                                    <div
                                        class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">
                                        -20%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-item grid-type" data-item="13">
                    <div class="product-main cursor-pointer block">
                        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                            <div
                                class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">
                                {{ trans('menu.new') }}</div>
                            <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                                <div
                                    class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.add_to_wishlist') }}</div>
                                    <i class="ph ph-heart text-lg"></i>
                                </div>
                                <div
                                    class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.compare_product') }}</div>
                                    <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                    <i class="ph ph-check-circle text-lg checked-icon"></i>
                                </div>
                            </div>
                            <div class="product-img w-full h-full aspect-[3/4]">
                              
                            </div>
                            <div
                                class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                                <div
                                    class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                    {{ trans('menu.quick_view') }}</div>
                                <div
                                    class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white">
                                    {{ trans('menu.add_to_cart') }}</div>
                            </div>
                        </div>
                        <div class="product-infor mt-4 lg:mb-7">
                            <div class="product-sold sm:pb-4 pb-2">
                                <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                    <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                                </div>
                                <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                    <div class="text-button-uppercase">
                                        <span class="text-secondary2 max-sm:text-xs">{{ trans('menu.sold') }}:
                                        </span>
                                        <span class="max-sm:text-xs">12</span>
                                    </div>
                                    <div class="text-button-uppercase">
                                        <span class="text-secondary2 max-sm:text-xs">{{ trans('menu.available') }}:
                                        </span>
                                        <span class="max-sm:text-xs">88</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-name text-title duration-300">Faux-leather trousers</div>
                            <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                                <div class="color-item bg-black w-8 h-8 rounded-full duration-300 relative">
                                    <div
                                        class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.black') }}</div>
                                    </div>
                                    <div class="color-item bg-green w-8 h-8 rounded-full duration-300 relative">
                                        <div
                                            class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                            {{ trans('menu.green') }}</div>
                                    </div>
                                    <div class="color-item bg-red w-8 h-8 rounded-full duration-300 relative">
                                        <div
                                            class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                            {{ trans('menu.red') }}</div>
                                    </div>
                                </div>

                                <div
                                    class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">$40.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$50.00</del>
                                    </div>
                                    <div
                                        class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">
                                        -20%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-item grid-type" data-item="12">
                    <div class="product-main cursor-pointer block">
                        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                            <div
                                class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">
                                {{ trans('menu.new') }}</div>
                            <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                                <div
                                    class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.add_to_wishlist') }}</div>
                                    <i class="ph ph-heart text-lg"></i>
                                </div>
                                <div
                                    class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.compare_product') }}</div>
                                    <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                    <i class="ph ph-check-circle text-lg checked-icon"></i>
                                </div>
                            </div>
                            <div class="product-img w-full h-full aspect-[3/4]">
                               
                            </div>
                            <div
                                class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                                <div
                                    class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                    {{ trans('menu.quick_view') }}</div>
                                <div
                                    class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white">
                                    {{ trans('menu.add_to_cart') }}</div>
                            </div>
                        </div>
                        <div class="product-infor mt-4 lg:mb-7">
                            <div class="product-sold sm:pb-4 pb-2">
                                <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                    <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                                </div>
                                <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                    <div class="text-button-uppercase">
                                        <span class="text-secondary2 max-sm:text-xs">{{ trans('menu.sold') }}:
                                        </span>
                                        <span class="max-sm:text-xs">12</span>
                                    </div>
                                    <div class="text-button-uppercase">
                                        <span class="text-secondary2 max-sm:text-xs">{{ trans('menu.available') }}:
                                        </span>
                                        <span class="max-sm:text-xs">88</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-name text-title duration-300">Off-the-Shoulder Blouse</div>
                            <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                                <div class="color-item bg-red w-8 h-8 rounded-full duration-300 relative">
                                    <div
                                        class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.red') }}</div>
                                </div>
                                <div class="color-item bg-yellow w-8 h-8 rounded-full duration-300 relative">
                                    <div
                                        class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.yellow') }}</div>
                                </div>
                                <div class="color-item bg-green w-8 h-8 rounded-full duration-300 relative">
                                    <div
                                        class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.green') }}</div>
                                </div>
                            </div>

                            <div
                                class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                <div class="product-price text-title">$40.00</div>
                                <div class="product-origin-price caption1 text-secondary2">
                                    <del>$50.00</del>
                                </div>
                                <div
                                    class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">
                                    -20%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-item grid-type" data-item="11">
                    <div class="product-main cursor-pointer block">
                        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                            <div
                                class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">
                                {{ trans('menu.new') }}</div>
                            <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                                <div
                                    class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.add_to_wishlist') }}</div>
                                    <i class="ph ph-heart text-lg"></i>
                                </div>
                                <div
                                    class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.compare_product') }}</div>
                                    <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                    <i class="ph ph-check-circle text-lg checked-icon"></i>
                                </div>
                            </div>
                            <div class="product-img w-full h-full aspect-[3/4]">
                              
                            </div>
                            <div
                                class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                                <div
                                    class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                    {{ trans('menu.quick_view') }}</div>
                                <div
                                    class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white">
                                    {{ trans('menu.add_to_cart') }}</div>
                            </div>
                        </div>
                        <div class="product-infor mt-4 lg:mb-7">
                            <div class="product-sold sm:pb-4 pb-2">
                                <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                    <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                                </div>
                                <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                    <div class="text-button-uppercase">
                                        <span class="text-secondary2 max-sm:text-xs">{{ trans('menu.sold') }}:
                                        </span>
                                        <span class="max-sm:text-xs">12</span>
                                    </div>
                                    <div class="text-button-uppercase">
                                        <span class="text-secondary2 max-sm:text-xs">{{ trans('menu.available') }}:
                                        </span>
                                        <span class="max-sm:text-xs">88</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-name text-title duration-300">Off-the-Shoulder Blouse</div>
                            <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                                <div class="color-item bg-red w-8 h-8 rounded-full duration-300 relative">
                                    <div
                                        class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.red') }}</div>
                                </div>
                                <div class="color-item bg-yellow w-8 h-8 rounded-full duration-300 relative">
                                    <div
                                        class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.yellow') }}</div>
                                </div>
                                <div class="color-item bg-green w-8 h-8 rounded-full duration-300 relative">
                                    <div
                                        class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">
                                        {{ trans('menu.green') }}</div>
                                </div>
                            </div>

                            <div
                                class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                <div class="product-price text-title">$40.00</div>
                                <div class="product-origin-price caption1 text-secondary2">
                                    <del>$50.00</del>
                                </div>
                                <div
                                    class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">
                                    -20%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .pagination {
        list-style: none;
        display: flex;
        justify-content: center;
        gap: 10px;
        margin: 20px 0;
    }
    .pagination li {
        display: inline-block;
    }
    .pagination li a, .pagination li span {
        background: #f5f5f5;
        border: 1px solid #ddd;
        padding: 8px 12px;
        color: #ef6170;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    .pagination li a:hover {
        background: #f78259;
        color: #fff;
    }
    .pagination li.active span {
        background: #f78259;
        color: #fff;
        border-color: #f78259;
    }
    .text-sel{
        color: #e54d61;
        font-weight: bold;
    }
</style>
<script src="{{ asset('front/assets/js/phosphor-icons.js') }}"></script>

<script src="{{ asset('front/assets/js/jquery.min.js') }}"></script>

<script src="{{ asset('front/assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('front/assets/js/main.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="{{ asset('dash/assets/plugin/sweet-alert/sweetalert.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const closeModalButton = document.querySelector('.close-modal');
        const modalNewsletter = document.querySelector('.modal-newsletter');

        if (closeModalButton && modalNewsletter) {
            closeModalButton.addEventListener('click', function () {
                modalNewsletter.style.display = 'none';
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const cartQuantityElements = document.querySelectorAll('.cart-quantity');
        // Fetch the cart items count from the server
        fetch('{{ route('cart.items.count') }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cartQuantityElements.forEach(el => {
                    el.textContent = data.count; // Update all cart quantity elements
                });
            }
        })
        .catch(error => {
            console.error('Error fetching cart count:', error);
        });
    });
</script>

</body>

</html>
