@extends('layouts.app')

@section('title', 'تقارير الرجعات')

@section('content')


    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">
                    <a href="{{ route('report/all') }}">التقارير</a>/تقارير الرجعات
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
                        
                        <button onclick="onSearchClick()" type="button" class="btn btn-primary mb-2"
                            id="searchButton">بحث</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row small-spacing" id="salesTableContainer" style="display: none;">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض الراجعات</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>رقم الراجع</th>
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
        function onSearchClick() {
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            const operationNumber = $('#operationNumber').val();
       
            if (!fromDate && !toDate && !operationNumber ) {
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
                url: '{{ route('report.searchreturn') }}',
                method: 'GET',
                data: {
                    fromDate: fromDate,
                    toDate: toDate,
                    operationNumber: operationNumber,
                 
                },
                success: function(response) {
                    if (!response.data || response.data.length === 0) {
                        Swal.fire({
                            title: 'تنبيه',
                            text: 'لا يوجد راجعات',
                            icon: 'info'
                        });
                        return;
                    }
                    $('#salesTableContainer').show();
                    $('#datatable1 tbody').empty();
                    let total = 0;

                    $.each(response.data, function(index, retuerns) {
                        if (retuerns === null) {
                            const nullRow = '<tr><td colspan="6">لا يوجد راعات</td></tr>';
                            $('#datatable1 tbody').append(nullRow);
                            return true;
                        }
                        total += parseFloat(retuerns.price);
                        const row = '<tr>' +
                            '<td>' + retuerns.exchanges.exchangesnumber + '</td>' +
                            '<td>' + retuerns.products.name + '</td>' +
                            '<td>' + (retuerns.grades ? retuerns.grades.name : 'لايوجد') + '</td>' +
                            '<td>' + (retuerns.sizes ? retuerns.sizes.name : 'لايوجد') + '</td>' +
                            '<td>' + retuerns.price + 'دينار</td>' +
                            '<td>' + retuerns.created_at + '</td>' +
                            '</tr>';
                        $('#datatable1 tbody').append(row);
                    });

                    const totalRow = '<tr style="font-weight:bold;">' +
                        '<td colspan="3">الإجمالي</td>' +
                        '<td>' + total.toFixed(2) + ' دينار</td>' +
                        '<td colspan="4"></td>' +
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
                                page: 'all',
                                order: 'applied',
                                search: 'applied'
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
