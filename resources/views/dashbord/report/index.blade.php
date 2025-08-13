@extends('layouts.app')

@section('title', 'تقارير المبيعات')

@section('content')


    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">
                    <a href="{{ route('report/all') }}">التقارير</a>/تقارير المبيعات
                </h4>
            </div>
        </div>

        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">بحث</h4>
                    <form id="searchForm" class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="fromDate" class="sr-only">من تاريخ</label>
                            <input type="date" class="form-control" id="fromDate" placeholder="من تاريخ">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="toDate" class="sr-only">إلى تاريخ</label>
                            <input type="date" class="form-control" id="toDate" placeholder="إلى تاريخ">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="operationNumber" class="sr-only">رقم العملية</label>
                            <input type="text" class="form-control" id="operationNumber" placeholder="رقم العملية">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="phoneNumber" class="sr-only">رقم الهاتف</label>
                            <input type="text" class="form-control" id="phoneNumber" placeholder="رقم الهاتف">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="customerName" class="sr-only">اسم العميل</label>
                            <input type="text" class="form-control" id="customerName" placeholder="اسم العميل">
                        </div>
                        <button onclick="onSearchClick()" type="button" class="btn btn-primary mb-2"
                            id="searchButton">بحث</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row small-spacing" id="salesTableContainer" style="display: none;">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض المبيعات</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>رقم العملية</th>
                                    <th>اسم الجهة/الاسم بالكامل</th>
                                    <th>رقم الهاتف</th>

                                    <th>الاجمالي</th>
                                    <th>نوع الصرف</th>
                                    <th>تاريخ البيع</th>

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
        function onSearchClick() {
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            const operationNumber = $('#operationNumber').val();
            const phoneNumber = $('#phoneNumber').val();
            const customerName = $('#customerName').val();

            if (!fromDate && !toDate && !operationNumber && !phoneNumber && !customerName) {
                Swal.fire({
                    title: 'خطأ',
                    text: 'اختر عنصر البحث',
                    icon: 'error'
                });
                return;
            }

            if (fromDate && toDate && fromDate > toDate) {
                Swal.fire({
                    title: 'خطأ',
                    text: 'تأكد أن تاريخ البداية أقل من تاريخ النهاية',
                    icon: 'error'
                });
                return;
            }

            $.ajax({
                url: '{{ route('report.searchSales') }}',
                method: 'GET',
                data: {
                    fromDate: fromDate,
                    toDate: toDate,
                    operationNumber: operationNumber,
                    phoneNumber: phoneNumber,
                    customerName: customerName
                },
                success: function(response) {
                    if (!response.data || response.data.length === 0) { // added: check for null or empty result
                        Swal.fire({
                            title: 'تنبيه',
                            text: 'لا يوجد مبيعات',
                            icon: 'info'
                        });
                        return;
                    }
                    $('#salesTableContainer').show();
                    $('#datatable1 tbody').empty();
                    let total = 0; // added: initialize total

                    $.each(response.data, function(index, sale) {
                        total += parseFloat(sale.total_price); // added: accumulate total
                        const row = '<tr>' +
                            '<td>' + sale.exchangesnumber + '</td>' +
                            '<td>' + sale.full_name + '</td>' +
                            '<td>' + sale.phonenumber + '</td>' +
                            '<td>' + sale.total_price + ' دينار</td>' + // modified
                            '<td>' + sale.exchangestypes.name + '</td>' +
                            '<td>' + sale.created_at + '</td>' +
                            '<td>' + sale.showall + '</td>' +
                            '<td>' + sale.invoice + '</td>' +
                            '</tr>';
                        $('#datatable1 tbody').append(row);
                    });

                    // added: append a row for the total
                    const totalRow = '<tr style="font-weight:bold;">' +
                        '<td colspan="3">الإجمالي</td>' +
                        '<td>' + total.toFixed(2) + ' دينار</td>' + // modified
                        '<td colspan="3"></td>' +
                        '</tr>';
                    $('#datatable1 tbody').append(totalRow);
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'خطأ في جلب البيانات';
                    Swal.fire({
                        title: 'خطأ',
                        text: errorMsg,
                        icon: 'error'
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#datatable1').dataTable({
                "language": {
                    "url": "../../Arabic.json"
                },
                "lengthMenu": [5, 10],
                "bLengthChange": true,
                paging: true,
                searching:false,
                ordering: true,
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
                            columns: ':visible',
                            modifier: {
                                page: 'all',      // export all pages
                                order: 'applied', // maintain ordering
                                search: 'applied' // include searched results
                            }
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
@endsection
