@extends('layouts.app')

@section('title', 'إضافة إذن استلام')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('receipts') }}">إذن استلام</a> / إضافة إذن استلام
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="box-content">
                <h4 class="box-title">إذن استلام</h4>

                <form method="POST" action="{{ route('receipts/store') }}">
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
                            <button type="button" id="startScan"
                                class="btn btn-primary btn-block d-flex align-items-center justify-content-center">
                                <img src="{{ asset('barcode.png') }}" alt="Scan"
                                    style="width: 24px; height: 24px; margin-right: 5px;">
                                مسح الباركود
                            </button>
                        </div>

                        <div class="form-group col-md-3 align-self-end" style="margin-top:30px">
                            <button type="button" id="search"
                                class="btn btn-primary btn-block d-flex align-items-center justify-content-center">
                                <img src="{{ asset('search.png') }}" alt="Search"
                                    style="width: 24px; height: 24px; margin-right: 5px;">
                                بحث
                            </button>
                        </div>

                    </div>
                    <div class="row">
                        <!-- قائمة  المنتج -->

                        <div class="form-group col-md-2">
                            <label for="items_id" class="control-label">المنتج</label>
                            <select name="items_id" id="items_id" class="form-control">

                            </select>
                        </div>


                        <!-- قائمة اختيار اللون -->
                        <div class="form-group col-md-2">
                            <label for="grades_id" class="control-label">اللون</label>
                            <select name="grades_id" id="grades_id" class="form-control">
                                <option value="">اختر اللون</option>
                            </select>
                        </div>

                        <!-- قائمة اختيار المقاسات -->
                        <div class="form-group col-md-2">
                            <label for="sizes_id" class="control-label">المقاسات</label>
                            <select name="sizes_id" id="sizes_id" class="form-control">
                                <option value="">اختر المقاسات</option>
                            </select>
                        </div>

                        <!-- إدخال الكمية -->
                        <div class="form-group col-md-2">
                            <label for="quantty" class="control-label">الكمية</label>
                            <input type="number" name="quantty" class="form-control" id="quantty" min="1"
                                placeholder="أدخل الكمية">
                        </div>

                        <!-- إدخال السعر -->
                        <div class="form-group col-md-2">
                            <label for="itemPrice" class="control-label">السعر (للقطعة)</label>
                            <input type="number" name="itemPrice" class="form-control" id="itemPrice" placeholder="السعر">
                        </div>

                        <!-- زر الإضافة -->
                        <div class="form-group col-md-2 align-self-end" style="margin-top:30px">
                            <button type="button" id="addItem" class="btn btn-primary btn-block">إضافة العنصر</button>
                        </div>
                    </div>

                    <!-- جدول عرض العناصر -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>اللون</th>
                                    <th>المقاسات</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>الإجمالي</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <div class="row mt-2">
                            <div class="col-md-12 text-right">
                                <strong>الإجمالي:</strong> <span id="totalAmount">0</span> دينار
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="items" id="itemsInput">

                    <div class="form-group col-md-12 text-left">
                        <button type="submit" class="btn btn-primary">إضافة</button>
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
                    url: "{{ route('get/grades/sizes') }}",
                    type: "GET",
                    data: {
                        barcode: barcode
                    },
                    success: function(response) {
                        // Clear existing items in the items_id select
                        $('#items_id').empty();
                        // معالجة الألوان (grades)
                        if (response.items_id) {
                            $('#items_id').append(
                                `<option value="${response.items_id}">${response.name}</option>`
                            );
                        }

                        $('#grades_id').empty();
                        if (response.grades.length > 0) {
                            $('#grades_id').append('<option value="">اختر اللون</option>');
                            $.each(response.grades, function(key, grade) {
                                $('#grades_id').append(
                                    `<option style="color: ${grade.color};" value="${grade.id}"><label style="color: ${grade.color};"></label> ${grade.name}</option>`
                                );
                            });
                        } else {
                            $('#grades_id').append('<option value="">لا يوجد</option>');
                        }

                        // معالجة المقاساتات (sizes)
                        $('#sizes_id').empty();
                        if (response.sizes.length > 0) {
                            $('#sizes_id').append('<option value="">اختر المقاسات</option>');
                            $.each(response.sizes, function(key, size) {
                                $('#sizes_id').append(
                                    `<option value="${size.id}">${size.name}</option>`
                                );
                            });
                        } else {
                            $('#sizes_id').append('<option value="">لا يوجد</option>');
                        }
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


            $('#addItem').click(function() {
                var itemId = $('#items_id').val();
                var itemName = $('#items_id option:selected').text();
                var gradeId = $('#grades_id').val();
                var gradeName = gradeId ? $('#grades_id option:selected').text() : 'لا يوجد';
                var sizeId = $('#sizes_id').val();
                var sizeName = sizeId ? $('#sizes_id option:selected').text() : 'لا يوجد';
                var quantity = $('#quantty').val();
                var price = $('#itemPrice').val();

                if (!itemId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تنبيه!',
                        text: 'يرجى اختيار المنتج',
                        confirmButtonText: 'حسناً'
                    });
                    return;
                }

                if (!quantity || !price) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تنبيه!',
                        text: 'من فضلك قم باذخال السعر والكمية',
                        confirmButtonText: 'حسناً'
                    });
                    return;
                }
                
                var total = quantity * price;
                var row = `<tr data-id="${itemId}" data-grade-id="${gradeId}" data-size-id="${sizeId}">
                    <td>${itemName}</td>
                    <td>${gradeName}</td>
                    <td>${sizeName}</td>
                    <td>${quantity}</td>
                    <td>${price}</td>
                    <td class="item-total">${total}</td>
                    <td><button type="button" class="removeItem" style="background: none !important; border: none;">
                            <img src="{{ asset('delete.png') }}" alt="حذف" style="width:26px; height:26px;">
                        </button></td>
                </tr>`;

                $('#itemsTable tbody').append(row);
                updateTotal();
            });

            $('#itemsTable').on('click', '.removeItem', function() {
                $(this).closest('tr').remove();
                updateTotal();
            });

            function updateTotal() {
                var total = 0;
                $('.item-total').each(function() {
                    total += parseFloat($(this).text());
                });
                $('#totalAmount').text(total);
            }

            $('form').submit(function() {
                var items = [];
                $('#itemsTable tbody tr').each(function() {
                    items.push({
                        id: $(this).data('id'),
                        grade_id: $(this).data('grade-id') || null,
                        size_id: $(this).data('size-id') || null,
                        quantity: $(this).find('td:nth-child(4)').text(),
                        price: $(this).find('td:nth-child(5)').text()
                    });
                });
                $('#itemsInput').val(JSON.stringify(items));
            });
        });
    </script>
@endsection
