@extends('front.app')
@section('title', __('__navbar.about') )
@section('content')

<div id="menu-department-block" class="menu-department-block relative h-full hidden">
    <!-- Added 'hidden' class to hide the section on page load -->
</div>

<div class="breadcrumb-block style-shared">
    <div class="breadcrumb-main bg-linear overflow-hidden">
        <div class="container lg:pt-[124px] pt-24 pb-10 relative">
            <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                <div class="text-content">
                    <div class="heading2 text-center">{{ trans('menu.who_we_are') }}</div>
                    <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                        <a href="{{route('/')}}" class="hover:underline">{{ trans('menu.home') }}</a>
                        <i class="ph ph-caret-right text-sm text-secondary2"></i>
                        <div class="text-secondary2 capitalize">{{ trans('menu.who_we_are') }}</div>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
</div>
<div class="about md:pt-20 pt-10">
    <div class="about-us-block">
        <div class="container px-4 md:px-0">
            <div class="text flex items-center justify-center">
                <div class="content md:w-5/6 w-full">
                    @if(app()->getLocale() === 'ar')
                        <div class="body1 text-center md:mt-7 mt-5 leading-relaxed break-words text-sm md:text-base">
                            {{ empty($aboutus->dec) ? 'safePod - Beauty
وجهتك الأولى لعالم الجمال والعناية المتكاملة.
نوفر لكِ مجموعة مختارة بعناية من منتجات العناية بالبشرة، الجسم، الشعر، والمكياج الأصلي – كلها من علامات موثوقة وجودة مضمونة.

نحن في safePod نؤمن بأن الجمال يبدأ من العناية، ونحرص على تقديم تجربة تسوق أنيقة، آمنة، ومليئة بالثقة.
اختاري روتينك المثالي من بين منتجاتنا المختارة لتظهري بأفضل نسخة منك.' : $aboutus->dec }}
                        </div>
                    @else
                        <div class="body1 text-center md:mt-7 mt-5 leading-relaxed break-words text-sm md:text-base">
                            {{ empty($aboutus->decen) ? 'safePod - Beauty
Your first destination for the world of beauty and comprehensive care.
We offer a carefully selected collection of original skincare, body care, hair care, and makeup products—all from trusted brands and guaranteed quality.

At safePod, we believe that beauty begins with care, and we are committed to providing an elegant, safe, and confident shopping experience.
Choose your perfect routine from our curated selection of products to look your best.' : $aboutus->decen }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuBlock = document.getElementById('menu-department-block');

        if (menuBlock) {
            menuBlock.classList.toggle('hidden'); // Toggle visibility on page load
        }
    });
</script>
@endsection
