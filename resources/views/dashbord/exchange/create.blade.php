@extends('layouts.app')

@section('title', 'إضافة عملية بيع')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('exchange') }}">عملية بيع</a> / إضافة عملية بيع
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="box-content">
                <h4 class="box-title">عملية بيع</h4>

                <form method="POST" action="{{ route('exchange/store') }}">
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
                        <div class="form-group col-md-3">
                            <label for="full_name" class="control-label">اسم الزبون</label>
                            <input type="text" name="full_name"
                                class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}"
                                id="full_name" placeholder="أدخل اسم الزبون بالكامل">
                            @error('full_name')
                                <span class="invalid-feedback" role="alert" style="color: red">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="full_name" class="control-label">رقم هاتف الزبون</label>
                            <input type="text" name="phonenumber"
                                class="form-control @error('phonenumber') is-invalid @enderror"
                                value="{{ old('phonenumber') }}" id="phonenumber" placeholder="أدخل رقم هاتف بالكامل">
                            @error('phonenumber')
                                <span class="invalid-feedback" role="alert" style="color: red">
                                    {{ $message }}
                                </span>
                            @enderror
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
                            <input type="number" name="itemPrice" class="form-control" id="itemPrice"
                                placeholder="السعر">
                        </div>

                        <!-- زر الإضافة -->
                        <div class="form-group col-md-2 align-self-end" style="margin-top:30px">
                            <button type="button" id="addItem" class="btn btn-primary btn-block">إضافة العنصر</button>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
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
                        <button type="submit" class="btn btn-primary waves-effect waves-light">إضافة</button>
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
                    url: "{{ route('exchange/stockall') }}",
                    type: "GET",
                    data: {
                        barcode: barcode
                    },
                    success: function(response) {
                        console.log(response);
                        // Clear existing items in the items_id select
                        $('#items_id').empty();
                        // معالجة الألوان (grades)
                        if (response.items_id) {

                            $('#items_id').append(
                                `<option value="${response.items_id}"  data-stock="${response.total_stock}">${response.name}</option>`
                            );
                        }

                        if (response.price) {
                            $('#itemPrice').val(response.price)

                        }



                        $('#grades_id').empty();
                        if (response.grades.length > 0) {
                            $('#grades_id').append('<option value="">اختر اللون</option>');
                            $.each(response.grades, function(key, grade) {
                                $('#grades_id').append(
                                        `<option value="${grade.id}" data-stock="${grade.stock}">${grade.name || 'لا يوجد'} (المتوفر: ${grade.stock})</option>`
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
                                        `<option value="${size.id}" data-stock="${size.stock}">${size.name || 'لا يوجد'} (المتوفر: ${size.stock})</option>`
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

            $('#addItem').on('click', function() {
                var itemId = $('#items_id').val();
                var itemName = $('#items_id option:selected').text() || 'لا يوجد';
                var gradeId = $('#grades_id').val();
                var gradeName = gradeId ? $('#grades_id option:selected').text() : 'لا يوجد';
                var sizeId = $('#sizes_id').val();
                var sizeName = sizeId ? $('#sizes_id option:selected').text() : 'لا يوجد';
                var quantity = $('#quantty').val();
                var price = $('#itemPrice').val() || 0;

                // If quantity is null or less than or equal to 0, show a message and stop
                if (!itemId || !quantity || quantity <= 0 || price <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'يرجى اختيار المنتج وإدخال الكمية والسعر'
                    });
                    return;
                }

                var stockGrade = $('#grades_id option:selected').data('stock') || 0;
                var stockSize = $('#sizes_id option:selected').data('stock') || 0;
                var generalStock = $('#items_id option:selected').data('stock') || 0;

                // Validate stock based on selected grade, size, or general stock
                if (gradeId && parseInt(quantity) > parseInt(stockGrade)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: `الكمية المدخلة (${quantity}) أكبر من المخزون المتوفر (${stockGrade}) لهذا اللون.`
                    });
                    return;
                }

                if (sizeId && parseInt(quantity) > parseInt(stockSize)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: `الكمية المدخلة (${quantity}) أكبر من المخزون المتوفر (${stockSize}) لهذا المقاسات.`
                    });
                    return;
                }

                if (!gradeId && !sizeId && parseInt(quantity) > parseInt(generalStock)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: `الكمية المدخلة (${quantity}) أكبر من المخزون المتوفر (${generalStock}).`
                    });
                    return;
                }

                // Deduct stock from generalStock if size and grades are null
                if (!gradeId && !sizeId) {
                    generalStock -= quantity;
                    $('#items_id option:selected').data('stock', generalStock);
                }

                var total = quantity * price;

                var row = `<tr>
                    <td>${itemName} <input type="hidden" class="items-id" value="${itemId}"></td>
                    <td>${gradeName} <input type="hidden" class="grades-id" value="${gradeId || ''}"></td>
                    <td>${sizeName} <input type="hidden" class="sizes-id" value="${sizeId || ''}"></td>
                    <td><input type="number" class="form-control quantity-input" value="${quantity}" min="1" max="${stockGrade || stockSize || generalStock}" data-stock="${stockGrade || stockSize || generalStock}"></td>
                    <td><input type="number" readonly class="form-control price-input" value="${price}" min="0"></td>
                    <td class="item-total">${total}</td>
                    <td><button type="button" class="btn btn-danger removeItem"><i class="fa fa-trash"></i></button></td>
                </tr>`;

                $('#itemsTable tbody').append(row);

                updateTotalAmount();

                $('#items_id, #grades_id, #sizes_id, #quantty, #itemPrice').val('');
            });

            $(document).on('click', '.removeItem', function() {
                $(this).closest('tr').remove();
                updateTotalAmount();
            });

            $(document).on('input', '.quantity-input', function() {
                var input = $(this);
                var stock = parseInt(input.data('stock')) || 0;
                var quantity = parseInt(input.val()) || 1;

                if (quantity > stock) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: `الكمية المدخلة (${quantity}) أكبر من المخزون المتوفر (${stock}).`,
                    });
                    input.val(stock); // إرجاع الكمية إلى الحد الأقصى المتاح
                }

                var row = input.closest('tr');
                var price = parseFloat(row.find('.price-input').val()) || 0;
                var total = quantity * price;
                row.find('.item-total').text(total);
                updateTotalAmount();
            });


            function updateTotalAmount() {
                var totalAmount = 0;
                $('#itemsTable tbody tr').each(function() {
                    totalAmount += parseFloat($(this).find('.item-total').text());
                });
                $('#totalAmount').text(totalAmount.toFixed(2));
            }


            $('form').submit(function() {
                var items = [];
                $('#itemsTable tbody tr').each(function() {
                    items.push({
                        item_id: $(this).find('.items-id').val(),
                        grade_id: $(this).find('.grades-id').val(),
                        size_id: $(this).find('.sizes-id').val(),
                        quantity: $(this).find('.quantity-input').val(),
                        price: $(this).find('.price-input').val()
                    });
                });
                $('#itemsInput').val(JSON.stringify(items));
            });
        });
    </script>
@endsection
