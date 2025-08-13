@extends('layouts.app')

@section('title', 'تعديل بيانات الاتصال')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">
                <a href="{{ route('contactus') }}">اتصل بنا</a> / تعديل
            </h4>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box-content">
            <form method="POST" class="row" action="">
                @csrf

                <!-- Email -->
                <div class="form-group col-md-4">
                    <label for="email" class="control-label">البريد الإلكتروني</label>
                    <input type="text" name="email" maxlength="50" class="form-control @error('email') is-invalid @enderror" value="{{ optional($contactus)->email }}" id="email" placeholder="البريد الإلكتروني">
                    @error('email')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="form-group col-md-4">
                    <label for="phone" class="control-label">رقم الهاتف</label>
                    <input type="text" name="phone" maxlength="50" class="form-control @error('phone') is-invalid @enderror" value="{{ optional($contactus)->phonenumber }}" id="phone" placeholder="رقم الهاتف">
                    @error('phone')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- WhatsApp -->
                <div class="form-group col-md-4">
                    <label for="whatsapp" class="control-label">واتساب</label>
                    <input type="text" name="whatsapp" maxlength="50" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ optional($contactus)->whatsapp }}" id="whatsapp" placeholder="واتساب">
                    @error('whatsapp')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-group col-md-4">
                    <label for="adress" class="control-label">العنوان (بالعربية)</label>
                    <input type="text" name="adress" maxlength="50" class="form-control @error('adress') is-invalid @enderror" value="{{ optional($contactus)->adress }}" id="adress" placeholder="العنوان (بالعربية)">
                    @error('adress')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Additional Address -->
                <div class="form-group col-md-4">
                    <label for="adressen" class="control-label">العنوان (بالإنجليزية)</label>
                    <input type="text" name="adressen" maxlength="50" class="form-control @error('adressen') is-invalid @enderror" value="{{ optional($contactus)->adressen }}" id="adressen" placeholder="العنوان (بالإنجليزية)">
                    @error('adressen')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Latitude -->
                <div class="form-group col-md-4">
                    <label for="lan" class="control-label">خط العرض</label>
                    <input type="text" name="lan" maxlength="50" class="form-control @error('lan') is-invalid @enderror" value="{{ optional($contactus)->lan }}" id="lan" placeholder="خط العرض">
                    @error('lan')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Longitude -->
                <div class="form-group col-md-4">
                    <label for="long" class="control-label">خط الطول</label>
                    <input type="text" name="long" maxlength="50" class="form-control @error('long') is-invalid @enderror" value="{{ optional($contactus)->long }}" id="long" placeholder="خط الطول">
                    @error('long')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Facebook URL -->
                <div class="form-group col-md-4">
                    <label for="facebook_url" class="control-label">رابط فيسبوك</label>
                    <input type="url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror" value="{{ optional($contactus)->facebook_url }}" id="facebook_url" placeholder="رابط فيسبوك">
                    @error('facebook_url')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Instagram URL -->
                <div class="form-group col-md-4">
                    <label for="instagram_url" class="control-label">رابط إنستغرام</label>
                    <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" value="{{ optional($contactus)->instagram_url }}" id="instagram_url" placeholder="رابط إنستغرام">
                    @error('instagram_url')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Twitter URL -->
                <div class="form-group col-md-4">
                    <label for="twitter_url" class="control-label">رابط تويتر</label>
                    <input type="url" name="twitter_url" class="form-control @error('twitter_url') is-invalid @enderror" value="{{ optional($contactus)->twitter_url }}" id="twitter_url" placeholder="رابط تويتر">
                    @error('twitter_url')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- LinkedIn URL -->
                <div class="form-group col-md-4">
                    <label for="linkedin_url" class="control-label">رابط لينكدإن</label>
                    <input type="url" name="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror" value="{{ optional($contactus)->linkedin_url }}" id="linkedin_url" placeholder="رابط لينكدإن">
                    @error('linkedin_url')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- YouTube URL -->
                <div class="form-group col-md-4">
                    <label for="youtube_url" class="control-label">رابط يوتيوب</label>
                    <input type="url" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror" value="{{ optional($contactus)->youtube_url }}" id="youtube_url" placeholder="رابط يوتيوب">
                    @error('youtube_url')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Pinterest URL -->
                <div class="form-group col-md-4">
                    <label for="pinterest_url" class="control-label">رابط بينتيريست</label>
                    <input type="url" name="pinterest_url" class="form-control @error('pinterest_url') is-invalid @enderror" value="{{ optional($contactus)->pinterest_url }}" id="pinterest_url" placeholder="رابط بينتيريست">
                    @error('pinterest_url')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-group col-md-12">
                    <button type="submit" style="margin-top: 33px;" class="btn btn-primary waves-effect waves-light">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection