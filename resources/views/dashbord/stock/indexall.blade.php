@extends('layouts.app')

@section('title', 'المخزون')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title"><a href="{{route('stock')}}"> مخزون    </a>مخزون المنتج {{$products->name}} </h4>
            </div>
        </div>

        <div class="row small-spacing">
            <div class="col-md-12">
                <div class="box-content">
                    <h4 class="box-title">عرض المخزون</h4>
                    <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered table-hover dataTable table-custom">
                            <thead>
                                <tr>
                                    <th>اللون  </th>

                                <th>المقاسات  </th>

                                <th>العدد</th>
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
                    "url": "../Arabic.json"
                },
                "lengthMenu": [5, 10],
                "bLengthChange": true,
                "serverSide": true,
                ajax: '{!! route('stock/stockall', ['id' => $products->id]) !!}',

                "columns": [{ 
            data: 'gradename', 
            name: 'gradename',
            render: function(data, type, row) {
                return data ? data : 'لايوجد'; // If null, show "لايوجد"
            }
        },
        { 
            data: 'sizename', 
            name: 'sizename',
            render: function(data, type, row) {
                return data ? data : 'لايوجد'; // If null, show "لايوجد"
            }
        },
                    	
                    {
                        data: 'total_quantity'
                    },
                    
                    { 
                        data: 'total_quantity', 
                        render: function (data, type, row) {
                            if (data == 0) {
                                return '<span style="font-weight: bold; color:red;">Out of Stock</span>';
                            } else if (data < 10) {
                                return '<span style="font-weight: bold; color:orange;">Low Stock</span>';
                            } else {
                                return '<span style="font-weight: bold; color:green;">Instock</span>';
                            }
                        }
                    }
                   
                ],

            
                "dom": 'Blfrtip',
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
