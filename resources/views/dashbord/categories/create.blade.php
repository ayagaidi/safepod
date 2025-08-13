@extends('layouts.app')
@section('title', trans('category.add'))

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">{{ trans('category.add') }}</h4>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box-content">
            <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="image" class="control-label">صورة </label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                           id="image">
                    @error('image')
                        <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>{{ trans('category.name') }}</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback" style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ trans('category.englishname') }}</label>
                    <input type="text" name="englishname" class="form-control @error('englishname') is-invalid @enderror" value="{{ old('englishname') }}">
                    @error('englishname')
                        <span class="invalid-feedback" style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ trans('category.addbtn') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
