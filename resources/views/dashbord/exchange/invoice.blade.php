<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$exchange->exchangesnumber}} - فاتورة</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }
        .invoice-container {
            width: 80%;
            max-width: 900px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 4px solid #2cb3e8 ;
        }
        .header img {
            max-height: 80px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #2cb3e8 ;
        }
        .details-table, .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table td, .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 16px;
        }
        .items-table th {
            background: #2cb3e8 ;
            color: white;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: left;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        .print-button {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            background: #2cb3e8 ;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
        }
        .print-button:hover {
            background: #2cb3e8 ;
        }
        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }
            .invoice-container {
                width: 100%;
                max-width: 100%;
                box-shadow: none;
                border: none;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="invoice-title">فاتورة مبيعات</div>
            <img src="{{asset('logo.svg')}}" alt="شعار الشركة">
        </div>
        
        <table class="details-table">
          
            <tr>
                <td><strong>رقم الفاتورة:</strong> {{$exchange->exchangesnumber}}</td>
                <td><strong>تاريخ الفاتورة:</strong> {{ \Carbon\Carbon::parse($exchange->created_at)->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td><strong>اسم العميل:</strong> {{ $exchange->full_name }}</td>
                <td><strong>رقم الهاتف:</strong> {{ $exchange->phonenumber }}</td>

            </tr>
            
        </table>
        
        <table class="items-table">
            <thead>
                <tr>
                    <th>اسم المنتج</th>
                    <th>الكمية</th>
                    <th>المقاسات</th>
                    <th>اللون</th>
                    <th>السعر [للقطعة]</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exchangeItems as $item)
                    <tr>
                        <td>{{ $item->products->name }}</td>
                        <td>{{ $item->quantty }}</td>
                        <td>{{ $item->sizes ? $item->sizes->name : 'لا يوجد' }}</td>
                        <td>{{ $item->grades ? $item->grades->name : 'لا يوجد' }}</td>
                        <td>{{ $item->price }} دينار</td>
                        <td>{{ $item->quantty * $item->price }} دينار</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <p class="total">الإجمالي الكلي: {{ $exchange->total_price }} دينار</p>
        
        <div class="footer">
            شكرًا لتعاملكم معنا! | هاتف: {{$contactus->phonenumber}} | بريد إلكتروني: {{$contactus->email}}
        </div>
        
        <button class="print-button" onclick="window.print()">🖨️ طباعة الفاتورة</button>
    </div>
</body>
</html>
