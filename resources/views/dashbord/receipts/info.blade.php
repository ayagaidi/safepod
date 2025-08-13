@extends('layouts.app')

@section('title', 'تفاصيل إذن استلام')

@section('content')

    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content text-right">
                <a href="{{ route('receipts') }}">إذن استلام</a> / تفاصيل إذن استلام {{ $receipt->receiptnumber }}
            </div>
        </div>

        <!-- زر الطباعة -->
        <div class="col-md-12 mt-2  mp-2 text-left">
            <button class="btn btn-primary" style="margin-bottom: 10px;" onclick="printReceipt()">
                <i class="fa fa-print"></i> طباعة
            </button>
        </div>

        <!-- قسم الطباعة -->
        <div class="col-md-12 mt-4 printable-section" id="printableSection">
            <div class="box-content text-center" style="border: 1px solid #ddd; padding: 20px; background: white;">
                
                <!-- شعار الشركة -->
                <div class="text-center">
                    <img src="{{ asset('colorico.ico') }}" alt="شعار الشركة" style="max-width: 150px; margin-bottom: 20px;">
                </div>
                
                <h4 class="box-title" style="color: #2cb3e8 ; font-size: 24px; font-weight: bold; margin-bottom: 20px;">تفاصيل إذن الاستلام</h4>

                <div class="text-right" style="margin-bottom: 20px;">
                    <p><strong>رقم إذن الاستلام:</strong> {{ $receipt->receiptnumber }}</p>
                    <p><strong>التاريخ:</strong> {{ \Carbon\Carbon::parse($receipt->created_at)->format('Y-m-d H:i') }}</p>                 
                    <p><strong>الإجمالي:</strong> {{ number_format($receipt->total_price, 2) }} دينار</p>
                </div>

                <!-- جدول العناصر -->
                <table class="table table-bordered text-center">
                    <thead style="text-align: center">
                        <tr style="background: #2cb3e8 ; color: white;">
                            <th style="text-align: center">Barcode</th>
                            <th style="text-align: center">صورة المنتج</th>
                            <th style="text-align: center">اسم منتج</th>
                            <th style="text-align: center">المقاسات</th>
                            <th style="text-align: center">اللون</th>
                            <th style="text-align: center">الكمية</th>
                            <th style="text-align: center">السعر [للقطعة]</th>
                            <th style="text-align: center">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receiptItems as $item)
                            <tr>
                                <td>{{ $item->products->barcode }}</td>
                                <td>
                                    <img src="{{ asset('images/product/' . $item->products->image) }}" alt="Product Image" class="img-thumbnail" width="100">
                                </td>
                                <td>{{ $item->products->name }}</td>
                                <td>{{ $item->grades?->name ?? 'لا يوجد' }}</td>
                                <td>{{ $item->sizes?->name ?? 'لا يوجد' }}</td>
                                <td>{{ $item->quantty }}</td>
                                <td>{{ number_format($item->price, 2) }} دينار</td>
                                <td>{{ number_format($item->quantty * $item->price, 2) }} دينار</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            var content = document.getElementById('printableSection').innerHTML;
            var newWindow = window.open('', '', 'width=800,height=600');
    
            newWindow.document.write('<html><head><title>طباعة إذن الاستلام</title>');
            newWindow.document.write('<link rel="stylesheet" href="{{ asset('css/app.css') }}">');
            newWindow.document.write('<style>');
            newWindow.document.write('body { font-family: Arial, sans-serif; text-align: right; direction: rtl; }');
            newWindow.document.write('.table { width: 100%; border-collapse: collapse; border: 1px solid #000; }');
            newWindow.document.write('.table th, .table td { border: 1px solid #000; padding: 8px; text-align: center; }');
            newWindow.document.write('.table th { background-color: #2cb3e8 ; color: white; }');
            newWindow.document.write('img { display: block; margin: 0 auto 20px; }');
            newWindow.document.write('</style>');
    
            newWindow.document.write('</head><body>');
            newWindow.document.write(content);
            newWindow.document.write('</body></html>');
    
            newWindow.document.close();
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        }
    </script>
    
@endsection