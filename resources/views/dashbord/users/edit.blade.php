@extends('layouts.app')
@section('title',trans('users.edit'))
@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content ">
            <h4 class="box-title"><a href="{{ route('users') }}">{{trans('app.users')}}</a>/{{trans('users.edit')}}</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form method="POST" class="" action="">
                @csrf
                <div class="row">
                    <div class="form-group  col-md-6"> 
                    <label for="inputName" class="control-label">{{trans('users.username')}}</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ $user->username }}" id="username" placeholder="{{trans('users.username')}}" >
                    @error('username')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
                <div class="form-group  col-md-6"> 
                    <label for="inputName" class="control-label">{{trans('users.first_name')}}</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $user->first_name }}" id="first_name" placeholder="{{trans('users.first_name')}}" >
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
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $user->last_name }}" id="last_name" placeholder="{{trans('users.last_name')}}" >
                    @error('last_name')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
                <div class="form-group  col-md-6"> 
                    <label for="inputEmail" class="control-label">{{trans('users.email')}}</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" id="email" placeholder="{{trans('users.email')}}" >
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
                    <input type="text" name="phonenumber" class="form-control @error('phonenumber') is-invalid @enderror" value="{{ $user->phonenumber }}" id="phonenumber" placeholder="{{trans('users.phonenumber')}}" >
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
                        <option value="{{encrypt($City->id)}}" {{$City->id == $user->cities_id  ? 'selected' : ''}}>{{$City->name}}</option>
                        @endforeach

                    </select>
                    @error('address')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
                </div>
               
                <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{trans('users.editbtn')}}</button>
                </div>
            </form>
        </div>
        <!-- /.box-content -->
    </div>
    <!-- /.col-xs-12 -->
</div>
@endsection