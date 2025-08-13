@extends('layouts.app')

@section('title', 'التخفيضات')

@section('content')
<script>
    $(document).on('click', '.removeItem', function() {
    let rowId = $(this).data('idss'); // الحصول على ID التخفيض
    let row = $(this).closest('tr'); // تحديد الصف للحذف بعد نجاح العملية

    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "لن تتمكن من التراجع عن هذا!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "نعم، احذفه!",
        cancelButtonText: "إلغاء"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/discounts/delete/${rowId}`, // رابط الحذف في Laravel
                type: 'get',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // إرسال CSRF Token
                },
                success: function(response) {
                    Swal.fire("تم الحذف!", "تم حذف التخفيض بنجاح.", "success");
                    row.remove(); // حذف الصف من الجدول
                },
                error: function() {
                    Swal.fire("خطأ!", "حدث خطأ أثناء الحذف.", "error");
                }
            });
        }
    });
});

</script>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('discounts/create') }}"
                    class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3">
                    إضافة تخفيض
                </a>
            </div>
        </div>

        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض التخفيضات</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>barcode </th>
                                    <th>االمنتج</th>
                                    <th>السعر</th>
                                    <th>نسبة التخفيض</th>
                                    <th>السعر بعد التخفيض</th>
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
                    "url": "../Arabic.json" // Ensure the path to Arabic JSON file is correct
                },
                "lengthMenu": [5, 10], // Set the page length options
                "bLengthChange": true, // Allow users to change page length
                "serverSide": true, // Enable server-side processing
                "ajax": {
                    "url": '{{ route('discounts/discounts') }}', // Correct the URL to your API endpoint
                    "type": 'GET', // HTTP method (GET or POST)
                    "dataSrc": function(json) {
                        return json.data; // Adjust based on the response structure from your API
                    }
                },
                "columns": [{
                        data: 'products.barcode'
                    },

                    {
                        data: 'products.name'
                    }, {
                        data: 'percentage',
                        title: 'نسبة التخفيض',
                        render: function(data, type, row) {
                            return data + ' %';
                        }
                    }
                    , {
                        data: 'products.price',
                        render: function(data, type, row) {
                            return data + ' دينار';
                        }
                    },
                 

{
    data: null,
    title: 'السعر بعد التخفيض',
    render: function(data, type, row) {
        let originalPrice = row.products.price;
        let discountPercentage = row.percentage;
        let discountedPrice = originalPrice - (originalPrice * discountPercentage / 100);
        return discountedPrice.toFixed(2) + ' دينار';
    }
}
,{
    data: null,
    title: 'إجراء',
    orderable: false,
    searchable: false,
    render: function(data, type, row) {
        return `
            <button type="button" class="btn btn-danger removeItem" data-idss="${data.discountid}">
                <i class="fa fa-trash"></i> حذف
            </button>
        `;
    }
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
