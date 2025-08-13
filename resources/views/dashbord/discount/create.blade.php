@extends('layouts.app')

@section('title', 'إضافة تخفيض')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('discounts') }}">التخفيضات</a> / إضافة تخفيض
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="box-content">
                <h4 class="box-title">تخفيض</h4>

                <form method="POST" action="{{ route('discounts/store') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <video id="barcodeScanner" style="width: 100%; display: none;"></video>

                            <label for="items_id" class="control-label">Barcode</label>
                            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                                value="{{ old('barcode') }}" id="barcode" placeholder="الباركود">
                            @error('barcode')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3 align-self-end" style="margin-top:30px">
                            <button type="button" id="startScan" class="btn btn-primary btn-block d-flex align-items-center justify-content-center">
                                <img src="{{ asset('barcode.png') }}" alt="Scan" style="width: 24px; height: 24px; margin-right: 5px;">
                                مسح الباركود
                            </button>
                        </div>
                        
                        <div class="form-group col-md-3 align-self-end" style="margin-top:30px">
                            <button type="button" id="search" class="btn btn-primary btn-block d-flex align-items-center justify-content-center">
                                <img src="{{ asset('search.png') }}" alt="Search" style="width: 24px; height: 24px; margin-right: 5px;">
                                بحث
                            </button>
                        </div>
                        
                    </div>
                    <div class="row">
                        <!-- قائمة  المنتج -->

                        <div class="form-group col-md-4">
                            <label for="items_id" class="control-label">المنتج</label>
                            <input type="text" name="products_id" class="form-control @error('products_id') is-invalid @enderror"
                                value="{{ old('products_id') }}" id="products_id" placeholder="المنتج">
                            @error('products_id')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                            <!-- حقل مخفي لتخزين معرف المنتج -->
                            <input type="hidden" name="proudatid" id="proudatid" value="{{ old('proudatid') }}">
                        </div>
                        


                        <!-- إدخال الكمية -->
                        <div class="form-group col-md-4">
                            <label for="percentage" class="control-label">نسبة التخفيض</label>
                            <input type="number" name="percentage" class="form-control" id="percentage" min="1"
                                placeholder="نسبة التخفيض">
                        </div>

                       

                        <!-- زر الإضافة -->
                        <div class="form-group col-md-4 align-self-end" style="margin-top:30px">
                            <button type="submit"  class="btn btn-primary btn-block">إضافة تخفيض</button>
                        </div>
                    </div>

                   
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#startScan').on('click', function() {
                $('#barcodeScanner').show(); // إظهار الفيديو

                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: document.querySelector("#barcodeScanner"), // عنصر الفيديو
                        constraints: {
                            facingMode: "environment" // استخدام الكاميرا الخلفية
                        }
                    },
                    decoder: {
                        readers: ["code_128_reader", "ean_reader",
                            "ean_8_reader"
                        ] // أنواع الباركود المدعومة
                    }
                }, function(err) {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    Quagga.start();
                });

                // معالجة النتيجة بعد قراءة الباركود
                Quagga.onDetected(function(result) {
                    var barcode = result.codeResult.code;
                    $('#barcode').val(barcode); // تعبئة حقل الباركود
                    $('#barcodeScanner').hide(); // إخفاء الكاميرا بعد القراءة
                    Quagga.stop(); // إيقاف المسح بعد العثور على الباركود
                });
            });
            // 
            $('#search').on('click', function() {
                var barcode = $('#barcode').val().trim();

                if (barcode === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تنبيه!',
                        text: 'يرجى إدخال الباركود قبل البحث.',
                        confirmButtonText: 'حسناً'
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('discounts/getproudact') }}",
                    type: "GET",
                    data: {
                        barcode: barcode
                    },
                    success: function(response) {
                            $('#products_id').val(response.products.name);   
                            $('#proudatid').val(response.products.id);
                        },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: xhr.responseJSON ? xhr.responseJSON.error :
                                'حدث خطأ أثناء البحث.',
                            confirmButtonText: 'حسناً'
                        });
                    }
                });
            });



         
        });
    </script>
  
@endsection
