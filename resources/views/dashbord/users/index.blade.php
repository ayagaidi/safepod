@extends('layouts.app')
@section('title',trans('app.users'))

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">

        <a type="button" href="{{ route('users/create') }}" class="btn btn-primary btn-bordered waves-effect waves-light col-sm-3 ">{{trans('users.add')}}</a>
        </div>
    </div>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content ">
                <h4 class="box-title">عرض المستخدمين </h4>
                <div class="table-responsive" data-pattern="priority-columns">
                <table id="datatable1" class="table table-bordered table-hover js-basic-example dataTable table-custom " style="cursor: pointer;">
                    <thead>
                        <tr>
                            <th>{{trans('users.username')}}</th>
                            <th>{{trans('users.first_name')}}</th>
                            <th>{{trans('users.last_name')}}</th>
                            <th>{{trans('users.email')}}</th>
                            <th>{{trans('users.phonenumber')}}</th>
                            <th>{{trans('users.address')}}</th>

                            <th>{{trans('users.active')}}</th>

                            <th>{{trans('users.created_at')}}</th>

                                    <th> تفعيل/الغاء تفعيل</th>
                                    <th>تعدبل</th>
          

                        </tr>
                    </thead>
                    <tbody>
                        <script>
          
                            $(document).ready( function () {
                           
                               $('#datatable1').dataTable({
                                 "language": {
                                  "url": "../../Arabic.json" //arbaic lang
                           
                                     },
                                     "lengthMenu":[5,10],
                                     "bLengthChange" : true, //thought this line could hide the LengthMenu
                             serverSide: false,
                             paging: true,
                               searching: false,
                               ordering: true,
                               contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                               ajax: '{!! route('users/users')!!}',
                            
                            columns: [
                                     { data: 'username'},
                                     { data: 'first_name'},
                                     { data: 'last_name'},
                                     { data: 'email'},
                                     { data: 'phonenumber'},
                                     { data: 'cities.name'},

                                     {
                        data: 'active', 
              render: function(data) { 
                if(data==1) {
                  return 'الحساب مفعل <i class="fa fa-circle" style="color:#2be71b;;" aria-hidden="true"></i>' 
                }
                else {
                  return 'الحساب معطل <i class="fa fa-circle" style="color:#e71b1b;;" aria-hidden="true"></i>'
                }
                
}},

                                     {data: 'created_at'},

{data: 'changeStatus'},



{data: 'edit'},



                                  ],
  
                                   dom: 'Blfrtip',
  
  buttons: [
  {
  extend: 'copyHtml5',
  exportOptions: {
  columns: [ ':visible' ]
  },
  text:'نسخ'
  },
  {
  extend: 'excelHtml5',
  exportOptions: {
  columns: ':visible'
  },
  text:'excel تصدير كـ '
  
  },
  {
  extend:  'colvis',
  text:'الأعمدة'
  
  },
  ],
                           
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