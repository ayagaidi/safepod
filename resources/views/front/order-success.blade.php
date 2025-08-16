@extends('front.app')

@section('title', __('order.success_title'))

@section('content')
<div id="menu-department-block" class="menu-department-block relative h-full hidden"></div>

<div class="kids-success">
  <div class="container">
    <div class="success-wrap">
      {{-- Confetti (pure CSS) --}}
      <div class="confetti">
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
      </div>

      <div class="kid-card success-card text-center">
        {{-- Animated check badge --}}
        <div class="badge">
          <svg viewBox="0 0 52 52" aria-hidden="true">
            <circle class="ring" cx="26" cy="26" r="24" fill="none"></circle>
            <path class="check" fill="none" d="M14 27 l8 8 l16 -16"></path>
          </svg>
        </div>

        <h1 class="title">{{ __('order.success_message') }}</h1>
        <p class="subtitle">{{ __('order.success_description') }}</p>

        @if($order)
          <p class="order-line">
            <i class="ph ph-receipt"></i>
            <span>{{ __('order.tran') }}:</span>
            <strong>{{ $order->ordersnumber }}</strong>
          </p>
        @else
          <p class="order-line">
            <i class="ph ph-receipt"></i>
            <strong>{{ __('order.tran_not_available') }}</strong>
          </p>
        @endif

        <img src="{{ asset('shopping.png') }}" alt="Order Successful" class="hero-img" loading="lazy">

        <div class="btn-row">
          <a href="{{ route('/') }}" class="pill primary">
            <i class="ph ph-house"></i>
            <span>{{ __('order.return_home') }}</span>
          </a>
          <a href="{{ route('all_products') }}" class="pill ghost">
            <i class="ph ph-storefront"></i>
            <span>{{ __('products.continue_shopping') }}</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Small helper to keep header menu hidden like other pages --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const menu = document.getElementById('menu-department-block');
    if (menu) menu.classList.add('hidden');
  });
</script>

<style>
/* Page background (same playful vibe) */
.kids-success{ background:#bff4f4; min-height:calc(100vh - 120px); display:flex; align-items:center; }
.kids-success .container{ width:100%; padding:32px 16px; }

/* Shell */
.success-wrap{ max-width:720px; margin:0 auto; position:relative; }

/* Card */
.kid-card{
  background:#fff; border:1px solid #e9eef3; border-radius:16px; padding:24px;
  box-shadow:0 10px 26px rgba(16,24,40,.08);
}
.success-card{ padding:32px 24px; position:relative; overflow:hidden }

/* Animated badge */
.badge{
  width:94px; height:94px; margin:0 auto 12px; border-radius:999px;
  background:radial-gradient(61% 61% at 50% 50%, #00c2a8 0%, #00a28f 100%);
  display:grid; place-items:center; box-shadow:0 14px 30px rgba(0,162,143,.35);
}
.badge svg{ width:56px; height:56px }
.ring{
  stroke:#ffffff55; stroke-width:4; stroke-linecap:round;
  stroke-dasharray: 150; stroke-dashoffset: 150; animation:ring 1.1s ease-out forwards .1s;
}
.check{
  stroke:#fff; stroke-width:4.5; stroke-linecap:round; stroke-linejoin:round;
  stroke-dasharray: 40; stroke-dashoffset: 40; animation:check 0.7s ease-out forwards .45s;
}

/* Headings */
.title{ margin:8px 0 4px; font-weight:900; color:#0f172a; font-size: clamp(1.4rem, 2vw + 1rem, 2rem); }
.subtitle{ color:#64748b; margin-bottom:10px }

/* Order line */
.order-line{
  display:inline-flex; align-items:center; gap:8px; margin:6px 0 16px; color:#0f172a; font-weight:700
}
.order-line .ph{ color:#00a2c7 }

/* Image */
.hero-img{
  width:120px; height:auto; margin:8px auto 10px; display:block; object-fit:contain
}

/* Buttons */
.btn-row{
  display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-top:8px
}
.pill{
  display:inline-flex; align-items:center; gap:8px; height:42px; padding:0 16px; border-radius:999px; font-weight:800; text-decoration:none
}
.pill .ph{ font-size:18px }
.pill.primary{ background:#00c2a8; color:#fff; border:0 }
.pill.primary:hover{ filter:brightness(.95) }
.pill.ghost{ background:#fff; color:#0f172a; border:1px solid #e7ebf0 }
.pill.ghost:hover{ border-color:#00c2a8; box-shadow:0 8px 18px rgba(16,24,40,.08) }

/* Confetti */
.confetti{ position:absolute; inset:-10px 0 auto 0; height:0; pointer-events:none }
.confetti span{
  position:absolute; top:-14px; left:50%; width:8px; height:10px; border-radius:2px; opacity:.9;
  animation: fall 1.8s linear forwards;
}
.confetti span:nth-child(1){ transform:translateX(-180px); background:#ff4f84; animation-delay:.0s }
.confetti span:nth-child(2){ transform:translateX(-120px); background:#00c2a8; animation-delay:.1s }
.confetti span:nth-child(3){ transform:translateX(-60px);  background:#ff9f1c; animation-delay:.15s }
.confetti span:nth-child(4){ transform:translateX(-10px);  background:#6366f1; animation-delay:.05s }
.confetti span:nth-child(5){ transform:translateX(40px);   background:#22c55e; animation-delay:.12s }
.confetti span:nth-child(6){ transform:translateX(90px);   background:#06b6d4; animation-delay:.18s }
.confetti span:nth-child(7){ transform:translateX(130px);  background:#f97316; animation-delay:.07s }
.confetti span:nth-child(8){ transform:translateX(170px);  background:#ef4444; animation-delay:.16s }
.confetti span:nth-child(9){ transform:translateX(-210px); background:#14b8a6; animation-delay:.2s }
.confetti span:nth-child(10){transform:translateX(-20px);  background:#f43f5e; animation-delay:.23s }
.confetti span:nth-child(11){transform:translateX(60px);   background:#a855f7; animation-delay:.25s }
.confetti span:nth-child(12){transform:translateX(200px);  background:#10b981; animation-delay:.28s }

/* Animations */
@keyframes ring{
  to{ stroke-dashoffset: 0; }
}
@keyframes check{
  to{ stroke-dashoffset: 0; }
}
@keyframes fall{
  0%{ transform: translateX(var(--x, 0)) translateY(-14px) rotate(0deg); opacity:1 }
  100%{ transform: translateX(calc(var(--x, 0))) translateY(220px) rotate(320deg); opacity:0 }
}

/* Responsive tweaks */
@media (max-width:480px){
  .success-card{ padding:24px 16px }
  .btn-row{ gap:8px }
  .pill{ height:40px; padding:0 14px }
}
</style>
@endsection
