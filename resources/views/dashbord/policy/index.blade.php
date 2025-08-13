@extends('layouts.app')

@section('title', 'السياسات')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            @if(!$policie)
            <a href="{{ route('policy.create') }}" class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">
                إضافة سياسة
            </a>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">عرض السياسات</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>العنوان (عربي)</th>
                            <th>العنوان (إنجليزي)</th>
                            <th>الوصف (عربي)</th>
                            <th>الوصف (إنجليزي)</th>
                            <th>تعديل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($policies as $policy)
                            <tr>
                                <td>{{ $policy->title_ar }}</td>
                                <td>{{ $policy->title_en }}</td>
                                <td>{{ $policy->description_ar }}</td>
                                <td>{{ $policy->description_en }}</td>
                                <td>
                                    <a href="{{ route('policy.edit', $policy->id) }}" class="btn btn-warning">تعديل</a>
                                  
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
