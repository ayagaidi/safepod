@extends('layouts.app')
@section('title', 'اعلان التخفيض')

@section('content')
<script>
    $(document).ready(function () {
        $('#yourTableId').on('click', '.delete-button', function () {
            const button = $(this);
            const id = button.data('id');

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'لا يمكن التراجع بعد الحذف!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/salesbanners/delete/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire('تم الحذف!', '', 'success');
                            $('#yourTableId').DataTable().ajax.reload(); // إعادة تحميل الجدول
                        },
                        error: function () {
                            Swal.fire('خطأ!', 'حدث خطأ أثناء الحذف.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">

                <a type="button" href="{{ route('salesbanners/create') }}"
                    class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3 ">اضافة اعلان التخفيض </a>


            </div>
        </div>
        <div class="row small-spacing">

            <div class="col-md-12">
                <div class="box-content ">
                    <h4 class="box-title">عرض اعلان التخفيض </h4>
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable1"
                            class="table table-bordered table-hover js-basic-example dataTable table-custom "
                            style="cursor: pointer;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>العنوان بالعربي</th>
                                    <th>العنوان بالانجليزي</th>



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
                                            ajax: '{!! route('salesbanners/salesbanners') !!}',

                                            columns: [{
                                                    data: 'imge'
                                                },
                                                {
                                                    data: 'tilte'
                                                },
                                                {
                                                    data: 'tilten'
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
