<div class="invoice-container">
   

    <table class="table table-bordered mt-3">
        <tr>
            <td><strong>رقم الفاتورة:</strong> {{ $exchange->exchangesnumber }}</td>
            <td><strong>تاريخ الفاتورة:</strong> {{ $created_at }}</td>
        </tr>
        <tr>
            <td><strong>اسم العميل:</strong> {{ $exchange->full_name }}</td>
            <td><strong>رقم الهاتف:</strong> {{ $exchange->phonenumber }}</td>
        </tr>
    </table>

    <table class="table table-striped table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>اسم المنتج</th>
                <th>الكمية</th>
                <th>المقاسات</th>
                <th>اللون</th>
                <th>السعر (للقطعة)</th>
                <th>الإجمالي</th>
                <th>إرجاع</th>
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
                    <td>
                        <button class="btn btn-danger btn-sm return-item" data-item-id="{{ $item->id }}">
                            <img src="{{ asset('return.png') }}" alt="إرجاع" style="width: 16px; height: 16px; margin-right: 5px;">
                            إرجاع
                        </button>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-end fw-bold">الإجمالي الكلي: {{ $exchange->total_price }} دينار</p>

   

</div>

<script>
    $(document).ready(function() {
        $('.return-item').click(function() {
            let itemId = $(this).data('item-id');

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "سيتم إرجاع هذا المنتج!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، إرجاع!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('returns/process') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            item_id: itemId
                        },
                        success: function(response) {
                            if (response.success) {
    Swal.fire({
        title: "تم الإرجاع!",
        text: "تم إرجاع المنتج بنجاح.",
        icon: "success"
    }).then(() => {
        window.location.href = "{{ route('returns') }}"; // إعادة التوجيه إلى صفحة المرتجعات
    });
} else {
    Swal.fire("خطأ!", "لم يتم العثور على المنتج.", "error");
}

                        },
                        error: function() {
                            Swal.fire("خطأ!", "حدث خطأ أثناء المعالجة.", "error");
                        }
                    });
                }
            });
        });
    });
</script>
