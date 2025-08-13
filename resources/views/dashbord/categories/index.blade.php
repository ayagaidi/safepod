@extends('layouts.app')
@section('title', trans('category.title'))

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                    <a href="{{ route('categories.create') }}"
                        class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">
                        {{ trans('category.add') }}
                    </a>
                
            </div>
        </div>
        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">{{ trans('category.show') }}</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover table-custom">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ trans('category.name_table') }}</th>
                                    <th>{{ trans('category.englishname_table') }}</th>
                                    <th>{{ trans('category.create_date_table') }}</th>
                                    <th>حالة التصنيف</th>

                                    <th>تعدبل</th>
                                    <th> تفعيل/الغاء تفعيل</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>
                                            <a href="{{ asset('images/category/' . $category->image) }}" target="_blank">
                                                <img style="width:150px" src="{{ asset('images/category/' . $category->image) }}" alt="Category Image" class="clickable-image">
                                            </a>
                                        </td>
                                        
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->englishname }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>   {{ $category->active ? "مفعلة" : "معطلة" }}</td>

                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class=""><img src="{{ asset('edit.png') }}" alt="Edit" style="width:26px; height:26px;"></a>
                                        </td>
                                        <th>
                                                <form action="{{ route('categories.changeStatus', encrypt($category->id)) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" style="background: none;border:none">
                                                        
                                                        <img src="{{ asset('refresh.png') }}" alt="Edit" style="width:26px; height:26px;">
                                                        
                                                    </button>
                                                </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#datatable1').dataTable({
                "language": {
                    "url": "../Arabic.json" //arbaic lang

                },
                "lengthMenu": [5, 10],
                "bLengthChange": true, //thought this line could hide the LengthMenu
                serverSide: false,
                paging: false,
                searching: true,
                ordering: false,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',


                dom: 'Blfrtip',

                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [':visible']
                        },
                        text: 'نسخ'
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        },
                        text: 'excel تصدير كـ '

                    },
                    {
                        extend: 'colvis',
                        text: 'الأعمدة'

                    },
                ],

            });

        });
    </script>

@endsection
