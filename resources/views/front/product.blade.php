@extends('front.app')

@section('title', trans('home.productinfo'))

@section('content')

<div class="pd-kids">
  <div class="featured-product countdown-timer underwear md:py-16 py-10">
    <div class="container">
      <div class="detail-shell">
        <div class="flex justify-between gap-6 flex-wrap">

          {{-- LEFT: Gallery --}}
          <div class="list-img md:w-1/2 w-full">
            <div class="sticky top-6">
              <div class="main-image">
                <img id="main-product-image"
                     src="{{ asset('images/product/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="hero-img">
              </div>

              <div class="gallery grid grid-cols-4 gap-3 mt-4">
                <img src="{{ asset('images/product/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="gallery-item"
                     onclick="changeMainImage(this)">

                @foreach ($imagesfiles as $image)
                  <img src="{{ asset('images/product/' . $image->name) }}"
                       alt="{{ $product->name }}"
                       class="gallery-item"
                       onclick="changeMainImage(this)">
                @endforeach
              </div>
            </div>
          </div>

          {{-- RIGHT: Info --}}
          <div class="product-infor md:w-1/2 w-full">
            <div class="info-card">
              <div class="flex items-start justify-between gap-3">
                <div class="brand-chip">{{ $product->brandname ?? '' }}</div>
              </div>

              @if (App::getLocale() == 'ar')
                <h1 class="title mt-2">{{ $product->name }}</h1>
              @else
                <h1 class="title mt-2">{{ $product->namee }}</h1>
              @endif

              {{-- price row --}}
              <div class="price-row">
                <div class="price-now">
                  @if ($discountedPrice)
                    {{ number_format($discountedPrice, 2) }} {{ __('products.lyd') }}
                  @else
                    {{ $product->price }} {{ __('products.lyd') }}
                  @endif
                </div>

                @if ($discountedPrice)
                  <div class="price-old">
                    <del>{{ $product->price }} {{ __('products.lyd') }}</del>
                  </div>
                  @if (isset($discount) && isset($discount->percentage))
                    <div class="badge-sale">-{{ $discount->percentage }}%</div>
                  @endif
                @endif
              </div>

              {{-- Colors --}}
              @if ($product->stocks->pluck('grades')->filter()->isNotEmpty())
                <div class="section mt-5">
                  <div class="section-title">@lang('products.colors'):</div>
                  <div class="list-color flex items-center gap-2 flex-wrap mt-2">
                    @foreach ($product->stocks->pluck('grades')->filter() as $grade)
                      <div class="color-item color-chip"
                           onclick="selectColor('{{ $grade->name }}')"
                           id="color-{{ $grade->name }}">
                        <span class="dot" style="background: {{ $grade->name }}"></span>
                        <span class="lbl">{{ $grade->name }}</span>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif

              {{-- Sizes --}}
              @if ($product->stocks->pluck('sizes')->filter()->isNotEmpty())
                <div class="section mt-5">
                  <div class="section-title">@lang('products.sizes'):</div>
                  <div class="list-size flex items-center gap-2 flex-wrap mt-2">
                    @foreach ($product->stocks->pluck('sizes')->filter() as $size)
                      <div class="size-item size-chip"
                           onclick="selectSize('{{ $size->name }}')"
                           id="size-{{ $size->name }}">
                        {{ $size->name }}
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif

              {{-- meta --}}
              <div class="meta mt-5 space-y-2">
                @if ($discountedPrice)
                  <div class="ok-row">@lang('products.discount_available')</div>
                @endif

                <div class="row">
                  <div class="key">@lang(App::getLocale()=='ar' ? 'products.code_ar' : 'products.code')</div>
                  <div class="val">{{ $product->barcode }}</div>
                </div>

                <div class="row">
                  <div class="key">@lang('products.categories')</div>
                  <div class="val">
                    @if (App::getLocale() == 'ar')
                      {{ $product->categories->name ?? __('products.unknown_category') }}
                    @else
                      {{ $product->categories->englishname ?? __('products.unknown_category') }}
                    @endif
                  </div>
                </div>
              </div>

              {{-- Quantity + Add to cart --}}
              <div class="actions mt-6">
                <div class="qty-wrap">
                  <button class="qty-btn" onclick="updateQuantity(-1)"><i class="ph-bold ph-minus"></i></button>
                  <div id="quantity" class="qty-val">1</div>
                  <button class="qty-btn" onclick="updateQuantity(1)"><i class="ph-bold ph-plus"></i></button>
                </div>

                <button class="add-cart-btn add-to-cart" onclick="addToCart()">
                  @lang('products.add_to_cart')
                </button>
              </div>
            </div>
          </div>

        </div>
      </div> {{-- /detail-shell --}}
    </div>
  </div>

  {{-- Related / grid --}}
  <div class="container">
    <div class="list-product grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 mt-6" data-item="9">
      @foreach ($products as $product)
        @php
          $discountt = $discount->where('products_id', $product->id)->first();
          $discountedPrice = $discountt ? $product->price - ($product->price * $discountt->percentage) / 100 : null;
          $productSizes = $sizes->where('products_id', $product->id);
          $productGrades = $grades->where('products_id', $product->id);
        @endphp

        <a href="{{ route('product/info', encrypt($product->id)) }}"
           class="kid-card product-card"
           data-item="149" data-brand-id="{{ $product->brand_id }}">

          @if ($discountt)
            <span class="ribbon ribbon-green">{{ __('products.discount') }} - {{ $discountt->percentage }}%</span>
          @else
            <span class="ribbon ribbon-orange">{{ __('products.new') ?? 'NEW' }}</span>
          @endif

          <div class="img-wrap">
            <img class="product-image" src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->name }}">
          </div>

          <div class="product-infor text-center mt-3">
            <span class="brand">{{ $product->brandname }}</span>
            <div class="title">{{ $product->name ?? __('products.unknown_product') }}</div>

            <div class="price-row center">
              @if ($discountt)
                <span class="price-old"><del>{{ number_format($product->price,2) }} {{ __('products.lyd') }}</del></span>
                <span class="price-now">{{ number_format($discountedPrice,2) }} {{ __('products.lyd') }}</span>
              @else
                <span class="price-now">{{ number_format($product->price,2) }} {{ __('products.lyd') }}</span>
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
                  <span class="dot" style="background: {{ $grade->name }}"></span>
                @endforeach
              </div>
            @endif
          </div>

          <button class="quick-view-btn">
            <span>@lang('products.view')</span>
            <i class="ph ph-eye text-sm"></i>
          </button>
        </a>
      @endforeach
    </div>
  </div>
