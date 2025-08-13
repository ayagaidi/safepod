@extends('layouts.app')

@section('title', 'تعديل منتج')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">
                <a href="{{ route('products') }}">المنتجات</a>/تعديل منتج
            </h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content">
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('post')

                <!-- First Row: Category Selection -->
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="categories_id" class="control-label">الفئة</label>
                        <select name="categories_id" class="form-control @error('categories_id') is-invalid @enderror">
                            <option value="">اختر الفئة</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('categories_id', $product->categories_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('categories_id')
                            <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Second Row: Name and Namee -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name" class="control-label">اسم المنتج</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $product->name) }}" id="name" placeholder="اسم المنتج">
                        @error('name')
                            <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="namee" class="control-label">اسم المنتج (بديل)</label>
                        <input type="text" name="namee" class="form-control @error('namee') is-invalid @enderror"
                               value="{{ old('namee', $product->namee) }}" id="namee" placeholder="اسم المنتج (بديل)">
                        @error('namee')
                            <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

           

                <!-- New Row: Arabic and English Descriptions -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="description_ar" class="control-label">شرح المنتج (عربي)</label>
                        <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror"
                                  id="description_ar" placeholder="شرح المنتج بالعربي">{{ old('description_ar', $product->description_ar) }}</textarea>
                        @error('description_ar')
                            <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description_en" class="control-label">شرح المنتج (إنجليزي)</label>
                        <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                                  id="description_en" placeholder="شرح المنتج بالإنجليزي">{{ old('description_en', $product->description_en) }}</textarea>
                        @error('description_en')
                            <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Fourth Row: Price and Cover Image -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="price" class="control-label">السعر</label>
                        <input type="text" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $product->price) }}" id="price" placeholder="السعر">
                        @error('price')
                            <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        @if($product->image)
                        <div class="mt-2">
                            <label>الصورة الحالية:</label>
                            <img src="{{ asset('images/product/' . $product->image) }}" alt="Product Image" id="imagePreview" class="img-thumbnail" width="150">
                        </div>
                    @else
                        <div class="mt-2">
                            <label>لا توجد صورة حالياً.</label>
                        </div>
                    @endif
                        <label for="image" class="control-label">صورة الغلاف</label>

                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" onchange="previewImage(event)">
                       
                        @error('image')
                            <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- New Row: Sizes -->
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="size" class="control-label">المقاسات </label>
                        <div id="size-container">
                            @if($product->sizes->count() > 0)
                                @foreach($product->sizes as $size)
                                <div class="row mb-2">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="text" name="size[]" value="{{ $size->name }}" class="form-control" placeholder="ادخل المقاسات المنتج">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-danger remove-size">-</button>
                                        @if($loop->last)
                                            <button type="button" class="btn btn-success add-size">+ إضافة</button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="row mb-2">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="text" name="size[]" class="form-control" placeholder="ادخل حجم المنتج">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-danger remove-size">-</button>
                                        <button type="button" class="btn btn-success add-size">+ إضافة</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- New Row: Grades -->
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="grade" class="control-label"> (اللون)</label>
                        <div id="grade-container">
                            @if($product->grades->count() > 0)
                                @foreach($product->grades as $grade)
                                <div class="row mb-2">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="text" name="grade[]" value="{{ $grade->name }}" class="form-control" onchange="this.nextElementSibling.innerText = this.value;">
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ $grade->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-danger remove-grade">-</button>
                                        @if($loop->last)
                                            <button type="button" class="btn btn-success add-grade">+ إضافة درجة</button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="row mb-2">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="color" name="grade[]" class="form-control" value="#000000" onchange="this.nextElementSibling.innerText = this.value;">
                                            <div class="input-group-append">
                                                <span class="input-group-text">#000000</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-danger remove-grade">-</button>
                                        <button type="button" class="btn btn-success add-grade">+ إضافة درجة</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- New Gallery Section --}}
                @if(isset($image) && $image->count() > 0)
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="gallery" class="control-label">معرض الصور</label>
                        <div class="gallery">
                            @foreach($image as $img)
                                <img src="{{ asset('images/product/' . $img->filename) }}" alt="Gallery Image" class="img-thumbnail" width="100">
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- New Gallery Section --}}
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="gallery" class="control-label">معرض الصور</label>
                        <div class="gallery">
                            @foreach($image as $img)
                            <div style="display: inline-block; position: relative; margin:5px;">
                                <img src="{{ asset('images/product/' . $img->name) }}" alt="Gallery Image" class="img-thumbnail" width="100">
                                <a href="{{ route('products/deleteImage', encrypt($img->id)) }}" style="position: absolute; top: 0; right: 0;" 
                                   onclick="deleteImageConfirmation(event, this)">
                                   <i class="fa fa-times" style="color:red; background:#fff; border-radius:50%; padding:2px;"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- New Additional Images Input --}}
                <div class="form-row">
                    <div class="form-group col-md-12">

                    <label for="image" class="control-label">صورة أخرى للمنتج</label>
                    <div id="image-container">
                        <div class="row mb-2">
                            <div class="col-md-10">
                                <input type="file" name="images[]"
                                    class="form-control @error('images') is-invalid @enderror">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-success add-image">+</button>
                            </div>
                        </div>
                    </div>
                    @error('images')
                        <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelector('.add-image').addEventListener('click', function() {
                            let imageContainer = document.getElementById('image-container');
                            let newInputRow = document.createElement('div');
                            newInputRow.classList.add('row', 'mb-2');
                            newInputRow.style.marginTop = "10px"; // Adjusted spacing for better UI

                            newInputRow.innerHTML = `
                            <div class="col-md-10">
                                <input type="file" name="images[]" class="form-control">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-danger remove-image">-</button>
                            </div>
                        `;
                            imageContainer.appendChild(newInputRow);
                        });

                        document.addEventListener('click', function(event) {
                            if (event.target.classList.contains('remove-image')) {
                                event.target.closest('.row').remove();
                            }
                        });
                    });
                </script>

                <!-- Submit Button -->
                <div class="form-row">
                    <div class="form-group col-md-12 text-left">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">تحديث المنتج</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script>
    function deleteImageConfirmation(event, element) {
        event.preventDefault();
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "هل أنت متأكد من حذف الصورة؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = element.getAttribute('href');
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update dynamic addition for Sizes
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-size')) {
                // Remove existing add buttons from all rows
                document.querySelectorAll('#size-container .add-size').forEach(btn => btn.remove());
                let sizeContainer = document.getElementById('size-container');
                let newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-2');
                newRow.style.marginTop = "10px";
                newRow.innerHTML = `
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="text" name="size[]" class="form-control" placeholder="ادخل حجم المنتج">
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-size">-</button>
                        <button type="button" class="btn btn-success add-size">+ إضافة</button>
                    </div>
                `;
                sizeContainer.appendChild(newRow);
            }
        });
    
        document.addEventListener('click', function(e){
            if (e.target.classList.contains('remove-size')) {
                e.target.closest('.row').remove();
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inline dynamic addition for Grades
        document.addEventListener('click', function(e) {
            if(e.target.classList.contains('add-grade')) {
                // Remove all existing add-grade buttons
                document.querySelectorAll('#grade-container .add-grade').forEach(btn => btn.remove());
                let gradeContainer = document.getElementById('grade-container');
                let newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-2');
                newRow.style.marginTop = "10px";
                newRow.innerHTML = `
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="color" name="grade[]" class="form-control" value="#000000" onchange="this.nextElementSibling.innerText = this.value;">
                            <div class="input-group-append">
                                <span class="input-group-text">#000000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-grade">-</button>
                        <button type="button" class="btn btn-success add-grade">+ إضافة درجة</button>
                    </div>
                `;
                gradeContainer.appendChild(newRow);
            }
        });
        document.addEventListener('click', function(e) {
            if(e.target.classList.contains('remove-grade')) {
                e.target.closest('.row').remove();
            }
        });
    });
</script>

@endsection
