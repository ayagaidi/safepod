@extends('layouts.app')

@section('title', 'تفاصيل عملية بيع')

@section('content')

    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('exchange') }}" >عملية بيع</a> / تفاصيل عملية بيع {{$exchange->exchangesnumber}}
            </div>
        </div>

        <!-- Printable Section for Printing -->
        <div class="col-md-12 mt-4 printable-section">
            <div class="box-content" >
                <h4 class="box-title" style="color: #2cb3e8 ;">تفاصيل عملية بيع</h4>

                <div class="row">
                    <!-- Display Receipt Information -->
                    <div class="col-md-6">
                        <h5><strong>رقم إذن الصرف:</strong> {{ $exchange->exchangesnumber }}</h5>
                        <h5><strong> الاسم بالكامل:</strong> {{ $exchange->full_name }}</h5>
   
                        <h5><strong>التاريخ:</strong> {{ \Carbon\Carbon::parse($exchange->created_at)->format('Y-m-d H:i') }}</h5>                 
                        <h5><strong>الإجمالي:</strong> {{ $exchange->total_price }} دينار</h5>
                        <h5><strong>عملية الصرف من :</strong> {{ $exchange->exchangestypes->name }} </h5>

                    </div>

                    <!-- Display Items -->
                    <div class="col-md-12 mt-3">
                        <h5><strong>العناصر:</strong></h5>
                        <table class="table table-bordered" style="background-color: #ffffff; border-color: #2cb3e8 ;">
                            <thead style="background-color: #2cb3e8 ; color: white;">
                                <tr>
                                    <th>الصورة</th>
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
                                        <td>
                                            <img src="{{ asset('images/product/' . $item->products->image) }}" alt="Product Image" class="img-thumbnail" width="100">
                                        </td>
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
                    </div>
                </div>

               
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .box-title {
            font-size: 1.5em;
            font-weight: bold;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #2cb3e8  !important;
        }

        .table th, .table td {
            text-align: center;
        }

        .table th {
            background-color: #2cb3e8 ;
            color: white;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        .btn-primary {
            background-color: #1cb226 !important;
            border-color: #1cb226 !important;
        }

        .btn-secondary {
            background-color: #2cb3e8  !important;
            border-color: #2cb3e8  !important;
        }

        /* Hide all content except the printable section during print */
        @media print {
            body * {
                visibility: hidden;
            }
            .printable-section, .printable-section * {
                visibility: visible;
            }
            .printable-section {
                position: absolute;
                top: 0;
                left: 0;
            }
        }
    </style>
@endsection

