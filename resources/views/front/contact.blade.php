@extends('front.app')
@section('content')
@section('title', trans('menu.contact_us') )

<div class="breadcrumb-block style-shared">
    <div class="breadcrumb-main bg-linear overflow-hidden">
        <div class="container lg:pt-[124px] pt-24 pb-10 relative">
            <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                <div class="text-content">
                    <div class="heading2 text-center">{{ trans('menu.contact_us') }}</div>
                    <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                        <a href="{{route('/')}}" class="hover:underline">{{ trans('menu.home') }}</a>
                        <i class="ph ph-caret-right text-sm text-secondary2"></i>
                        <div class="text-secondary2 capitalize">{{ trans('menu.contact_us') }}</div>
                    </div>
                </div>
            </div>
        {{-- 
            DESCRIPTION: This Blade template file is part of the "front" section of the application, 
            specifically for the "About" page. It is used to define the structure and content 
            of the About page in the front-end of the application.
        --}}
        </div>
    </div>
</div>
<div class="contact-us md:py-20 py-10">
    <div class="container">
        <div class="flex flex-wrap justify-between max-lg:flex-col gap-y-10">
            <div class="left lg:w-2/3 lg:pr-4">
                <div class="heading3">{{ trans('contacts.drop_us_a_line') }}</div>
                <div class="body1 text-secondary2 mt-3">{{ trans('contacts.use_form_below') }}</div>
                <form class="md:mt-6 mt-4" method="POST" action="{{ route('send') }}">
                    @csrf
                    <div class="grid sm:grid-cols-2 grid-cols-1 gap-4 gap-y-5">
                        <div class="name">
                            <input class="border-line px-4 py-3 w-full rounded-lg @error('name') border-red-500 @enderror" id="username" name="name" type="text" placeholder="{{ __('contacts.name_placeholder') }}" value="{{ old('name') }}" required />
                            @error('name')
                            <span class="text-red-500 text-sm" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="email">
                            <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg @error('email') border-red-500 @enderror" id="email" name="email" type="email" placeholder="{{ __('contacts.email_placeholder') }}" value="{{ old('email') }}" required />
                            @error('email')
                            <span class="text-red-500 text-sm" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="subject sm:col-span-2">
                            <input class="border-line px-4 py-3 w-full rounded-lg @error('subject') border-red-500 @enderror" id="subject" name="subject" type="text" placeholder="{{ __('contacts.subject_placeholder') }}" value="{{ old('subject') }}" required />
                            @error('subject')
                                <span class="text-red-500 text-sm" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="message sm:col-span-2">
                            <textarea class="border-line px-4 pt-3 pb-3 w-full rounded-lg @error('message') border-red-500 @enderror" id="message" name="message" rows="3" placeholder="{{ __('contacts.message_placeholder') }}" required>{{ old('message') }}</textarea>
                            @error('message')
                            <span class="text-red-500 text-sm" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="block-button md:mt-6 mt-4">
                        <button class="button-main">{{ trans('contacts.submit_button') }}</button>
                    </div>
                </form>
            </div>
            <div class="right lg:w-1/4 lg:pl-4 max-lg:w-full max-lg:pl-0">
                <div class="item">
                    <div class="heading4 flex items-center gap-2">
                        <i class="ph ph-info"></i> <!-- Icon for our_information -->
                        {{ trans('contactus.ourinformation') }}
                    </div>
                    <p class="mt-3 text-sm lg:text-base">{{ app()->getLocale() === 'ar' ? $contact->adress : $contact->adressen }}</p>
                    <p class="mt-3 text-sm lg:text-base">{{ __('Phone:') }} <span class="whitespace-nowrap">{{ $contact->phonenumber }}</span></p>
                    <p class="mt-1 text-sm lg:text-base">{{ __('Email:') }} <span class="whitespace-nowrap">{{ $contact->email }}</span></p>
                </div>
                <div class="item mt-10">
                    <div class="heading4 flex items-center gap-2">
                        <i class="ph ph-clock"></i> <!-- Icon for open_hours -->
                        {{ trans('contactus.openhours') }}
                    </div>
                    <p class="mt-3 text-sm lg:text-base">{{ app()->getLocale() === 'ar' ? $contact->ourworksa : $contact->ourworkse }}</p>
                </div>
            </div>
        </div>
        <!-- New Map Section -->
        <div class="contact-map mt-10">
            <div class="map-container h-[400px] rounded-lg overflow-hidden shadow-lg">
                <iframe width="100%" height="100%" frameborder="0" class="border-0"
                    src="https://maps.google.com/maps?q={{ $mapLocation['lat'] }},{{ $mapLocation['lng'] }}&z=15&output=embed"
                    allowfullscreen>
                </iframe>
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
