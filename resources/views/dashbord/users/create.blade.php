@extends('layouts.app')
@section('title',trans('users.add'))
@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content ">
            <h4 class="box-title"><a href="{{ route('users') }}">{{trans('app.users')}}</a>/{{trans('users.add')}}</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form method="POST" class="" action="">
                @csrf
                <div class="row">
                <div class="form-group  col-md-6">
                    <label for="inputName" class="control-label">{{trans('users.username')}}</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" id="username" placeholder="{{trans('users.username')}}" >
                    @error('username')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
                <div class="form-group  col-md-6">
                    <label for="inputName" class="control-label">{{trans('users.first_name')}}</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" id="first_name" placeholder="{{trans('users.first_name')}}" >
                    @error('first_name')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group  col-md-6">
                    <label for="inputName" class="control-label">{{trans('users.last_name')}}</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" id="last_name" placeholder="{{trans('users.last_name')}}" >
                    @error('last_name')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
                <div class="form-group  col-md-6">
                    <label for="inputEmail" class="control-label">{{trans('users.email')}}</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" placeholder="{{trans('users.email')}}" >
                    @error('email')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group  col-md-6">
                    <label for="inputName" class="control-label">{{trans('users.phonenumber')}}</label>
                    <input type="text" name="phonenumber" class="form-control @error('phonenumber') is-invalid @enderror" value="{{ old('phonenumber') }}" id="phonenumber" placeholder="{{trans('users.phonenumber')}}" >
                    @error('phonenumber')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
                <div class="form-group  col-md-6">
                    <label for="inputName" class="control-label">{{trans('users.address')}}</label>
                    <select name="address" class="form-control @error('address') is-invalid @enderror  select2  wd-250"  data-placeholder="Choose one" data-parsley-class-handler="#slWrapper" data-parsley-errors-container="#slErrorContainer" required>
                        @forelse ($Cities as $City)
                        <option value="{{encrypt($City->id)}}"> {{$City->name}}</option>
                        @empty
                        <option value=""{{trans('users.city')}}></option>
                        @endforelse
                    </select>
                    @error('address')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group  col-md-6">
                    <label for="inputPassword" class="control-label">{{trans('users.password')}}</label>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <input type="password" name="password"data-minlength="8" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="password" placeholder="{{trans('users.password')}}" >

                            @error('password')
                            <span class="invalid-feedback" style="color: red" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                            <div class="help-block">{{trans('users.8digitsmini')}} </div>
                        </div>
    
                    </div>
                </div>
              
            </div>
           
                <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{trans('users.addbtn')}}</button>
                </div>
            </form>
        </div>
        <!-- /.box-content -->
    </div>
    <!-- /.col-xs-12 -->
</div>
@endsection