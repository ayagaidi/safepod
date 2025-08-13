@extends('layouts.app')
@section('title', 'المنتجات')

@section('content')


    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a type="button" href="{{ route('products/create') }}"
                    class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">
                    اضافة منتج
                </a>
            </div>
        </div>
        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض المنتجات</h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable1"
                            class="table table-bordered table-hover js-basic-example dataTable table-custom"
                            style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>صورة الغلاف</th>
                                    <th>التصنيف</th>
                                    <th>BARCODE</th>

                                    <th>اسم المنتج</th>
                                    <th>اسم المنتج (اللغة الانجليزية)</th>
<th>العلامة التجارية</th>
                                    <th>اللون</th>
                                    <th>المقاسات</th>
<th>شرح المنتج (عربي)</th>
<th>شرح المنتج (إنجليزي)</th>

                                    <th>سعر البيع</th>
                                    <th>متاح</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>معرض الصور</th>


                                    <th>متاح/غير متاح</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>

                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    $(document).ready(function() {
                                        $('#datatable1').dataTable({
                                            "language": {
                                                "url": "../../Arabic.json"
                                            },
                                            "lengthMenu": [5, 10],
                                            "bLengthChange": true,
                                            serverSide: true,
                                            paging: true,
                                            searching: true,
                                            ordering: true,
                                            ajax: '{!! route('products/products') !!}',
                                            columns: [{
                                                    data: 'image'
                                                },
                                                {
                                                    data: 'categories.name'
                                                },
                                                {
                                                    data: 'barcode'
                                                },
                                                {
                                                    data: 'name'
                                                },
                                                {
                                                    data: 'namee'
                                                },
                                                {
                                                    data: 'brandname'
                                                },
                                                

                                                {
                                                    data: 'grade'
                                                },
                                                {
                                                    data: 'size'
                                                },
{
    data: 'description_ar',
    render: function(data) {
        return data ? data : '';
    }
},
{
    data: 'description_en',
    render: function(data) {
        return data ? data : '';
    }
},

                                                {
                                                    data: 'price'
                                                },
                                               
                                                {
                                                    data: 'is_available',
                                                    render: function(data) {
                                                        if (data == 1) {
                                                            return 'متوفر <i class="fa fa-circle" style="color:#2be71b;" aria-hidden="true"></i>';
                                                        } else {
                                                            return 'غير متوفر <i class="fa fa-circle" style="color:#e71b1b;" aria-hidden="true"></i>';
                                                        }
                                                    }
                                                },
                                                {
                                                    data: 'created_at'
                                                },
                                                {
                                                    data: 'gallery'
                                                },

                                                {
                                                    data: 'changeStatus'
                                                },
                                                {
                                                    data: 'edit'
                                                },
                                                {
                                                    data: 'delete'
                                                }

                                            ],
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
                                                    text: 'excel تصدير كـ'
                                                },
                                                {
                                                    extend: 'colvis',
                                                    text: 'الأعمدة'
                                                }
                                            ]
                                        });
                                    });
                                </script>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-content -->
            </div>
            <!-- /.col-xs-12 -->
        </div>
    </div>
    
@endsection
