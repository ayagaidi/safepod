@extends('layouts.app')

@section('title', 'المبيعات')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('exchange/create') }}" class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3"> 
                    إضافة عملية بيع 
                </a>
            </div>
        </div>

        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض المبيعات</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>رقم العملية</th>
                                    <th>اسم الجهة/الاسم بالكامل</th>
                                    <th>الاجمالي</th>
                                    <th>نوع الصرف</th>

                                    <th>عرض التفاصيل</th>
                                    <th>عرض الفاتورة</th>

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
      $(document).ready(function () {
    $('#datatable1').DataTable({
        "language": {
            "url": "../Arabic.json" // Ensure the path to Arabic JSON file is correct
        },
        "lengthMenu": [5, 10],  // Set the page length options
        "bLengthChange": true,  // Allow users to change page length
        "serverSide": true,  // Enable server-side processing
        "ajax": {
            "url": '{{ route('exchange/exchange') }}', // Correct the URL to your API endpoint
            "type": 'GET',  // HTTP method (GET or POST)
            "dataSrc": function (json) {
                return json.data; // Adjust based on the response structure from your API
            }
        },
        "columns": [
            { data: 'exchangesnumber', title: 'رقم بيع' },  // Fetch Receipt Number
            { data: 'full_name', title: 'اسم الجهة/الاسم بالكامل ' },  // Fetch Supplier Name
            {
                data: 'total_price', 
                title: 'الإجمالي ', 
                render: function(data, type, row) {
                    return data + ' دينار'; // Append "دينار" to total price
                }
            },
            { data: 'exchangestypes.name', title: 'نوع الصرف' },  // Fetch Exchange Type
            { data: 'showall', title: 'عرض التفاصيل' },  // Fetch extra detail
            { data: 'invoice', title: 'عرض الفاتورة' }  // Fetch invoice info
        ],

        "dom": 'Blfrtip',  // Defines the table controls (copy, export, etc.)
        "buttons": [
            { extend: 'copyHtml5', text: 'نسخ' },
            { extend: 'excelHtml5', text: 'تصدير كـ Excel' },
            { extend: 'colvis', text: 'إظهار الأعمدة' }
        ]
    });
});

    </script>
@endsection
