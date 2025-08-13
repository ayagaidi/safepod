@extends('layouts.app')
@section('title', 'الرئيسية')

@section('content')
<style>
    /* تصميم زر 3D */
    .btn-3d {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 5px 5px 15px #bebebe, -5px -5px 15px #ffffff;
        text-decoration: none;
        font-weight: bold;
        color: #333;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    /* تأثير النقر */
    .btn-3d:active {
        box-shadow: inset 5px 5px 10px #bebebe, inset -5px -5px 10px #ffffff;
        transform: translateY(4px);
    }

    /* أيقونات الأزرار */
    .btn-3d .icon {
        width: 80px;
        transition: transform 0.3s ease;
    }

    /* تأثير عند تمرير الماوس */
    .btn-3d:hover .icon {
        transform: scale(1.1);
    }

    /* تحسين النص */
    .btn-3d span {
        margin-top: 10px;
        font-size: 16px;
    }
</style>
    <!-- Main Section -->
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content ">
                <h4 class="box-title">
                    <a href="{{ route('home') }}">الرئيسية</a>
                </h4>
            </div>
        </div>
      
        <div class="col-md-12">
            <div class="box-content">
                <div class="col-md-12">
                   
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{ route('categories.index') }}" class="btn-3d">
                            <img class="icon" src="{{ asset('categories.png') }}" alt="categories">
                            <span>التصنيفات</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('products')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('products.png') }}" alt="products">
                            <span>المنتجات</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('stock')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('stock.png') }}" alt="stock">
                            <span>ادارة المخزون</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('receipts')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('receipts.png') }}" alt="receipts">
                            <span>ادارة اذن  الاستلام</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box-content">
                <div class="col-md-12">
                   
                  
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('discounts')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('discounts.png') }}" alt="discounts">
                            <span>التخفيضات</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('ordersindex')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('request.png') }}" alt="returns">
                            <span>ادارة الطلبات</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('exchange')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('exchange.png') }}" alt="exchange">
                            <span>ادارة المبيعات  </span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('returns')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('return(1).png') }}" alt="returns">
                            <span>ادارة الرواجع</span>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box-content">
                <div class="col-md-12">
                   
                  
                                
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('report/all')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('report.png') }}" alt="report">
                            <span>ادراة التقارير</span>
                        </a>
                    </div>

                   
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('sitesetting')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('app-development.png') }}" alt="sitesetting">
                            <span>اعدادات الموقع</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{route('inbox')}}" class="btn-3d">
                            <img class="icon" src="{{ asset('inbox.png') }}" alt="inbox">
                            <span>البريد</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-4">
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="btn-3d">
                            <img class="icon" src="{{ asset('logout.png') }}" alt="logout">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <span>تسجيل خروج</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
     
    </div>
   



   
    </div>

@endsection
