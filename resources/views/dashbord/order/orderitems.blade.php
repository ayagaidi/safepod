@extends('layouts.app')
@section('title', 'تفاصيل الطلب')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <a href="{{ route('orderitem', encrypt($order->id)) }}">الطلبات</a>/تفاصيل الطلب {{$order->ordersnumber}}
        </div>
    </div>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">تفاصيل الطلب</h4>
                <div class="order-details">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>الإجمالي</th>
                                <th>الاسم الكامل</th>
                                <th>رقم الهاتف</th>
                                <th>العنوان</th>
                                <th>تاريخ الطلب</th>
                                <th>حالة الطلب</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $order->ordersnumber }}</td>
                                <td>{{ $order->total_price }}</td>
                                <td>{{ $order->full_name }}</td>
                                <td>{{ $order->phonenumber }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->orderstatues->name ?? 'لايوجد' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if($order->orderstatues->id == 1)
                    <form action="{{ route('order.update', encrypt($order->id)) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        <h4 class="box-title">تفاصيل عناصر الطلب</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>الصورة</th>
                                        <th>المنتج</th>
                                        <th>اللون</th>
                                        <th>الحجم</th>
                                        <th>المخزون المتوفر</th>
                                        <th>الكمية المطلوبة</th>
                                        <th>السعر</th>
                                        <th>إزالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ordersitem as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('images/product/' . $item->products->image) }}" alt="Product Image" class="img-thumbnail" width="100">
                                        </td>
                                        <td>{{ $item->products->name }}</td>
                                        <td>{{ $item->grades->name ?? 'غير محدد' }}</td>
                                        <td>{{ $item->sizes->name ?? 'غير محدد' }}</td>
                                        <td>{{ $item->availableStock > 0 ? $item->availableStock : 0 }}</td>
                                        <td>
                                            <input type="number" name="quantities[{{ $item->id }}]" value="{{ $item->quantty }}" min="1" max="{{ $item->availableStock }}" class="form-control form-control-sm">
                                        </td>
                                        <td>{{ $item->price }} د.ل</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeItemFromOrder({{ $item->id }}, '{{ route('order.item.remove', encrypt($item->id)) }}')">إزالة</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5 me-2">
                                <i class="fa fa-refresh"></i> تحديث الطلبية
                            </button>
                            @if($order->orderstatues->id != 4)
                                <a href="javascript:void(0)" class="btn btn-danger btn-lg px-5 me-2" onclick="confirmCancel('{{ route('pending/cancelfunction', encrypt($order->id)) }}')">
                                    <i class="fa fa-times"></i> إلغاء الطلبية
                                </a>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        document.querySelector('.btn-danger').addEventListener('click', function () {
                                            Swal.fire({
                                                title: 'تم الإلغاء!',
                                                text: 'تم إلغاء الطلبية بنجاح.',
                                                icon: 'success',
                                                confirmButtonText: 'حسنًا'
                                            });
                                        });
                                    });
                                </script>
                            @endif
                        </div>
                    </form>
                @else
                    <h4 class="box-title mt-4">تفاصيل عناصر الطلب (عرض فقط)</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>الصورة</th>
                                    <th>المنتج</th>
                                    <th>اللون</th>
                                    <th>الحجم</th>
                                    <th>المخزون المتوفر</th>
                                    <th>الكمية المطلوبة</th>
                                    <th>السعر</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordersitem as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/product/' . $item->products->image) }}" alt="Product Image" class="img-thumbnail" width="100">
                                    </td>
                                    <td>{{ $item->products->name }}</td>
                                    <td>{{ $item->grades->name ?? 'غير محدد' }}</td>
                                    <td>{{ $item->sizes->name ?? 'غير محدد' }}</td>
                                    <td>{{ $item->availableStock > 0 ? $item->availableStock : 0 }}</td>
                                    <td>{{ $item->quantty }}</td>
                                    <td>{{ $item->price }} د.ل</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($order->orderstatues->id !== 4)
                  
                    @if(isset($insufficientItems) && !$canProceed)
                        <div class="alert alert-danger mt-4">
                            <h4>لا يمكن وضع الطلبية قيد التنفيذ</h4>
                            <p>المنتجات التالية غير متوفرة بالكميات المطلوبة:</p>
                            <ul>
                                @foreach($insufficientItems as $item)
                                    <li>
                                        المنتج: {{ $item['product_name'] }} - 
                                        اللون: {{ $item['color'] }} - 
                                        الحجم: {{ $item['size'] }} - 
                                        الكمية المطلوبة: {{ $item['required_quantity'] }} - 
                                        الكمية المتوفرة: {{ $item['available_stock'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif

                @if($canProceed && $order->orderstatues->id == 1)
                    <form action="{{ route('pending/preparationfuction', encrypt($order->id)) }}" method="POST" class="mt-4 text-center">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fa fa-play"></i> وضع الطلبية قيد التجهيز
                        </button>
                    </form>
                @endif

                @if($order->orderstatues->id == 2)
                    <form action="{{ route('order.complete', encrypt($order->id)) }}" method="POST" class="mt-4 text-center">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            <i class="fa fa-check"></i> جعل الطلبية مكتملة
                        </button>
                    </form>
                    <form action="{{ route('pending/cancelfunction', encrypt($order->id)) }}" method="POST" class="mt-4 text-center">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg px-5">
                            <i class="fa fa-times"></i> إلغاء الطلبية
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function removeItem(itemId) {
        Swal.fire({
            title: 'هل تريد إزالة هذا العنصر من الطلبية؟',
            text: "لن تتمكن من التراجع عن هذا الإجراء!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، قم بالإزالة',
            cancelButtonText: 'لا'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(`input[name="quantities[${itemId}]"]`).value = 0;
            }
        });
    }

    function confirmCancel(url) {
        Swal.fire({
            title: 'هل تريد إلغاء هذه الطلبية؟',
            text: "لن تتمكن من التراجع عن هذا الإجراء!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، قم بالإلغاء',
            cancelButtonText: 'لا'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        Swal.fire(
                            'تم الإلغاء!',
                            'تم إلغاء الطلبية بنجاح.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'خطأ!',
                            'حدث خطأ أثناء إلغاء الطلبية.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    function removeItemFromOrder(itemId, url) {
        Swal.fire({
            title: 'هل تريد إزالة هذا العنصر من الطلبية؟',
            text: "لن تتمكن من التراجع عن هذا الإجراء!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، قم بالإزالة',
            cancelButtonText: 'لا'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        Swal.fire(
                            'تم الإزالة!',
                            'تمت إزالة العنصر من الطلبية.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'خطأ!',
                            'حدث خطأ أثناء إزالة العنصر.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
@endsection
