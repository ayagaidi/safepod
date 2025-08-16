@extends('front.app')
@section('title', __('navbar.discountprodact'))
@section('content')

<div class="kids-theme">
    <div id="menu-department-block" class="menu-department-block relative h-full hidden"></div>

    {{-- Breadcrumb --}}
    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[124px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">{{ __('products.discountprodact') }}</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('/') }}" class="hover:underline">{{ __('products.home') }}</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <div class="text-secondary2 capitalize">{{ __('products.discountprodact') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel أبيض يحتوي السايدبار + الجريد --}}
    <div class="shop-product breadcrumb1 lg:py-14 md:py-10 py-8">
        <div class="container">
            <div class="kids-panel">
                <div class="flex max-md:flex-wrap max-md:flex-col-reverse gap-y-8">

                    {{-- Sidebar --}}
                    <aside class="sidebar lg:w-1/4 md:w-1/3 w-full md:pr-6 md:pl-6">
                        <section class="kid-card">
                            <div class="heading6">{{ __('menu.categories') }}</div>
                            <div class="list-type filter-type menu-tab mt-4">
                                @foreach ($categories as $category)
                                    <div class="item tab-item flex items-center justify-between cursor-pointer gap-2 py-2" data-item="{{ $category->id }}">
                                        <a href="{{ route('products/discount', ['category_id' => $category->id]) }}" class="flex items-center gap-3">
                                            <span class="thumb-ico">
                                                <img src="{{ asset('images/category/' . ($category->image ?? 'default.png')) }}" alt="image" loading="lazy">
                                            </span>
                                            @if (App::getLocale() == 'ar')
                                                <span class="type-name">{{ $category->name ?? __('products.unknown_category') }}</span>
                                            @else
                                                <span class="type-name">{{ $category->englishname ?? __('products.unknown_category') }}</span>
                                            @endif
                                        </a>
                                        <span class="number">{{ $category->products_count ?? 0 }}</span>
                                    </div>
                                @endforeach

                                <div class="item tab-item flex items-center justify-between cursor-pointer gap-2 py-2">
                                    <a href="{{ route('products/discount') }}" class="flex items-center gap-3">
                                        <span class="thumb-ico"><img src="{{ asset('carall.png') }}" alt="" loading="lazy"></span>
                                        <span class="type-name">@lang('products.productsall')</span>
                                    </a>
                                    <span class="number">{{ $categoriesproducts }}</span>
                                </div>
                            </div>
                        </section>

                        <section class="kid-card mt-6">
                            <div class="heading6">{{ __('products.size') }}</div>
                            <div class="list-size flex flex-wrap gap-2 mt-4">
                                @foreach ($sizes as $size)
                                    <a href="{{ route('products/discount', ['size_id' => $size->id]) }}" class="kid-chip">{{ $size->name ?? __('products.unknown_size') }}</a>
                                @endforeach
                            </div>
                        </section>

                        <section class="kid-card mt-6">
                            <div class="heading6">{{ __('products.brands') }}</div>
                            <div class="list-brand mt-3 space-y-2">
                                @foreach ($brands as $brand)
                                    <div class="brand-item flex items-center justify-between" data-item="{{ $brand->brandname }}">
                                        <a href="{{ route('products/discount', ['brand' => $brand->brandname]) }}" class="brand-link">{{ $brand->brandname }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="kid-card mt-6">
                            <div class="heading6">{{ __('products.colors') }}</div>
                            <div class="list-color flex flex-wrap gap-2 mt-3">
                                @foreach ($colors as $color)
                                    <a href="{{ route('products/discount', ['grades_id' => $color->id]) }}" class="kid-color" data-item="{{ $color->name }}">
                                        <span class="dot" style="background-color: {{ $color->name }}"></span>
                                        <span id="color-name-{{ $loop->index }}">
                                            {{ App::getLocale() == 'ar' ? $color->arabic_name ?? ($color->name ?? 'جارٍ التحميل...') : $color->name ?? 'Loading...' }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    </aside>

                    {{-- Content / grid --}}
                    <section class="list-product-block style-grid lg:w-3/4 md:w-2/3 w-full md:pl-3 lg:ml-4 md:ml-3 ml-2">
                        <div class="toolbar">
                            <div class="view-icons">
                                <span class="btn-icon active"><i class="ph ph-grid-four"></i></span>
                                <span class="btn-icon"><i class="ph ph-list"></i></span>
                            </div>
                            <div class="sort-product flex items-center gap-2">
                                <label for="select-filter" class="caption1">{{ __('products.sort_by') }}</label>
                                <div class="select-block relative">
                                    <select id="select-filter" name="sort" class="kid-select" onchange="location = this.value;">
                                        <option value="{{ route('products/discount') }}" {{ request('sort') == null ? 'selected' : '' }}>{{ __('products.sort_by') }}</option>
                                        <option value="{{ route('products/discount', ['sort' => 'priceHighToLow']) }}" {{ request('sort') == 'priceHighToLow' ? 'selected' : '' }}>{{ __('products.price_high_to_low') }}</option>
                                        <option value="{{ route('products/discount', ['sort' => 'priceLowToHigh']) }}" {{ request('sort') == 'priceLowToHigh' ? 'selected' : '' }}>{{ __('products.price_low_to_high') }}</option>
                                    </select>
                                </div>
                            </div>
                            <a href="#" class="compare-pill">{{ __('products.compare') ?? 'Compare' }}</a>
                        </div>

                        <div class="list-product grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6 sm:gap-8 mt-6" data-item="9">
                            @foreach ($products as $product)
                                @php
                                    $discountt = $discount->where('products_id', $product->id)->first();
                                    $discountedPrice = $discountt ? $product->price - ($product->price * $discountt->percentage) / 100 : null;
                                    $productSizes = $sizes->where('products_id', $product->id);
                                    $productGrades = $grades->where('products_id', $product->id);
                                @endphp

                                <a href="{{ route('product/info', encrypt($product->id)) }}"
                                   class="kid-card product-card group"
                                   data-item="149" data-brand-id="{{ $product->brand_id }}">

                                    {{-- Badge (Sale) --}}
                                    @if ($discountt)
                                        <span class="ribbon ribbon-green">{{ __('products.discount') }} - {{ $discountt->percentage }}%</span>
                                    @else
                                        <span class="ribbon ribbon-orange">{{ __('products.new') ?? 'NEW' }}</span>
                                    @endif

                                    <div class="img-wrap">
                                        <img class="product-image" src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                                    </div>

                                    <div class="product-infor text-center mt-3">
                                        <span class="brand">{{ $product->brandname }}</span>

                                        @if (App::getLocale() == 'ar')
                                            <div class="title" lang="{{ app()->getLocale() }}">{{ $product->name ?? __('products.unknown_product') }}</div>
                                        @else
                                            <div class="title" lang="{{ app()->getLocale() }}">{{ $product->namee ?? __('products.unknown_product') }}</div>
                                        @endif

                                        <div class="price-row">
                                            @if ($discountt)
                                                <span class="price-old">{{ number_format($product->price,2) }} {{ __('products.lyd') }}</span>
                                                <span class="price-new">{{ number_format($discountedPrice,2) }} {{ __('products.lyd') }}</span>
                                            @else
                                                <span class="price-new">{{ number_format($product->price,2) }} {{ __('products.lyd') }}</span>
                                            @endif
                                        </div>

                                        @if($productSizes->count())
                                            <div class="sizes">
                                                @foreach ($productSizes as $size)
                                                    <span>{{ $size->name }}</span>@if (!$loop->last),@endif
                                                @endforeach
                                            </div>
                                        @endif

                                        @if($productGrades->count())
                                            <div class="grades">
                                                @foreach ($productGrades as $grade)
                                                    <span class="chip" style="border-color: {{ $grade->name }}">{{ $grade->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <button class="quick-view-btn" aria-label="@lang('products.view')">
                                        <span>@lang('products.view')</span>
                                        <i class="ph ph-eye text-sm"></i>
                                    </button>
                                </a>
                            @endforeach
                        </div>

                        <div class="pagination-container my-6">
                            {{ $products->links() }}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- نفس سكريبتات الخفيفة (المنطق محفوظ) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuBlock = document.getElementById('menu-department-block');
    if (menuBlock) menuBlock.classList.toggle('hidden');

    // أسماء الألوان بالـ API (إن كانت HEX)
    document.querySelectorAll('.kid-color').forEach((el, idx) => {
        const code = (el.getAttribute('data-item') || '').replace(/\s+/g,'');
        const nameEl = document.getElementById('color-name-' + idx);
        if (!nameEl || !code.startsWith('#')) return;
        fetch(`https://www.thecolorapi.com/id?hex=${code.substring(1)}`)
            .then(r=>r.json())
            .then(d=>{ if(d?.name?.value) nameEl.textContent = d.name.value; })
            .catch(()=>{});
    });

    // لايت بوكس بسيط للصورة
    document.querySelectorAll('.product-image').forEach(img=>{
        img.addEventListener('click', e=>{
            e.preventDefault();
            document.querySelector('.image-overlay')?.remove(); // يمنع التكرار
            const ov = document.createElement('div');
            ov.className = 'image-overlay';
            ov.innerHTML = `
                <div class="overlay-content">
                    <button class="close-overlay" aria-label="Close">&times;</button>
                    <img src="${img.src}" class="enlarged-image" alt="">
                </div>`;
            document.body.appendChild(ov);
            ov.querySelector('.close-overlay').onclick = ()=> ov.remove();
            ov.addEventListener('click', ev => { if (ev.target === ov) ov.remove(); });
        });
    });
});
</script>

{{-- سكين CSS (نفس صفحة المنتجات) --}}
<style>
/* خلفية مثل الصورة */
.kids-theme{ background:#bff4f4; }

/* بانيل أبيض مستدير حول المحتوى */
.kids-panel{
  background:#fff; border-radius:16px; padding:18px;
  box-shadow:0 10px 30px rgba(16,24,40,.08);
}

/* بطاقات السايدبار والمنتجات */
.kid-card{
  background:#fff; border:1px solid #e9eef3; border-radius:16px; padding:16px;
  box-shadow:0 6px 16px rgba(16,24,40,.06);
}

/* أيقونة مصغرة في اللست */
.thumb-ico{display:inline-grid; place-items:center; width:34px; height:34px; border-radius:8px; overflow:hidden; border:1px solid #eef2f6; background:#fafcff}
.thumb-ico img{width:100%; height:100%; object-fit:cover}
.type-name{color:#344054; font-weight:600}
.number{color:#98a2b3; font-size:.85rem}

/* شيبس وأزرار صغيرة */
.kid-chip{
  display:inline-flex; align-items:center; justify-content:center; height:36px; padding:0 14px;
  border:1px solid #e4e7ec; border-radius:999px; background:#fff; color:#0f172a; font-weight:600;
}
.kid-chip:hover{border-color:#111827}

/* روابط الماركات */
.brand-link{color:#0f172a; font-weight:600}
.brand-link:hover{text-decoration:underline}

/* عنصر اللون */
.kid-color{display:inline-flex; align-items:center; gap:8px; padding:6px 10px; border:1px solid #e4e7ec; border-radius:999px; background:#fff; color:#0f172a}
.kid-color .dot{width:18px; height:18px; border-radius:999px; border:1px solid #e5e7eb}
.kid-color:hover{border-color:#0ea5e9}

/* شريط الأدوات */
.toolbar{
  display:flex; align-items:center; justify-content:space-between; gap:8px; flex-wrap:wrap; margin-bottom:8px
}
.view-icons{display:flex; gap:6px}
.btn-icon{display:inline-grid; place-items:center; width:36px; height:36px; border-radius:10px; background:#fff; border:1px solid #e7ebf0}
.btn-icon.active{background:#ff4f84; color:#fff; border-color:#ff4f84}
.kid-select{
  appearance:none; background:#fff; border:1px solid #e7ebf0; border-radius:10px; height:38px; padding:0 40px 0 12px; font-weight:600
}
.compare-pill{
  display:inline-flex; align-items:center; gap:6px; height:38px; padding:0 14px; border-radius:999px;
  background:#ff4f84; color:#fff; font-weight:700; text-decoration:none
}

/* كرت المنتج */
.product-card{position:relative; padding:14px}
.product-card .img-wrap{
  width:100%; aspect-ratio:1/1; border-radius:14px; overflow:hidden;
  border:1px solid #e9eef3; background:#fff;
}
.product-card .img-wrap img{width:100%; height:100%; object-fit:contain; transition:transform .25s ease}
.product-card:hover .img-wrap img{transform:scale(1.06)}

.product-infor .brand{display:block; color:#98a2b3; text-transform:uppercase; font-size:.8rem; letter-spacing:.02em}
.product-infor .title{margin-top:6px; color:#0f172a; font-weight:700}
.price-row{margin-top:8px; display:flex; align-items:center; justify-content:center; gap:8px}
.price-new{color:#0ea5e9; font-weight:800}
.price-old{color:#98a2b3; text-decoration:line-through}

/* جريد المقاسات ودرجات اللون */
.sizes{margin-top:8px; color:#667085; font-size:.9rem}
.grades{margin-top:8px; display:flex; gap:6px; justify-content:center; flex-wrap:wrap}
.grades .chip{display:inline-flex; align-items:center; justify-content:center; min-width:28px; height:28px; padding:0 8px; border:2px solid; border-radius:8px; font-size:.75rem; color:#0f172a; background:#fff}

/* زر View */
.quick-view-btn{
  margin-top:12px; width:100%; height:38px; border-radius:10px; background:#00c2a8; color:#fff; font-weight:700; border:0;
  display:inline-flex; align-items:center; justify-content:center; gap:8px; transition:transform .15s ease, opacity .15s ease
}
.quick-view-btn:hover{transform:translateY(-2px); opacity:.95}

/* Ribbons */
.ribbon{
  position:absolute; top:10px; left:-6px; padding:6px 10px; color:#fff; font-size:.75rem; font-weight:800;
  border-top-right-radius:999px; border-bottom-right-radius:999px; box-shadow:0 10px 20px rgba(0,0,0,.12)
}
.ribbon::after{content:""; position:absolute; inset:auto auto -6px 0; border:6px solid transparent; border-left-color:rgba(0,0,0,.18)}
.ribbon-orange{background:#ff9f1c}
.ribbon-green{background:#00c853}

/* لايت بوكس للصورة */
.image-overlay{position:fixed; inset:0; background:rgba(0,0,0,.85); display:flex; align-items:center; justify-content:center; z-index:1000}
.overlay-content{position:relative; max-width:min(92vw,1100px); max-height:90vh}
.enlarged-image{width:100%; height:auto; border-radius:14px}
.close-overlay{position:absolute; top:8px; right:8px; background:#fff; border:none; width:40px; height:40px; border-radius:999px; font-size:20px; cursor:pointer}
.close-overlay:hover{background:#ef4444; color:#fff}
</style>
@endsection
