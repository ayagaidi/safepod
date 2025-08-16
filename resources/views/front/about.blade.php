@extends('front.app')
@section('title', __('__navbar.about')) {{-- لو مفتاحك الصحيح "navbar.about" بدّل السطر ده --}}
@section('content')

<div class="kids-theme">
    <div id="menu-department-block" class="menu-department-block relative h-full hidden"></div>

    {{-- Breadcrumb --}}
    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[124px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">{{ trans('menu.who_we_are') }}</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('/') }}" class="hover:underline">{{ trans('menu.home') }}</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <div class="text-secondary2 capitalize">{{ trans('menu.who_we_are') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel أبيض يحتوي المحتوى --}}
    <div class="about md:pt-12 pt-8">
        <div class="container">
            <div class="kids-panel">
                <div class="about-grid">
                    {{-- بطاقة تعريف مختصرة (اختيارية للهوية) --}}
                    <section class="kid-card highlight">
                        <div class="hi-title">
                            <span class="dot"></span>
                            <h2 class="title">{{ trans('menu.who_we_are') }}</h2>
                        </div>
                        <p class="subtitle">
                            safePod – {{ app()->getLocale() === 'ar' ? 'جمالك يبدأ من العناية' : 'Beauty starts with care' }}
                        </p>
                    </section>

                    {{-- البطاقة الرئيسية للنص --}}
                    <section class="kid-card">
                        <div class="body1 text-center md:mt-2 mt-1 leading-relaxed break-words whitespace-pre-line text-base md:text-lg">
                            @if(app()->getLocale() === 'ar')
                                {{ empty($aboutus->dec) ? "safePod - Beauty
وجهتك الأولى لعالم الجمال والعناية المتكاملة.
نوفر لكِ مجموعة مختارة بعناية من منتجات العناية بالبشرة، الجسم، الشعر، والمكياج الأصلي – كلها من علامات موثوقة وجودة مضمونة.

نحن في safePod نؤمن بأن الجمال يبدأ من العناية، ونحرص على تقديم تجربة تسوق أنيقة، آمنة، ومليئة بالثقة.
اختاري روتينك المثالي من بين منتجاتنا المختارة لتظهري بأفضل نسخة منك." : $aboutus->dec }}
                            @else
                                {{ empty($aboutus->decen) ? "safePod - Beauty
Your first destination for the world of beauty and comprehensive care.
We offer a carefully selected collection of original skincare, body care, hair care, and makeup products—all from trusted brands and guaranteed quality.

At safePod, we believe that beauty begins with care, and we are committed to providing an elegant, safe, and confident shopping experience.
Choose your perfect routine from our curated selection of products to look your best." : $aboutus->decen }}
                            @endif
                        </div>
                    </section>

                    {{-- نقاط سريعة (لا تغيّر منطقك، مجرد ديكور) --}}
                    <section class="kid-card bullets">
                        <div class="bullet">
                            <span class="ico">✔</span>
                            <div class="txt">{{ app()->getLocale()==='ar' ? 'منتجات أصلية وجودة مضمونة' : 'Original products, guaranteed quality' }}</div>
                        </div>
                        <div class="bullet">
                            <span class="ico">✔</span>
                            <div class="txt">{{ app()->getLocale()==='ar' ? 'تجربة تسوق آمنة وسلسة' : 'Safe & seamless shopping experience' }}</div>
                        </div>
                        <div class="bullet">
                            <span class="ico">✔</span>
                            <div class="txt">{{ app()->getLocale()==='ar' ? 'اختيارات بعناية تناسب روتينك' : 'Carefully curated to fit your routine' }}</div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- نفس سكربتك: إظهار/إخفاء المينيو --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuBlock = document.getElementById('menu-department-block');
    if (menuBlock) menuBlock.classList.toggle('hidden');
});
</script>

{{-- سكين CSS فقط—لا يغيّر المنطق --}}
<style>
/* خلفية موحّدة مثل صفحات المنتجات */
.kids-theme{ background:#bff4f4; }

/* بانيل أبيض عام */
.kids-panel{
  background:#fff; border-radius:16px; padding:18px;
  box-shadow:0 10px 30px rgba(16,24,40,.08);
}

/* شبكة بسيطة للبطاقات */
.about-grid{
  display:grid; grid-template-columns:1fr; gap:14px;
}

/* بطاقة عامة */
.kid-card{
  background:#fff; border:1px solid #e9eef3; border-radius:16px; padding:18px;
  box-shadow:0 6px 16px rgba(16,24,40,.06);
}

/* الهيدر المصغّر */
.kid-card.highlight .hi-title{display:flex; align-items:center; gap:10px}
.kid-card.highlight .hi-title .dot{width:12px; height:12px; border-radius:999px; background:#00c2a8; display:inline-block}
.kid-card.highlight .title{margin:0; font-size:1.25rem; font-weight:800; color:#0f172a}
.kid-card.highlight .subtitle{margin:.35rem 0 0; color:#64748b; font-weight:700}

/* نقاط سريعة */
.kid-card.bullets{display:grid; gap:10px}
.kid-card.bullets .bullet{display:flex; align-items:center; gap:10px}
.kid-card.bullets .ico{
  width:28px; height:28px; border-radius:999px; display:inline-grid; place-items:center;
  background:#00c2a8; color:#fff; font-weight:900;
}
.kid-card.bullets .txt{font-weight:700; color:#111827}

/* تحسين قراءة النص */
.body1{color:#0f172a}
</style>
@endsection
