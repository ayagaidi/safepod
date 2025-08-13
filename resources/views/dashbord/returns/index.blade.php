@extends('layouts.app')

@section('title', 'الرواجع')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('returns/create') }}"
                    class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">
                    ادارة راجع
                </a>
            </div>
        </div>

        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض الرواجع</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>رقم الراجع</th>
                                    <th>صورة المنتج</th>
                                    <th style="text-align: center">اسم منتج</th>

                                    <th style="text-align: center">المقاسات</th>
                                    <th style="text-align: center">اللون</th>

                                    <th style="text-align: center">الاجمالي</th>
                                    <th style="text-align: center">تاريخ الإرجاع</th>


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
                    "url": "../Arabic.json" // Ensure the path to Arabic JSON file is correct
                },
                "lengthMenu": [5, 10], // Set the page length options
                "bLengthChange": true, // Allow users to change page length
                "serverSide": true, // Enable server-side processing
                "ajax": {
                    "url": '{{ route('returns/returns') }}', // Correct the URL to your API endpoint
                    "type": 'GET', // HTTP method (GET or POST)
                    "dataSrc": function(json) {
                        return json.data; // Adjust based on the response structure from your API
                    }
                },
                "columns": [
                    {
                        data: 'exchanges.exchangesnumber'
                    }, // رقم الراجع
                    {
                        data: 'products.image',
                        render: function(data, type, row) {
                            return `<img src="{{ asset('images/product/') }}/${data}" alt="Product Image" class="img-thumbnail" width="100">`;
                        }
                    },
                    {
                        data: 'products.name'
                    },
                    {
                        data: 'grades.name',
                        render: function(data, type, row) {
                            return data ? data : 'لايوجد'; // 👈 إذا كان null أو undefined يعرض "غير متوفر"
                        }
                    },
                    {
                        data: 'sizes.name',
                        render: function(data, type, row) {
                            return data ? data : 'لايوجد'; // 👈 نفس الفكرة هنا
                        }
                    },
                    {
                        data: 'price',
                        render: function(data, type, row) {
                            return data + ' دينار'; // Append "دينار" to total price
                        }
                    },
                    {
                        data: 'created_at'
                    }
                ],

                "dom": 'Blfrtip', // Defines the table controls (copy, export, etc.)
                "buttons": [{
                        extend: 'copyHtml5',
                        text: 'نسخ'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'تصدير كـ Excel'
                    },
                    {
                        extend: 'colvis',
                        text: 'إظهار الأعمدة'
                    }
                ]
            });
        });
    </script>
@endsection
