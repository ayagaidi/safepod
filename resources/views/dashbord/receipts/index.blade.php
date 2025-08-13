@extends('layouts.app')

@section('title', 'اذن استلام')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('receipts/create') }}" class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3"> 
                    إضافة اذن استلام 
                </a>
            </div>
        </div>

        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض اذن استلام</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>رقم اذن استلام</th>
                                    <th>الاجمالي</th>
                                    <th>عرض التفاصيل</th>
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
            "url": '{{ route('receipts/receipts') }}', // Correct the URL to your API endpoint
            "type": 'GET',  // HTTP method (GET or POST)
            "dataSrc": function (json) {
                return json.data; // Adjust based on the response structure from your API
            }
        },
        "columns": [
            { data: 'receiptnumber', title: 'رقم اذن الاستلام' },  // Fetch Receipt Number
            {
                data: 'total_price', 
                title: 'الإجمالي ', 
                render: function(data, type, row) {
                    return data + ' دينار'; // Append "دينار" to total price
                }
            },
            { data: 'showall', title: 'عرض التفاصيل' },  // Fetch Total Price

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
