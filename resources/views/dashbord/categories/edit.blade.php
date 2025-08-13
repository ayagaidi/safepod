@extends('layouts.app')
@section('title', trans('category.edit'))

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">
                <a href="{{ route('categories.index') }}">{{ trans('category.title') }}</a> / {{ trans('category.edit') }}
            </h4>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box-content">
            <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    @if($category->image)
                    <div class="mt-2">
                        <label>الصورة الحالية:</label>
                        <img src="{{ asset('images/category/' . $category->image) }}" alt="Product Image" id="imagePreview" class="img-thumbnail" width="150">
                    </div>
                @else
                    <div class="mt-2">
                        <label>لا توجد صورة حالياً.</label>
                    </div>
                @endif
                    <label for="image" class="control-label">صورة </label>

                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" onchange="previewImage(event)">
                   
                    @error('image')
                        <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputName" class="control-label">{{ trans('category.name') }}</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        value="{{ $category->name }}" 
                        placeholder="{{ trans('category.name') }}" 
                        id="name">
                    @error('name')
                        <span class="invalid-feedback" style="color: red;" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEnglishName" class="control-label">{{ trans('category.englishname') }}</label>
                    <input 
                        type="text" 
                        name="englishname" 
                        class="form-control @error('englishname') is-invalid @enderror" 
                        value="{{ $category->englishname }}" 
                        placeholder="{{ trans('category.englishname') }}" 
                        id="inputEnglishName">
                    @error('englishname')
                        <span class="invalid-feedback" style="color: red;" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ trans('category.editbtn') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
