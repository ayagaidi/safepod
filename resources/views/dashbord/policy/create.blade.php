@extends('layouts.app')

@section('title', 'سياسة الاجراء')

@section('content')
<div class="row small-spacing">
     <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">
                    <a href="{{ route('policy.index') }}">سياسة الاجراء</a>/إضافة سياسة جديدة
                </h4>
            </div>
        </div>
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title"></h4>
            <form method="POST" action="{{ route('policy.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title_ar">العنوان (عربي)</label>
                    <input type="text" name="title_ar" class="form-control" id="title_ar" required>
                </div>
                <div class="form-group">
                    <label for="title_en">العنوان (إنجليزي)</label>
                    <input type="text" name="title_en" class="form-control" id="title_en" required>
                </div>
                <div class="form-group">
                    <label for="description_ar">الوصف (عربي)</label>
                    <textarea name="description_ar" class="form-control" id="description_ar" required></textarea>
                </div>
                <div class="form-group">
                    <label for="description_en">الوصف (إنجليزي)</label>
                    <textarea name="description_en" class="form-control" id="description_en" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">إضافة</button>
            </form>
        </div>
    </div>
 
</div>
@endsection
