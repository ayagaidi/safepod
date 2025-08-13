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
                    <div class="heading2 text-center">{{ trans('menu.policies') }}</div>
                    <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                        <a href="{{route('/')}}" class="hover:underline">{{ trans('menu.home') }}</a>
                        <i class="ph ph-caret-right text-sm text-secondary2"></i>
                        <div class="text-secondary2 capitalize">{{ trans('menu.policies') }}</div>
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
                        <div class="heading2 text-center">{{ $policies->title_ar }}</div>
                        <div class="body1 text-center md:mt-7 mt-5 leading-relaxed break-words text-sm md:text-base">
                            {{$policies->description_ar}}

                        </div>
                    @else
                        <div class="heading2 text-center">{{ $policies->title_en }}</div>
                        <div class="body1 text-center md:mt-7 mt-5 leading-relaxed break-words text-sm md:text-base">
                                          {{$policies->description_en}}        
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
