@extends('layouts.app')

@section('title', 'المخزون')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title"><a href=""> المخزون   </a> </h4>
            </div>
        </div>

        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض المخزون</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>الصورة</th> <!-- New column for product images -->
                                    <th>Barcode</th>
                                    <th>اسم المنتج</th>
                                    <th>عرض المخزون</th>
                                    <th>التفاصيل</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#datatable1').DataTable({
                "language": {
                    "url": "../Arabic.json"
                },
                "lengthMenu": [5, 10],
                "bLengthChange": true,
                "serverSide": true,
                ajax: '{!! route('stock/stock') !!}',
                "columns": [
                    { 
                        data: 'image', // New column for product images
                        render: function(data, type, row) {
                            return `<img src="${data}" alt="Product Image" class="img-thumbnail" width="100">`;
                        }
                    },
                    { data: 'productsbarcode' },
                    { data: 'productsname' },
                    { data: 'total_quantity' },
                    { data: 'show' },
                    { 
                        data: 'total_quantity', 
                        render: function (data, type, row) {
                            if (data == 0) {
                                return '<span style="font-weight: bold; color:red;">Out of Stock</span>';
                            } else if (data < 10) {
                                return '<span style="font-weight: bold; color:orange;">Low Stock</span>';
                            } else {
                                return '<span style="font-weight: bold; color:green;">Instock</span>';
                            }
                        }
                    }
                ],
                "dom": 'Blfrtip',
                "buttons": [
                    { extend: 'copyHtml5', text: 'نسخ' },
                    { extend: 'excelHtml5', text: 'تصدير كـ Excel' },
                    { extend: 'colvis', text: 'إظهار الأعمدة' }
                ]
            });
        });
    </script>
@endsection
