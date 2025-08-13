@if(app()->getLocale() === 'ar')
    <div class="body1 text-center md:mt-7 mt-5 leading-relaxed">
        {{ empty($aboutus->dec) ? 'المحتوى غير متوفر' : $aboutus->dec }}
    </div>
@else
    <div class="body1 text-center md:mt-7 mt-5 leading-relaxed">
        {{ empty($aboutus->decen) ? 'Content not available' : $aboutus->decen }}
    </div>
@endif
