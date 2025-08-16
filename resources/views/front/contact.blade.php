@extends('front.app')
@section('title', trans('menu.contact_us'))
@section('content')

<div id="menu-department-block" class="menu-department-block relative h-full hidden"></div>

{{-- Breadcrumb --}}
<div class="breadcrumb-block style-shared">
    <div class="breadcrumb-main bg-linear overflow-hidden">
        <div class="container lg:pt-[124px] pt-24 pb-10 relative">
            <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                <div class="text-content">
                    <div class="heading2 text-center">{{ trans('menu.contact_us') }}</div>
                    <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                        <a href="{{ route('/') }}" class="hover:underline">{{ trans('menu.home') }}</a>
                        <i class="ph ph-caret-right text-sm text-secondary2"></i>
                        <div class="text-secondary2 capitalize">{{ trans('menu.contact_us') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact-us md:py-20 py-10">
    <div class="container">
        <div class="flex flex-wrap justify-between max-lg:flex-col gap-y-10">
            {{-- Left: Form (unchanged logic) --}}
            <div class="left lg:w-2/3 lg:pr-4">
                <div class="heading3">{{ trans('contacts.drop_us_a_line') }}</div>
                <div class="body1 text-secondary2 mt-3">{{ trans('contacts.use_form_below') }}</div>

                <form class="md:mt-6 mt-4" method="POST" action="{{ route('send') }}">
                    @csrf
                    <div class="grid sm:grid-cols-2 grid-cols-1 gap-4 gap-y-5">
                        <div class="name">
                            <input
                                class="border-line px-4 py-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                                id="username" name="name" type="text"
                                placeholder="{{ __('contacts.name_placeholder') }}"
                                value="{{ old('name') }}" required />
                            @error('name')
                                <span class="text-red-500 text-sm" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="email">
                            <input
                                class="border-line px-4 pt-3 pb-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                                id="email" name="email" type="email"
                                placeholder="{{ __('contacts.email_placeholder') }}"
                                value="{{ old('email') }}" required />
                            @error('email')
                                <span class="text-red-500 text-sm" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="subject sm:col-span-2">
                            <input
                                class="border-line px-4 py-3 w-full rounded-lg @error('subject') border-red-500 @enderror"
                                id="subject" name="subject" type="text"
                                placeholder="{{ __('contacts.subject_placeholder') }}"
                                value="{{ old('subject') }}" required />
                            @error('subject')
                                <span class="text-red-500 text-sm" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="message sm:col-span-2">
                            <textarea
                                class="border-line px-4 pt-3 pb-3 w-full rounded-lg @error('message') border-red-500 @enderror"
                                id="message" name="message" rows="3"
                                placeholder="{{ __('contacts.message_placeholder') }}" required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-red-500 text-sm" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="block-button md:mt-6 mt-4">
                        <button class="button-main">{{ trans('contacts.submit_button') }}</button>
                    </div>
                </form>
            </div>

            {{-- Right: Info + Hours (styled only, same data) --}}
            <div class="right lg:w-1/4 lg:pl-4 max-lg:w-full max-lg:pl-0">
                {{-- Our Information --}}
                <div class="kid-card info-card">
                    <div class="card-head">
                        <span class="icon-bubble"><i class="ph ph-info"></i></span>
                        <h4 class="heading4 m-0">{{ trans('contactus.ourinformation') }}</h4>
                    </div>

                    <ul class="info-list">
                        <li>
                            <span class="ico"><i class="ph ph-map-pin"></i></span>
                            <div class="meta">
                                <div class="label">{{ __('Address') }}</div>
                                <div class="value">
                                    {{ app()->getLocale() === 'ar' ? $contact->adress : $contact->adressen }}
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="ico"><i class="ph ph-phone"></i></span>
                            <div class="meta">
                                <div class="label">{{ __('Phone') }}</div>
                                <a class="value link" href="tel:{{ $contact->phonenumber }}">{{ $contact->phonenumber }}</a>
                            </div>
                        </li>
                        <li>
                            <span class="ico"><i class="ph ph-envelope-simple"></i></span>
                            <div class="meta">
                                <div class="label">Email</div>
                                <a class="value link" href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </div>
                        </li>
                    </ul>

                    <div class="pill-row">
                        <a class="pill" href="tel:{{ $contact->phonenumber }}">
                            <i class="ph ph-phone"></i><span>{{ __('Call') }}</span>
                        </a>
                        <a class="pill" href="mailto:{{ $contact->email }}">
                            <i class="ph ph-paper-plane-tilt"></i><span>Email</span>
                        </a>
                        @isset($mapLocation['lat'])
                        <a class="pill" target="_blank"
                           href="https://maps.google.com/?q={{ $mapLocation['lat'] }},{{ $mapLocation['lng'] }}">
                            <i class="ph ph-navigation-arrow"></i><span>{{ __('Directions') }}</span>
                        </a>
                        @endisset
                    </div>
                </div>

                {{-- Open Hours --}}
                <div class="kid-card hours-card mt-6">
                    <div class="card-head">
                        <span class="icon-bubble"><i class="ph ph-clock"></i></span>
                        <h4 class="heading4 m-0">{{ trans('contactus.openhours') }}</h4>
                    </div>

                    <div class="hours">
                        <div class="hours-box">
                            {!! nl2br(e(app()->getLocale() === 'ar' ? $contact->ourworksa : $contact->ourworkse)) !!}
                        </div>
                        {{-- <div class="note"><i class="ph ph-info"></i> {{ __('Times may vary on holidays') }}</div> --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Map --}}
        <div class="contact-map mt-10">
            <div class="map-container h-[400px] rounded-lg overflow-hidden shadow-lg">
                <iframe width="100%" height="100%" frameborder="0" class="border-0"
                    src="https://maps.google.com/maps?q={{ $mapLocation['lat'] }},{{ $mapLocation['lng'] }}&z=15&output=embed"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

{{-- Small helper script (kept) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuBlock = document.getElementById('menu-department-block');
    if (menuBlock) menuBlock.classList.toggle('hidden');
});
</script>

{{-- Page-local styles for the right column cards --}}
<style>
/* Card base (matches the product page vibe) */
.kid-card{
  background:#fff; border:1px solid #e9eef3; border-radius:16px; padding:16px;
  box-shadow:0 8px 18px rgba(16,24,40,.06);
}

/* Header with icon bubble */
.card-head{ display:flex; align-items:center; gap:10px; margin-bottom:10px }
.icon-bubble{
  display:inline-grid; place-items:center; width:38px; height:38px; border-radius:999px;
  background:linear-gradient(135deg,#00c2a8 0%, #6ee7f9 100%); color:#fff;
  box-shadow:0 6px 16px rgba(0,0,0,.08)
}
.icon-bubble .ph{ font-size:18px }

/* Contact info list */
.info-list{ display:flex; flex-direction:column; gap:14px; margin:10px 0 14px }
.info-list li{ display:flex; align-items:flex-start; gap:12px }
.info-list .ico{
  width:36px; height:36px; border-radius:10px; display:inline-grid; place-items:center;
  background:#f4fffd; color:#00a28f; border:1px solid #e6f5f2; flex:0 0 auto
}
.info-list .ico .ph{ font-size:18px }
.info-list .meta{ display:flex; flex-direction:column; gap:2px }
.info-list .label{ font-weight:800; color:#0f172a; font-size:.9rem }
.info-list .value{ color:#475569; line-height:1.5; word-break:break-word }
.info-list .value.link{ color:#0ea5e9; font-weight:700; text-decoration:none }
.info-list .value.link:hover{ text-decoration:underline }

/* Quick actions */
.pill-row{ display:flex; flex-wrap:wrap; gap:8px }
.pill{
  display:inline-flex; align-items:center; gap:8px; height:36px; padding:0 12px;
  border-radius:999px; border:1px solid #e7ebf0; background:#fff; font-weight:800; color:#0f172a; text-decoration:none;
  transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease
}
.pill .ph{ font-size:16px }
.pill:hover{ transform:translateY(-2px); border-color:#00c2a8; box-shadow:0 8px 18px rgba(16,24,40,.08) }

/* Hours box */
.hours .hours-box{
  background:#f7fffe; border:1px dashed #b7efe7; color:#0f172a; border-radius:12px; padding:12px;
  line-height:1.7; white-space:pre-line
}
.hours .note{ display:flex; align-items:center; gap:8px; color:#64748b; margin-top:10px; font-size:.9rem }
.hours .note .ph{ font-size:16px }
</style>

@endsection
