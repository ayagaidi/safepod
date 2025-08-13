@extends('front.app')

@section('title', trans('home.home'))

@section('content')
   <!-- Slider -->
   
   <div class="slider-block style-marketplace lg:h-[500px] md:h-[400px] sm:h-[320px] h-[280px] w-full">
    <div class="container pt-10 flex justify-end h-full w-full">
        <div class="slider-main lg:pl-5 h-full w-full">
            <div class="h-full relative rounded-2xl overflow-hidden">
                <div class="slider-item h-full w-full flex items-center bg-surface relative">
                    <div class="text-content md:pl-16 pl-5 basis-1/2 relative z-[1]">
                        @if($sliders)
                        @if (App::getLocale() == 'ar')
                        <div class="text-sub-display text-white text-lg sm:text-xl md:text-2xl lg:text-3xl"></div>
                        @else
                        <div class="text-sub-display text-white text-lg sm:text-xl md:text-2xl lg:text-3xl"></div>
                        @endif
                        @else
                        <div class="text-sub-display text-white text-lg sm:text-xl md:text-2xl lg:text-3xl"></div>
                        @endif
                    </div>
                    @if($sliders)
                    <div class="sub-img absolute top-0 left-0 w-full h-full">
                        <img src="{{ asset('images/slider/' . $sliders->imge) }}" alt="marketplace" class="w-full h-full object-cover" />
                    </div>
                    @else
                    <div class="sub-img absolute top-0 left-0 w-full h-full">
                        <img src="{{asset('front/assets/images/slider/marketplace.png')}}" alt="marketplace" class="w-full h-full object-cover" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="collection-block md:pt-[60px] pt-10">
    <div class="container">
        <div class="heading flex items-center justify-between gap-5 flex-wrap">
            <div class="heading3">@lang('home.our_collections')</div>
            <a href="{{route('all_products')}}" class="text-button pb-0.5 border-b-2 border-black">@lang('home.view_all')</a>
        </div>
        <div class="list grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-[20px] md:mt-10 mt-6">
            @foreach ($categoriess as $categori)
                <div class="item flex gap-3 px-5 py-6 border border-line rounded-2xl">
                    <a href="{{ route('product/category', encrypt($categori->id)) }}" class="img-product w-[100px] h-[100px] flex-shrink-0">
                        <img src="{{ asset('images/category/' . $categori->image) }}" class="w-full h-full object-cover" alt="image" />
                    </a>
                    <div class="text-content w-full">
                        @if (App::getLocale() == 'ar')
                            <div class="heading6 pb-4">{{ $categori->name }}</div>
                        @else
                            <div class="heading6 pb-4">{{ $categori->englishname }}</div>
                        @endif

                        <a href="{{ route('product/category', encrypt($categori->id)) }}" class="flex items-center gap-1.5 mt-4">
                            <span class="text-button">
                                @lang('home.all', ['name' => App::getLocale() == 'ar' ? $categori->name : $categori->englishname])
                            </span>
                            <i class="ph-bold ph-caret-double-right text-sm"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuBlock = document.getElementById('menu-department-block');

        if (menuBlock) {
            menuBlock.style.display = 'block'; // Remove inline 'display: none'
            menuBlock.classList.add('show');    // Ensures the menu is visible on page load
        }
    });
</script>
@endsection


