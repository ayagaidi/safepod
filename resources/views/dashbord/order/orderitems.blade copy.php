@extends('layouts.app')

@section('title', 'تفاصيل الطلبية')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="h5 mb-0">تفاصيل الطلبية</h1>
        </div>
        <div class="card-body">
            @if(isset($insufficientItems) && !$canProceed)
                <div class="alert alert-danger">
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

            <form action="{{ route('order.update', encrypt($order->id)) }}" method="POST" class="mb-4">
                @csrf
                @method('PUT')
                <h2 class="h5 mb-3">عناصر الطلبية</h2>
                <ul class="list-group">
                    @foreach($ordersitem as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>المنتج:</strong> {{ $item->products->name }}<br>
                                <strong>اللون:</strong> {{ $item->grades->name ?? 'غير محدد' }}<br>
                                <strong>الحجم:</strong> {{ $item->sizes->name ?? 'غير محدد' }}<br>
                                <strong>المخزون المتوفر:</strong> {{ $item->products->stock }}
                            </div>
                            <div>
                                <label for="quantity-{{ $item->id }}" class="form-label">الكمية المطلوبة:</label>
                                <input type="number" id="quantity-{{ $item->id }}" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1" max="{{ $item->products->stock }}" class="form-control form-control-sm">
                                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeItem({{ $item->id }})">إزالة</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success">تحديث الطلبية</button>
                </div>
            </form>

            @if($canProceed)
                <form action="{{ route('pending/preparationfuction', encrypt($order->id)) }}" method="POST" class="text-center">
                    @csrf
                    <button type="submit" class="btn btn-primary">وضع الطلبية قيد التنفيذ</button>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    function removeItem(itemId) {
        if (confirm('هل تريد إزالة هذا العنصر من الطلبية؟')) {
            document.querySelector(`input[name="quantities[${itemId}]"]`).value = 0;
        }
    }
</script>
@endsection
