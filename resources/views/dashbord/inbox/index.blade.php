@extends('layouts.app')
@section('title', 'عرض البريد')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
           
              
              
            </div>
        </div>
        <div class="row small-spacing">

            <div class="col-md-12">
                <div class="box-content ">
                    <h4 class="box-title">عرض  البريد    </h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable1"
                            class="table table-bordered table-hover js-basic-example dataTable table-custom "
                            style="cursor: pointer;">
                            <thead>
                                <tr>

                                    <th>الاسم </th>
                                    <th>العنوان</th>
                                    <th>البريد الالكتروني</th>
                                    <th>النص  </th>
                                    <th>تاريخ الارسال  </th>

                                    




                                </tr>
                            </thead>
                            <tbody>
                                <script>
                                    $(document).ready(function() {
                                      
                                        var table = $('#datatable1').dataTable({
                                            "language": {
                                                "url": "../Arabic.json" //arbaic lang

                                            },
                                            orderCellsTop: true,
                                            fixedHeader: true,
                                            "lengthMenu": [5, 10],
                                            "bLengthChange": true, //thought this line could hide the LengthMenu
                                            serverSide: false,
                                            paging: true,
                                            searching: false,
                                            ordering: true,
                                            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                                            ajax: '{!! route('inbox/inbox') !!}',

                                            columns: [

                                                {
                                                    data: 'name'
                                                },

                                                {
                                                    data: 'subject'
                                                },

                                                {
                                                    data: 'email'
                                                },
                                                {
                                                    data: 'message'
                                                },
                                             
                                                {
                                                                                                        data: 'edit',

                                                    data: 'created_at'
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
                                                    text: 'excel تصدير كـ '

                                                },
                                                {
                                                    extend: 'colvis',
                                                    text: 'الأعمدة'

                                                },
                                            ],

                                        });



                                        //                        $('#datatable1').DataTable( {

                                        // });

                                    });
                                </script>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
