@extends('layouts.app')
@section('title',trans('aboutus.showwho'))

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
           
                 @if(!$ab)
                <a type="button" href="{{ route('aboutus/create') }}"
                        class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3 ">{{ trans('aboutus.addbtn') }}    </a>
                @endif
              
            </div>
        </div>
        <div class="row small-spacing">

            <div class="col-md-12">
                <div class="box-content ">
                    <h4 class="box-title">{{trans('aboutus.showwho')}}  </h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable1"
                            class="table table-bordered table-hover js-basic-example dataTable table-custom "
                            style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>{{trans('aboutus.dec')}}</th>
                                    <th>{{trans('aboutus.decen')}}</th>



                                    <th></th>






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
                                            ajax: '{!! route('aboutus/aboutus') !!}',

                                            columns: [

                                                {
                                                    data: 'dec'
                                                },
                                                {
                                                    data: 'decen'
                                                },
                                                

                                                {
                                                                                                        data: 'edit',

                                                    data: 'edit'
                                                },


                                            ],

                                            dom: 'Blfrtip',

                                            buttons: [{
                                                    extend: 'copyHtml5',
                                                    exportOptions: {
                                                        columns: [':visible']
                                                    },
                                                },
                                                {
                                                    extend: 'excelHtml5',
                                                    exportOptions: {
                                                        columns: ':visible'
                                                    },

                                                },
                                                {
                                                    extend: 'colvis',

                                                },
                                            ],

                                        });




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
