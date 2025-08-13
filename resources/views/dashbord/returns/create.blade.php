@extends('layouts.app')

@section('title', 'إضافة راجع')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <a href="{{ route('returns') }}">الرواجع </a> / إضافة راجع
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="box-content">

                <form method="POST" action="">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exchangesnumber" class="control-label">رقم الفاتورة</label>
                            <input type="text" name="exchangesnumber"
                                class="form-control @error('exchangesnumber') is-invalid @enderror" value="{{ old('exchangesnumber') }}"
                                id="exchangesnumber" placeholder="أدخل رقم الفاتورة">
                            @error('exchangesnumber')
                                <span class="invalid-feedback" role="alert" style="color: red">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-2 align-self-end" style="margin-top:30px">
                            <button type="button" id="searchinovue" class="btn btn-primary btn-block">بحث</button>
                        </div>
                    </div>

                   





                </form>
                <div id="invoiceDetails">
                    <!-- سيتم تحميل بيانات الفاتورة هنا -->
                </div>
            </div>
        </div>
    </div>

   <!-- تضمين مكتبة SweetAlert2 -->

<script>
    $(document).ready(function() {
        $('#searchinovue').click(function() {
            var invoiceNumber = $('#exchangesnumber').val();

            if (invoiceNumber === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'تنبيه',
                    text: 'يرجى إدخال رقم الفاتورة!',
                });
                return;
            }

            $.ajax({
                url: "{{ route('returns/fetch/invoice') }}", // المسار في Laravel
                type: "GET",
                data: { exchangesnumber: invoiceNumber },
                success: function(response) {
                    if (response.success) {
                        $('#invoiceDetails').html(response.html); // تحديث الجدول بالبيانات الجديدة
                        Swal.fire({
                            icon: 'success',
                            title: 'تم العثور على الفاتورة!',
                            text: 'تم جلب بيانات الفاتورة بنجاح.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: 'لم يتم العثور على الفاتورة!',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في الاتصال!',
                        text: 'حدث خطأ أثناء جلب البيانات!',
                    });
                }
            });
        });
    });
</script>

    
 
@endsection
