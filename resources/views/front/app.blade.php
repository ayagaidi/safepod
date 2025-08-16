<!DOCTYPE html>
@php
  $lang = \Session::get('language', 'ar');
  $dir  = $lang === 'en' ? 'ltr' : 'rtl';
@endphp
<html lang="{{ $lang }}" dir="{{ $dir }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('colorico.ico') }}">
  <title>safePod-@yield('title')</title>

  {{-- ملفاتك الموجودة --}}
  <link rel="stylesheet" href="{{ asset('front/assets/css/swiper-bundle.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('front/dist/output-scss.css') }}" />
  <link rel="stylesheet" href="{{ asset('front/dist/output-tailwind.css') }}" />

  {{-- خطوط --}}
  @if ($lang === 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style> body{font-family:'Cairo',sans-serif;} </style>
  @else
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style> body{font-family:'Poppins',sans-serif;} </style>
  @endif

  <style>
    /* ===== Theme (Bee Kids) ===== */
    :root{
      --sky:#CFF0FF;
      --brand:#1f8cd6;
      --brand-dark:#0f6fb0;
      --tabs-bg:#2d7bdc;
      --hot:#ff4f84;
      --mint:#bdf4e2;
      --ink:#0f172a;
      --muted:#667085;
      --line:#e6e7eb;
      --card:#fff;
      --radius:22px;
      --shadow:0 10px 30px rgba(16,24,40,.08);
    }

    html,body{
      background: var(--sky) url("data:image/svg+xml,%3Csvg width='160' height='80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.55'%3E%3Ccircle cx='20' cy='20' r='16'/%3E%3Ccircle cx='60' cy='30' r='12'/%3E%3Ccircle cx='110' cy='18' r='14'/%3E%3Ccircle cx='140' cy='36' r='10'/%3E%3C/g%3E%3C/svg%3E") repeat;
      background-size: 240px 120px;
    }
    .container{max-width:1200px;margin-inline:auto;padding-inline:1rem;}

    /* ===== Top utility bar ===== */
    .topbar{padding:8px 0;display:flex;align-items:center;justify-content:space-between;gap:10px;}
    .top-actions{display:flex;gap:.5rem;align-items:center;flex-wrap:wrap}
    .top-pill{background:#fff;border:1px solid var(--line);border-radius:999px;padding:.35rem .7rem;display:inline-flex;gap:.5rem;align-items:center;box-shadow:var(--shadow);}
    .link{color:#0b1220;font-weight:600}
    .link:hover{opacity:.8}

    /* ===== Header strip ===== */
    .header{background:#b7eaff;border:1px solid #a7e0fb;border-radius:var(--radius);padding:.8rem 1rem;box-shadow:var(--shadow);}
    .logo img{max-width:170px;height:auto}
    .search-wrap{display:flex;gap:.5rem;align-items:center;width:100%;max-width:640px;margin-inline:auto}
    .search-input{background:#fff;border:1px solid var(--line);border-radius:999px;height:44px;padding-inline:16px;flex:1;outline:none;}
    .search-btn{height:44px;padding-inline:22px;border-radius:999px;background:var(--hot);color:#fff;border:0;font-weight:700;}
    .cart-bubble{position:relative;display:inline-grid;place-items:center;width:48px;height:48px;border-radius:999px;background:#fff;border:1px solid var(--line);}
    .cart-bubble .qty{position:absolute;top:-6px;inset-inline-end:-6px;background:#3ccf4e;color:#fff;font-size:12px;min-width:22px;height:22px;display:grid;place-items:center;border-radius:999px;box-shadow:var(--shadow);}

    /* ===== Tabs nav ===== */
    .tabs{margin-top:10px;background:var(--tabs-bg);border-radius:14px;padding:.4rem;display:flex;gap:.4rem;flex-wrap:nowrap;overflow:auto;white-space:nowrap;scrollbar-width:none;box-shadow:var(--shadow);}
    .tabs::-webkit-scrollbar{display:none}
    .tab{background:#fff;color:#0b1220;padding:.55rem 1rem;border-radius:999px;font-weight:700;border:1px solid #ffffff;flex:0 0 auto;}
    .tab:hover{background:#f9fbff}
    .tab.active{background:var(--hot);color:#fff;border-color:var(--hot)}
    .nav-row{margin-top:.6rem}

    /* ===== Hero + left categories ===== */
    .hero-grid{display:grid;grid-template-columns:280px 1fr;gap:16px;margin-top:14px}
    @media (max-width:1024px){ .hero-grid{grid-template-columns:1fr} }
    .side-card{background:#fff;border:1px solid var(--line);border-radius:20px;padding:10px;box-shadow:var(--shadow);}
    .side-card .item{display:flex;align-items:center;gap:.6rem;padding:.7rem .6rem;border-radius:12px;color:#0b1220;}
    .side-card .item:hover{background:#f3fbff}
    .cats-toggle{margin:8px 0}
    @media (min-width:1025px){ .cats-toggle{display:none} }
    @media (max-width:1024px){ .side-card{display:none}.side-card.open{display:block} }

    .hero{background:#fff;border:1px solid var(--line);border-radius:20px;padding:0;overflow:hidden;box-shadow:var(--shadow);}
    .hero-inner{display:grid;grid-template-columns:1.1fr .9fr;gap:10px}
    @media (max-width:1024px){ .hero-inner{grid-template-columns:1fr} }
    .hero-media{min-height:320px;background:linear-gradient(180deg,#fff 0%, #e7f7ff 100%);display:flex;align-items:center;justify-content:center}
    .hero-copy{padding:24px}
    .cta{display:inline-flex;align-items:center;gap:.5rem;height:44px;padding-inline:18px;border-radius:999px;background:#fff;color:var(--hot);border:2px solid var(--hot);font-weight:700}
    .cta:hover{background:var(--hot);color:#fff}
    .tick{color:#29b36b;font-weight:700}
    @media (max-width:640px){ .hero-copy{text-align:center}.cta{width:100%;justify-content:center} }

    /* ===== Footer benefit cards ===== */
    .benefit-card{background:#fff;border:1px solid var(--line);border-radius:20px;padding:20px;text-align:center;box-shadow:var(--shadow)}

    /* RTL helpers */
    [dir="rtl"] .ms-auto{margin-left:auto}
    [dir="rtl"] .me-auto{margin-right:auto}
  </style>
</head>
<body>
@php $cartItems = session('cart_items', []); @endphp

<div class="container">

  {{-- ===== Top utility bar ===== --}}
  <div class="topbar" aria-label="Top utilities">
    <div class="top-actions">
      <div class="top-pill">
        @if ($lang === 'en')
          <a class="link" href="{{ route('changeLanguage','language=ar') }}" aria-label="Switch to Arabic">العربية</a>
        @else
          <a class="link" href="{{ route('changeLanguage','language=en') }}" aria-label="Switch to English">English</a>
        @endif
      </div>
      <div class="top-pill">
        <a class="link" href="#">{{ $lang==='ar' ? 'حسابي' : 'My Account' }}</a>
      </div>
    </div>

    {{-- أضفنا cart-icon + cart-quantity --}}
    <a href="{{ route('cart.index') }}" class="cart-bubble cart-icon" aria-label="Shopping cart">
      <i class="ph-bold ph-handbag text-xl"></i>
      <span class="qty cart-quantity">{{ count($cartItems) }}</span>
    </a>
  </div>

  {{-- ===== Header (Logo + Search) ===== --}}
  <header class="header header-menu">
    <div class="flex items-center gap-4 justify-between">
      <a href="{{ route('/') }}" class="logo" aria-label="Home">
        <img src="{{ asset('mlogo.png') }}" alt="Store logo">
      </a>

      <form method="GET" action="{{ route('search') }}" class="search-wrap" role="search" aria-label="Site search">
        @csrf
        <input name="q" class="search-input" placeholder="{{ trans('menu.wh') }}" aria-label="{{ trans('menu.search') }}">
        <button class="search-btn" type="submit">{{ $lang==='ar' ? 'بحث' : 'Search' }}</button>
      </form>
    </div>

    {{-- Tabs Nav --}}
    <nav class="nav-row" aria-label="Primary">
      <div class="tabs">
        <a href="{{ route('/') }}" class="tab {{ request()->is('/') ? 'active' : '' }}">{{ trans('menu.home') }}</a>
        <a href="{{ route('all_products') }}" class="tab {{ request()->is('all_products') ? 'active' : '' }}">{{ trans('menu.product') }}</a>
        <a href="{{ route('products/discount') }}" class="tab {{ request()->is('products/discount') ? 'active' : '' }}">{{ __('products.discountprodact') }}</a>
        <a href="{{ route('about') }}" class="tab {{ request()->is('about') ? 'active' : '' }}">{{ trans('menu.who_we_are') }}</a>
        <a href="{{ route('contacts') }}" class="tab {{ request()->is('contacts') ? 'active' : '' }}">{{ trans('menu.contact_us') }}</a>
      </div>
    </nav>
  </header>

  {{-- ===== Hero area: Sidebar categories + Banner ===== --}}
  <section class="hero-grid" aria-label="Featured">
    <button id="toggleCats" class="top-pill cats-toggle">
      {{ $lang==='ar'?'الفئات':'Categories' }}
      <i class="ph ph-caret-down"></i>
    </button>

    {{-- Left categories --}}
    <aside class="side-card" aria-label="Categories list">
      <ul>
        @if ($categories && count($categories))
          @foreach ($categories as $item)
            <li>
              <a class="item" href="{{ route('product/category', encrypt($item->id)) }}">
                <img src="{{ asset('images/category/' . $item->image) }}" loading="lazy"
                     alt="{{ $lang==='ar' ? $item->name : $item->englishname }}" class="w-6 h-6 object-contain">
                <span>{{ $lang==='ar' ? $item->name : $item->englishname }}</span>
              </a>
            </li>
          @endforeach
        @else
          <li class="item text-[var(--muted)]">{{ trans('menu.no_categories') }}</li>
        @endif
      </ul>
    </aside>

    {{-- Hero banner --}}
    <div class="hero" role="banner">
      <div class="hero-inner">
        <div class="hero-media">
          <img src="{{ asset('front/assets/img/hero-kids.png') }}"
               alt="{{ $lang==='ar'?'عرض للأطفال':'Kids promotion' }}"
               style="max-height:320px;object-fit:contain;">
        </div>
        <div class="hero-copy">
          <h2 style="font-size:clamp(22px,3.2vw,34px);color:#1c2b48;font-weight:800;margin-bottom:.6rem">
            {{ $lang==='ar' ? 'ملابس ونوم لأطفالكم' : 'Bee Clothing For Kids' }}
          </h2>
          <ul style="margin:0 0 1rem 0;padding:0;list-style:none;line-height:1.9;color:#31445f">
            <li><span class="tick">✔</span> {{ $lang==='ar' ? 'راحة طوال اليوم' : 'Active Baby All Day Comfort' }}</li>
            <li><span class="tick">✔</span> {{ $lang==='ar' ? 'جودة موثوقة' : 'Reliability Good' }}</li>
          </ul>
          <a href="{{ route('all_products') }}" class="cta">
            {{ $lang==='ar' ? 'تسوقي الآن' : 'Shop Now' }}
            <i class="ph-bold ph-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

</div> {{-- /container --}}

{{-- ===== باقي الصفحات ===== --}}
@yield('content')

<br>
{{-- ===== Benefits ===== --}}
<div class="container">
  <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-4 my-8">
    <div class="benefit-card">
      <i class="icon-phone-call text-5xl" style="color:#ff9f1c"></i>
      <div class="mt-3">@lang('home.customer_service')</div>
      <div class="text-sm text-[var(--muted)] mt-1">@lang('home.customer_service_desc')</div>
    </div>
    <div class="benefit-card">
      <i class="icon-return text-5xl" style="color:#00c2a8"></i>
      <div class="mt-3">@lang('home.money_back')</div>
      <div class="text-sm text-[var(--muted)] mt-1">@lang('home.money_back_desc')</div>
    </div>
    <div class="benefit-card">
      <i class="icon-guarantee text-5xl" style="color:#845ef7"></i>
      <div class="mt-3">@lang('home.guarantee')</div>
      <div class="text-sm text-[var(--muted)] mt-1">@lang('home.guarantee_desc')</div>
    </div>
    <div class="benefit-card">
      <i class="icon-delivery-truck text-5xl" style="color:#fa5252"></i>
      <div class="mt-3">@lang('home.shipping')</div>
      <div class="text-sm text-[var(--muted)] mt-1">@lang('home.shipping_desc')</div>
    </div>
  </div>
</div>
<br>
<footer class="bg-white border-t border-[var(--line)]">
  <div class="container">
    <div class="py-4 flex items-center justify-between gap-4 max-lg:flex-col">
      <div class="text-sm text-[var(--muted)]">©2024 Color Boutuque. {{ trans('menu.all_rights_reserved') }}</div>
    </div>
  </div>
</footer>

{{-- ===== Scripts ===== --}}
<script src="{{ asset('front/assets/js/phosphor-icons.js') }}"></script>
<script src="{{ asset('front/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('front/assets/js/swiper-bundle.min.js') }}"></script>

{{-- ملفك الأصلي --}}
<script src="{{ asset('front/assets/js/main.js') }}"></script>

<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="{{ asset('dash/assets/plugin/sweet-alert/sweetalert.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // فتح/إغلاق قائمة الفئات في الموبايل
  document.getElementById('toggleCats')?.addEventListener('click',()=>{
    document.querySelector('.side-card')?.classList.toggle('open');
  });

  // تحديث عداد السلة
  const qtyBadges = document.querySelectorAll('.qty, .cart-quantity');
  fetch('{{ route('cart.items.count') }}', { headers:{'Accept':'application/json'} })
    .then(r=>r.json()).then(d=>{ if(d?.success){ qtyBadges.forEach(el=> el.textContent=d.count) } }).catch(()=>{});
</script>
</body>
</html>
