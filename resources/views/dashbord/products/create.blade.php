@extends('layouts.app')

@section('title', 'اضافة منتج')

@section('content')
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
                <h4 class="box-title">
                    <a href="{{ route('products') }}">المنتجات</a>/اضافة منتج
                </h4>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box-content">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf

                    <!-- First Row: Category Selection -->
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="categories_id" class="control-label">التصنيفات</label>
                            <select name="categories_id" class="form-control @error('categories_id') is-invalid @enderror">
                                <option value="">اختر التصنيف</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('categories_id') == $category->id ? 'selected' : '' }}>
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
                                value="{{ old('name') }}" id="name" placeholder="اسم المنتج">
                            @error('name')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="namee" class="control-label">اسم المنتج (باللغة الانجليزية)</label>
                            <input type="text" name="namee" class="form-control @error('namee') is-invalid @enderror"
                                value="{{ old('namee') }}" id="namee" placeholder="اسم المنتج (باللغة الانجليزية)">
                            @error('namee')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="namee" class="control-label">اسم العلامة التجارية (باللغة الانجليزية)</label>
                            <input type="text" name="brandname"
                                class="form-control @error('brandname') is-invalid @enderror" value="{{ old('brandname') }}"
                                id="namee" placeholder="اسم العلامة (باللغة الانجليزية)">
                            @error('brandname')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="image" class="control-label">صورة الغلاف</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image">
                            @error('image')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional fields: Barcode, Grade, Size, Notes -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="barcode" class="control-label">الباركود</label>
                            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                                value="{{ old('barcode') }}" id="barcode" placeholder="الباركود">
                            @error('barcode')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price" class="control-label">سعر البيع</label>
                            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}" id="price" placeholder="السعر">
                            @error('price')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="size" class="control-label">المقاسات</label>
                            <div id="size-container">
                                <div class="row mb-2">
                                    {{-- <div class="col-md-10">
                                        <input type="text" name="size[]"
                                            class="form-control @error('size') is-invalid @enderror"
                                            value="{{ old('size.0') }}" placeholder="XL">
                                    </div> --}}
                                    <div class="col-2">
                                        <button type="button" class="btn btn-success add-size">+</button>
                                    </div>
                                </div>
                            </div>
                            @error('size')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelector('.add-size').addEventListener('click', function() {
                                let sizeContainer = document.getElementById('size-container');
                                let newInputRow = document.createElement('div');
                                newInputRow.classList.add('row', 'mb-2');
                                newInputRow.style.marginTop = "50px"; // Apply the style

                                newInputRow.innerHTML = `
                                <div class="col-md-10">
                                    <input type="text" name="size[]" class="form-control" placeholder="XL">
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-danger remove-size">-</button>
                                </div>
                            `;
                                sizeContainer.appendChild(newInputRow);
                            });

                            document.addEventListener('click', function(event) {
                                if (event.target.classList.contains('remove-size')) {
                                    event.target.closest('.row').remove();
                                }
                            });
                        });
                    </script>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="grade" class="control-label">اللون</label>
                            <div id="grade-container">
                                <div class="row mb-2">
                                    {{-- <div class="col-md-10">
                                        <input type="color" name="grade[]" class="form-control @error('grade') is-invalid @enderror" value="{{ old('grade.0', '') }}">
                                    </div> --}}
                                    <div class="col-2">
                                        <button type="button" class="btn btn-success add-grade">+</button>
                                    </div>
                                </div>
                            </div>
                            @error('grade')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelector('.add-grade').addEventListener('click', function() {
                                let gradeContainer = document.getElementById('grade-container');
                                let newInputRow = document.createElement('div');
                                newInputRow.classList.add('row', 'mb-2');
                                newInputRow.style.marginTop = "10px"; // Adjusted spacing for better UI

                                newInputRow.innerHTML = `
                                <div class="col-md-10">
                                    <input type="text" name="grade[]" class="form-control" placeholder="اخضر" >
                                </div>
                               
                                <div class="col-2">
                                    <button type="button" class="btn btn-danger remove-grade">-</button>
                                </div>
                            `;
                                gradeContainer.appendChild(newInputRow);
                            });

                            document.addEventListener('click', function(event) {
                                if (event.target.classList.contains('remove-grade')) {
                                    event.target.closest('.row').remove();
                                }
                            });
                        });
                    </script>



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
          

                    <!-- New Row: Descriptions in Arabic and English -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="description_ar" class="control-label">شرح المنتج (عربي)</label>
                            <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror"
                                      id="description_ar" placeholder="شرح المنتج بالعربي">{{ old('description_ar') }}</textarea>
                            @error('description_ar')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description_en" class="control-label">شرح المنتج (إنجليزي)</label>
                            <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                                      id="description_en" placeholder="شرح المنتج بالإنجليزي">{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
          <div class="row">

                        <div class="form-group col-md-12">
                            <label for="notes" class="control-label">ملاحظات</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="notes"
                                placeholder="ملاحظات">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 text-left">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">اضافة المنتج</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
