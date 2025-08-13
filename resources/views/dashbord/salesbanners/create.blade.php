@extends('layouts.app')
@section('title',"اضافة اعلان التخفيض")

@section('content')


<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content ">
            <h4 class="box-title"><a href="{{ route('salesbanners') }}">اعلان التخفيض</a>/ اضافة اعلان التخفيض</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content row">
            <form method="POST" class="" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-12">
                    <label for="inputName" class="control-label">الصورة</label>
                    <input type="file" name="imge" class="form-control @error('imge') is-invalid @enderror"
                           id="imge">
                    @error('imge')
                        <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                    @enderror
                    <span style="color: gray">[يجب ان تكون بمقاس width 780 height 654]</span>

                </div>
                 
                <div class="form-group col-md-12">
                    <label for="inputName" class="control-label">قيمة التخفيض</label>
                    <input type="number" name="value" class="form-control @error('value') is-invalid @enderror"
                           id="value">
                    @error('value')
                        <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                    @enderror

                </div>
                <div class="form-group col-md-12">
                    <label for="inputName" class="control-label">عنوان بالعربية</label>
                    <textarea  id="summernote" name="tilte" class="form-control @error('tilte') is-invalid @enderror" value="" id="tilte" placeholder=" " >{{old('tilte')}}</textarea> 
                        @error('tilte')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
               
                <div class="form-group col-md-12">
                    <label for="inputName" class="control-label">عنوان بالانجليزي </label>
                    <textarea  id="tilten" name="tilten" class="form-control @error('tilten') is-invalid @enderror" value="" id="tilten" placeholder=" " >{{old('tilten')}}</textarea> 
                        @error('tilten')
                    <span class="invalid-feedback" style="color: red" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                </div>
               
                
             
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{trans('city.addbtn')}}</button>
                </div>
            </form>
        </div>
        <!-- /.box-content -->
    </div>
    <!-- /.col-xs-12 -->
</div>
@endsection