</div>

{{-- نفس السكربتات لديك، بدون أي تغيير في المنطق --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  let selectedColor = null;
  let selectedSize  = null;

  var hasColor = {{ $product->stocks->pluck('grades')->filter()->isNotEmpty() ? 'true' : 'false' }};
  var hasSize  = {{ $product->stocks->pluck('sizes')->filter()->isNotEmpty() ? 'true' : 'false' }};

  function changeMainImage(el){
    const main = document.getElementById('main-product-image');
    if(!main) return;
    main.src = el.src;
    main.classList.add('fade');
    setTimeout(()=> main.classList.remove('fade'), 120);
  }

  function selectColor(color){
    selectedColor = color;
    document.querySelectorAll('.color-item').forEach(i=> i.classList.remove('is-selected','bg-gray-500','text-sel','border-gray-500'));
    const el = document.getElementById(`color-${color}`);
    if(el){ el.classList.add('is-selected','bg-gray-500','text-sel','border-gray-500'); }
    Swal.fire({toast:true,position:'top-end',icon:'success',title:'@lang('products.color_selected')',showConfirmButton:false,timer:1500});
  }

  function selectSize(size){
    selectedSize = size;
    document.querySelectorAll('.size-item').forEach(i=> i.classList.remove('is-selected','bg-gray-500','text-sel','border-gray-500'));
    const el = document.getElementById(`size-${size}`);
    if(el){ el.classList.add('is-selected','bg-gray-500','text-sel','border-gray-500'); }
    Swal.fire({toast:true,position:'top-end',icon:'success',title:'@lang('products.size_selected')',showConfirmButton:false,timer:1500});
  }

  function updateQuantity(delta){
    const q = document.getElementById('quantity');
    if(!q) return;
    let val = parseInt(q.textContent || '1', 10);
    val = Math.max(1, val + delta);
    q.textContent = val;
  }

  function addToCart(){
    if ((hasColor && !selectedColor) || (hasSize && !selectedSize)) {
      Swal.fire({icon:'warning',title:'@lang('products.select_color_or_size')',text:'@lang('products.please_select_color_or_size')'});
      return;
    }
    const quantity = parseInt(document.getElementById('quantity').textContent || '1', 10);

    fetch('{{ route('cart.store') }}', {
      method:'POST',
      headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
      body:JSON.stringify({ product_id:'{{ $product->id }}', color:selectedColor, size:selectedSize, quantity })
    })
    .then(r=>{ if(!r.ok) return r.text().then(t=>{ throw new Error(t || r.status) }); return r.json(); })
    .then(data=>{
      if(data.success){
        Swal.fire({toast:true,position:'top-end',icon:'success',title:'@lang('products.added_to_cart')',showConfirmButton:false,timer:1500});

        // (تصميم فقط – لم أغيّر المنطق) تحديث عداد السلة إن وُجد
        const cartQuantityElement = document.querySelector('.cart-quantity');
        if (cartQuantityElement) {
          const curr = parseInt(cartQuantityElement.textContent || '0', 10);
          cartQuantityElement.textContent = curr + quantity;
        }
      }else{
        Swal.fire({icon:'error',title:'@lang('products.error_adding_to_cart')',text:data.message || '@lang('products.try_again_later')'});
      }
    })
    .catch(err=>{
      console.error(err);
      Swal.fire({icon:'error',title:'@lang('products.error_adding_to_cart')',text:'@lang('products.try_again_later')'});
    });
  }
</script>

{{-- سكين التصميم فقط --}}
<style>
  /* خلفية لطيفة */
  .pd-kids{ background:#bff4f4; }

  /* حاوية بيضاء ناعمة */
  .detail-shell{
    background:#fff; border:1px solid #e6eef6; border-radius:18px; padding:18px;
    box-shadow:0 12px 28px rgba(16,24,40,.08);
  }

  /* بطاقة معلومات يمين */
  .info-card{background:#fff; border:1px solid #edf2f7; border-radius:16px; padding:18px}
  .brand-chip{background:#eef7ff; color:#1f54b5; font-weight:700; padding:.35rem .7rem; border-radius:999px; font-size:.85rem}
  .title{font-size:clamp(22px,3vw,28px); font-weight:800; color:#0f172a}

  /* السعر */
  .price-row{display:flex; align-items:center; gap:.6rem; flex-wrap:wrap; margin-top:.6rem}
  .price-row.center{justify-content:center}
  .price-now{color:#00a2c7; font-weight:800; font-size:1.2rem}
  .price-old{color:#98a2b3}

  .badge-sale{background:#00c853; color:#fff; font-weight:800; padding:.2rem .6rem; border-radius:999px; font-size:.75rem}

  /* الصور */
  .hero-img{
    width:100%; max-width:620px; aspect-ratio:1/1; object-fit:contain;
    background:#fff; border:1px solid #edf2f7; border-radius:16px; display:block
  }
  .fade{opacity:.2; transition:opacity .12s}
  .gallery-item{
    width:100%; aspect-ratio:1/1; object-fit:contain;
    background:#fff; border:1px solid #e9eef3; border-radius:12px; cursor:pointer;
    transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
  }
  .gallery-item:hover{transform:translateY(-2px); box-shadow:0 6px 14px rgba(16,24,40,.08); border-color:#87c4ff}

  /* خيارات اللون/المقاس */
  .section-title{font-weight:800; color:#0f172a}
  .color-chip, .size-chip{
    display:inline-flex; align-items:center; gap:.5rem; padding:.45rem .7rem;
    background:#fff; border:1px solid #e5e7eb; border-radius:999px; cursor:pointer; font-weight:700;
    transition:transform .12s ease, border-color .12s ease, background .12s ease;
  }
  .color-chip .dot{width:18px; height:18px; border-radius:999px; border:1px solid #e5e7eb}
  .color-chip:hover, .size-chip:hover{transform:translateY(-2px); border-color:#0ea5e9}
  .is-selected{background:#0ea5e9 !important; color:#fff !important; border-color:#0ea5e9 !important}

  /* ميتا */
  .meta .row{display:flex; align-items:center; gap:.5rem}
  .meta .key{color:#667085; font-weight:700}
  .meta .val{color:#0f172a}
  .ok-row{color:#16a34a; font-weight:800}

  /* كمية + زر السلة */
  .actions{display:flex; align-items:center; gap:10px; flex-wrap:wrap}
  .qty-wrap{
    display:inline-flex; align-items:center; gap:8px; background:#f7fafc; border:1px solid #e5e7eb; border-radius:12px; padding:6px 10px
  }
  .qty-btn{width:34px; height:34px; border:1px solid #e5e7eb; background:#fff; border-radius:10px; display:grid; place-items:center}
  .qty-val{min-width:22px; text-align:center; font-weight:800}
  .add-to-cart{
    height:44px; padding:0 18px; border-radius:12px; background:#111; color:#fff; font-weight:800; border:2px solid #111;
    transition:transform .15s ease, opacity .15s ease
  }
  .add-to-cart:hover{transform:translateY(-2px); opacity:.95}

  /* كروت المنتجات (أسفل) */
  .kid-card{
    background:#fff; border:1px solid #e9eef3; border-radius:16px; padding:14px;
    box-shadow:0 8px 18px rgba(16,24,40,.06); position:relative
  }
  .product-card .img-wrap{
    width:100%; aspect-ratio:1/1; border-radius:14px; overflow:hidden; border:1px solid #e9eef3; background:#fff;
  }
  .product-card .img-wrap img{width:100%; height:100%; object-fit:contain; transition:transform .22s ease}
  .product-card:hover .img-wrap img{transform:scale(1.06)}
  .product-infor .brand{display:block; color:#98a2b3; text-transform:uppercase; font-size:.78rem; letter-spacing:.02em}
  .product-infor .title{margin-top:4px; color:#0f172a; font-weight:800}

  /* زر العرض السريع */
  .quick-view-btn{
    margin-top:10px; width:100%; height:38px; border-radius:10px; background:#00c2a8; color:#fff; font-weight:800; border:0;
    display:inline-flex; align-items:center; justify-content:center; gap:8px; transition:transform .15s ease, opacity .15s ease
  }
  .quick-view-btn:hover{transform:translateY(-2px); opacity:.95}

  /* ريبون */
  .ribbon{
    position:absolute; top:10px; left:-6px; padding:6px 10px; color:#fff; font-size:.72rem; font-weight:800;
    border-top-right-radius:999px; border-bottom-right-radius:999px; box-shadow:0 10px 20px rgba(0,0,0,.12)
  }
  .ribbon::after{content:""; position:absolute; inset:auto auto -6px 0; border:6px solid transparent; border-left-color:rgba(0,0,0,.18)}
  .ribbon-orange{background:#ff9f1c}
  .ribbon-green{background:#00c853}
</style>
@endsection
