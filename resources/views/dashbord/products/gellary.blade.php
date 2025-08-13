@extends('layouts.app')
@section('title', 'معرض الصور ')

@section('content')
<style>
    .modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        /* z-index: 1040; removed */
        background-color: #000;
    }

    /* Optionally, enforce no z-index with !important */
    .modal-backdrop {
        z-index: auto !important;
    }

    /* Responsive modal styles */
    @media (max-width: 767px) {
        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
        }
        .modal-content {
            height: 100vh;
            border-radius: 0;
        }
    }
    @media (min-width: 768px) {
        .modal-dialog {
            width: 80%;
            margin: 30px auto;
        }
        .modal-content {
            max-height: 80vh;
            overflow-y: auto;
        }
    }

    /* Make modal image the same size as the modal */
    .carousel-inner .item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <h4 class="box-title">
                <a href="{{ route('products') }}">المنتجات</a>/ معرض صور منتج 
            {{$product->barcode}}
            </h4>
        </div>
    </div>
@if($image->isEmpty())

<div class="col-md-12">
    <div class="box-content">
<div class="alert alert-warning">
    لايوجد معرض صور
</div>
@else
<div class="row small-spacing">
    @foreach($image as $index => $img)
    <div class="col-md-3">
        <div class="box-content">
            <!-- Added data-index and class for slider trigger -->
            <img src="{{ asset('images/product/'.$img->name) }}" alt="Image" class="img-responsive gallery-image" data-index="{{ $index }}" style="cursor:pointer;">
        </div>
    </div>
    @endforeach
</div>

<!-- Updated Bootstrap Modal for Slider with default attributes -->

    </div>
</div>

@endif
<script>
    $(document).ready(function(){
        $('.gallery-image').on('click', function(){
            var index = $(this).data('index');
            $('#carouselImages').carousel(parseInt(index));
            $('#sliderModal').modal('show');
        });
        // Removed custom close-click handler to allow Bootstrap default behavior
    });
    </script>


@endsection

<div class="modal fade" id="sliderModal" tabindex="-1" role="dialog" aria-labelledby="sliderModalLabel" data-backdrop="true" data-keyboard="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="sliderModalLabel">معرض الصور</h4>
        </div>
        <div class="modal-body">
          <div id="carouselImages" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              @foreach($image as $index => $img)
              <li data-target="#carouselImages" data-slide-to="{{ $index }}" class="@if($index==0) active @endif"></li>
              @endforeach
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              @foreach($image as $index => $img)
              <div class="item @if($index==0) active @endif">
                <img src="{{ asset('images/product/'.$img->name) }}" alt="Image" class="img-responsive center-block">
              </div>
              @endforeach
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carouselImages" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">السابق</span>
            </a>
            <a class="right carousel-control" href="#carouselImages" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">التالي</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>





