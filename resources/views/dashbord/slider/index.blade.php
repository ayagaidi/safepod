@extends('layouts.app')
@section('title'," Slider")

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
           
                <a type="button" href="{{ route('slider/create') }}"
                        class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3 ">اضافة Slider  </a>
                
              
            </div>
        </div>
        <div class="row small-spacing">

            <div class="col-md-12">
                <div class="box-content ">
                    <h4 class="box-title">عرض Sliders </h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable1"
                            class="table table-bordered table-hover js-basic-example dataTable table-custom "
                            style="cursor: pointer;">
                            <thead>
                                <tr>
<th></th>
                                   


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
                                            ajax: '{!! route('slider/slider') !!}',

                                            columns: [
                                                {
                                                    data: 'imge'
                                                }, 
                                                
                                                

                                                {

                                                    data: 'delete'
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
