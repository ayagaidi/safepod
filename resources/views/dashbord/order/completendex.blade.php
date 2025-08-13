@extends('layouts.app')
@section('title', 'طلبات مكتمله')

@section('content')


    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('ordersindex') }}">الطلبات</a>/طلبات  مكتمله

            </div>
        </div>
        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض طلبات مكتمله</h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable1"
                            class="table table-bordered table-hover js-basic-example dataTable table-custom"
                            style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>القيمة</th>
                                    <th>اسم الزبون</th>

                                    <th>رقم هاتف الزبون</th>
                                    <th>العنوان </th>


                                    <th>حالة الطلب</th>
                                    <th>تاريخ الطلب</th>

                                    <th> تفاصيل الطلب</th>


                                  

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
                                            ajax: '{!! route('complete/oreders') !!}',
                                            columns: [{
                                                    data: 'ordersnumber'
                                                },
                                                {
                                                    data: 'total_price',
                                                    render: function(data, type, row) {
                                                        return data + " د.ل";
                                                    }
                                                },
                                                {
                                                    data: 'full_name'
                                                },
                                                {
                                                    data: 'phonenumber'
                                                },
                                                {
                                                    data: 'address'
                                                },
                                                   {
                                                    data: 'orderstatues.name'
                                                },

                                                
                                             
                                                {
                                                    data: 'created_at'
                                                },
                                                {
                                                    data: 'orderinfo'
                                                },
                     
                                              

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
