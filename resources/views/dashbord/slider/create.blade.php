@extends('layouts.app')
@section('title',"اضافة Slider")

@section('content')
<script>
    $(document).ready(function() {
    $('#summernote').summernote({
        height: 300, // adjust height as needed
        // Add other Summernote configuration options here
        fontFamilies: ['Cairo']
    });
    $('#summernote').on('summernote.change', function(e) {
    let content = $(this).summernote('code'); // Get content
    let sanitizedContent = content.replace(/style="[^"]*font-family[^"]*"/g, ''); // Remove font-family styles
    $(this).summernote('code', sanitizedContent); // Update content
});

$('#summernote2').summernote({
        height: 300, // adjust height as needed
        // Add other Summernote configuration options here
        fontFamilies: ['Cairo']
    });
    $('#summernote2').on('summernote.change', function(e) {
    let content = $(this).summernote('code'); // Get content
    let sanitizedContent = content.replace(/style="[^"]*font-family[^"]*"/g, ''); // Remove font-family styles
    $(this).summernote('code', sanitizedContent); // Update content
});

});
</script>
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content ">
            <h4 class="box-title"><a href="{{ route('slider') }}">Slider</a>/ اضافة slider</h4>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box-content row">
            <form method="POST" class="" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-12">
                    <label for="inputName" class="control-label">الصورة</label>
                    <input type="file" name="imge" class="form-control @error('imge') is-invalid @enderror"
                           id="imge">
                    @error('imge')
                        <span class="invalid-feedback" role="alert" style="color: red">{{ $message }}</span>
                    @enderror
                    <span style="color: gray">[يجب ان تكون بمقاس width 657px height 677]</span>

                </div>
              
               
                
             
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{trans('city.addbtn')}}</button>
                </div>
            </form>
        </div>
        <!-- /.box-content -->
    </div>
    <!-- /.col-xs-12 -->
</div>
@endsection