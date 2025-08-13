@extends('layouts.app')

@section('title', 'إضافة عملية بيع')

@section('content')
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
                        <div class="form-group col-md-2">
                            <label for="items_id" class="control-label">المنتج</label>
                            <select name="items_id" id="items_id" class="form-control">
                                <option value="">اختر المنتج</option>
                                @foreach ($Items as $Item)
                                    <option value="{{ $Item->products->id }}" 
                                            data-price="{{ $Item->products->price }}"
                                            data-stock="{{ $Item->total_quantity }}">
                                        {{ $Item->products->name }} (المتوفر: {{ $Item->total_quantity }})
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>

                        <div class="form-group col-md-2">
                            <label for="grades_id" class="control-label">اللون</label>
                            <select name="grades_id" id="grades_id" class="form-control">
                                <option value="">اختر اللون</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="sizes_id" class="control-label">المقاسات</label>
                            <select name="sizes_id" id="sizes_id" class="form-control">
                                <option value="">اختر المقاسات</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="quantty" class="control-label">الكمية</label>
                            <input type="number" name="quantty" class="form-control" id="quantty" min="1"
                                placeholder="أدخل الكمية">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="itemPrice" class="control-label">السعر (للقطعة)</label>
                            <input type="number" name="itemPrice" class="form-control" id="itemPrice" placeholder="السعر">
                        </div>

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
            $('#items_id').change(function() {
                var product_id = $(this).val();

                if (product_id) {
                    $.ajax({
                        url: "{{ route('exchange/stockall') }}",
                        type: "GET",
                        data: {
                            product_id: product_id
                        },
                        success: function(data) {
                            console.log(data);

                            $('#grades_id').empty().append(
                                '<option value="">اختر اللون</option>');
                            $('#sizes_id').empty().append(
                                '<option value="">اختر المقاسات</option>');

                            if (data.grades && data.grades.length > 0) {
                                $.each(data.grades, function(key, grade) {
                                    $('#grades_id').append(
                                        `<option value="${grade.id}" data-stock="${grade.stock}">${grade.name || 'لا يوجد'} (المتوفر: ${grade.stock})</option>`
                                    );
                                });
                            } else {
                                $('#grades_id').append(
                                    '<option value="">لا توجد ألوان متاحة</option>');
                            }

                            if (data.sizes && data.sizes.length > 0) {
                                $.each(data.sizes, function(key, size) {
                                    $('#sizes_id').append(
                                        `<option value="${size.id}" data-stock="${size.stock}">${size.name || 'لا يوجد'} (المتوفر: ${size.stock})</option>`
                                    );
                                });
                            } else {
                                $('#sizes_id').append(
                                    '<option value="">لا توجد مقاسات متاحة</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("خطأ في جلب البيانات:", error);
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ',
                                text: 'حدثت مشكلة أثناء جلب الألوان والمقاساتات، حاول مرة أخرى.'
                            });
                        }
                    });
                } else {
                    $('#grades_id, #sizes_id').empty().append(
                        '<option value="">اختر المنتج أولاً</option>');
                }
            });

            $('#addItem').on('click', function() {
                var itemId = $('#items_id').val();
                var itemName = $('#items_id option:selected').text() || 'لا يوجد';
                var gradeId = $('#grades_id').val();
                var gradeName = $('#grades_id option:selected').text() || 'لا يوجد';
                var sizeId = $('#sizes_id').val();
                var sizeName = $('#sizes_id option:selected').text() || 'لا يوجد';
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
                var items_id = $('#items_id option:selected').data('stock') || 0;

                if (!gradeId && !sizeId) {

                    if (parseInt(quantity) > parseInt(items_id)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: `الكمية المدخلة (${quantity}) أكبر من المخزون المتوفر (${items_id}) لهذا اللون.`
                        });
                        return;
                    }

                }
                if (gradeId && parseInt(stockGrade) <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'لايوجد مخزون.'
                    });
                    return;
                }
                if (gradeId && parseInt(quantity) > parseInt(stockGrade)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: `الكمية المدخلة (${quantity}) أكبر من المخزون المتوفر (${stockGrade}) لهذا اللون.`
                    });
                    return;
                }


                if (sizeId && parseInt(stockSize) <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'لايوجد مخزون.'
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

                var total = quantity * price;

                var row = `<tr>
    <td>${itemName} <input type="hidden" class="items-id" value="${itemId}"></td>
    <td>${gradeName} <input type="hidden" class="grades-id" value="${gradeId}"></td>
    <td>${sizeName} <input type="hidden" class="sizes-id" value="${sizeId}"></td>
    <td><input type="number" class="form-control quantity-input" value="${quantity}" min="1" max="${stockGrade || stockSize || items_id}" data-stock="${stockGrade || stockSize || items_id}"></td>
    <td><input type="number" class="form-control price-input" value="${price}" min="0"></td>
    <td class="item-total">${total}</td>
    <td><button type="button" class="btn btn-danger removeItem"><i class="fa fa-trash"></i></button></td>
</tr>`;


                $('#itemsTable tbody').append(row);

                updateTotalAmount();
                saveItems();

                $('#items_id, #grades_id, #sizes_id, #quantty, #itemPrice').val('');
            });

            $(document).on('click', '.removeItem', function() {
                $(this).closest('tr').remove();
                updateTotalAmount();
                // saveItems();
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

            // function saveItems() {
            //     function saveItems() {
            //         var items = [];
            //         $('#itemsTable tbody tr').each(function() {
            //             var item = {
            //                 item_id: $(this).find('.items-id').val(),
            //                 grade_id: $(this).find('.grades-id').val(),
            //                 size_id: $(this).find('.sizes-id').val(),
            //                 quantity: $(this).find('.quantity-input').val(),
            //                 price: $(this).find('.price-input').val()
            //             };
            //             if (item.item_id && item.quantity > 0) {
            //                 items.push(item);
            //             }
            //         });
            //         $('#itemsInput').val(JSON.stringify(items));
            //     }
            // }

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
