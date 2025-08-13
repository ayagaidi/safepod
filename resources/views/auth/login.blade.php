@extends('layouts.authapp')
@section('title',"تسجيل الدخول")

@section('content')
    <form method="POST" class="frm-single" action="">
        @csrf

        <div class="inside">
            <h2 style="color: #00558c; text-align: center; padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd; margin-bottom: 20px;">{{trans('login.login')}}</h2>
            
            <div class="frm-input" style="margin-bottom: 15px;">
                <input type="text" name="email" placeholder="{{trans('login.email')}}" class="frm-inp form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                <i class="fa fa-user frm-ico"></i>
            </div>
            @error('email')
            <span class="invalid-feedback" style="color: red" role="alert">
                {{ $message }}
            </span>
            @enderror

            <div class="frm-input" style="margin-bottom: 15px;">
                <input type="password" name="password" placeholder="{{trans('login.password')}}" class="frm-inp form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                <i class="fa fa-lock frm-ico"></i>
            </div>
            @error('password')
            <span class="invalid-feedback" style="color: red" role="alert">
                {{ $message }}
            </span>
            @enderror

            <div class="form-group row" style="margin-bottom: 15px;">
                <div class="col-md-8">
                    <div class="captcha" align="center" style="padding: 3px">
                        <span>{!! captcha_img() !!}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" onclick="refreshcaptcha()" style="background: #00558c; border: none; color: white; padding: 8px 10px; border-radius: 5px;" class="btn btn-primary btn-block btn-signin">
                        <i class="fa fa-refresh" id="refresh"></i>
                    </button>
                </div>
            </div>

            <div class="form-group mg-b-50" style="margin-bottom: 20px;">
                <input id="captcha" type="captcha" class="form-control @error('captcha') is-invalid @enderror" placeholder="الرجاء إدخال الرمز" name="captcha">
                @error('captcha')
                <span class="invalid-feedback" style="color: red" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button style="background-color: #00558c; color: white; border: none; padding: 10px 20px; border-radius: 5px; width: 100%; font-size: 16px;" type="submit" class="frm-submit">
                {{trans('login.login')}} <i class="fa fa-arrow-circle-right"></i>
            </button>
            <a style="color: #00558c; display: block; text-align: center; margin-top: 10px; font-size: 14px;" href="{{ route('password.request') }}" class="a-link">
                <i class="fa fa-unlock-alt"></i> {{trans('login.forgetpassword')}}?
            </a>
        </div>
        <div style="color: #333; text-align: center; margin-top: 20px; font-size: 14px;" class="frm-footer">
            <?php echo date("Y"); ?> &copy; safePod
        </div>
    </form>

<script>
    function refreshcaptcha(){
        $.ajax({
            type: 'GET',
            url: 'refreshcaptcha',
            success: function(data){
                $(".captcha span").html(data.captcha);
            }
        });
    }
</script>
@endsection
