@extends('layouts.app')

@section('title', trans('contactus.contactus'))

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="row small-spacing">
  <div class="col-md-12">
    <div class="box-content">
      <h4 class="box-title">
        <a href="{{ route('contactus') }}">{{ trans('contactus.contactus') }}</a>
      </h4>
    </div>
  </div>

  <div class="col-md-12">
    <div class="box-content" style="height: 100vh">
      <div class="row">
        <a class="col-md-12" style="color: #f97424; text-align: left;" 
           href="{{ route('contactus/edit') }}">
           <img src="{{asset('edit.png')}}" style="width: 40px">
        </a>

        <div class="col-md-4"><label>{{ trans('contactus.email') }}: {{ $contactus->email ?? 'لايوجد' }}</label></div>
        <div class="col-md-4"><label>{{ trans('contactus.phone') }}: {{ $contactus->phonenumber ?? 'لايوجد' }}</label></div>
        <div class="col-md-4"><label> WhatsApp: {{ $contactus->whatsapp ?? 'لايوجد' }}</label></div>
        <div class="col-md-4"><label>{{ trans('contactus.adress') }}: {{ $contactus->adress ?? 'لايوجد' }}</label></div>
        <div class="col-md-4"><label>{{ trans('contactus.adressen') }}: {{ $contactus->adressen ?? 'لايوجد' }}</label></div>
        <div class="col-md-4"><label>{{ trans('contactus.lan') }}: {{ $contactus->lan ?? 'لايوجد' }}</label></div>
        <div class="col-md-4"><label>{{ trans('contactus.long') }}: {{ $contactus->long ?? 'لايوجد' }}</label></div>

        <!-- Social Media Links -->
        <div class="col-md-12" style="margin-top: 20px;">
          <h4>روابط وسائل التواصل الاجتماعي</h4>
          <ul style="list-style: none; padding: 0;">
            @if($contactus->facebook_url)
              <li><a href="{{ $contactus->facebook_url }}" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></li>
            @endif
            @if($contactus->instagram_url)
              <li><a href="{{ $contactus->instagram_url }}" target="_blank"><i class="fa fa-instagram"></i> Instagram</a></li>
            @endif
            @if($contactus->twitter_url)
              <li><a href="{{ $contactus->twitter_url }}" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></li>
            @endif
            @if($contactus->linkedin_url)
              <li><a href="{{ $contactus->linkedin_url }}" target="_blank"><i class="fa fa-linkedin"></i> LinkedIn</a></li>
            @endif
            @if($contactus->youtube_url)
              <li><a href="{{ $contactus->youtube_url }}" target="_blank"><i class="fa fa-youtube"></i> YouTube</a></li>
            @endif
            @if($contactus->pinterest_url)
              <li><a href="{{ $contactus->pinterest_url }}" target="_blank"><i class="fa fa-pinterest"></i> Pinterest</a></li>
            @endif
          </ul>
        </div>

        <!-- Google Map -->
         <!-- OpenStreetMap -->
        <!-- OpenStreetMap -->
        <div class="col-md-12" style="margin-top: 20px;">
          <h4>الموقع على الخريطة</h4>
          <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Google Maps Script -->
<!-- Leaflet.js Map Script -->
<script>
  var lat = {{ $contactus->lan ?? 0 }};
  var lng = {{ $contactus->long ?? 0 }};
  
  var map = L.map('map').setView([lat, lng], 15);  // Set the initial position and zoom level

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  var marker = L.marker([lat, lng]).addTo(map);  // Add a marker
  marker.bindPopup("<b>Location</b>").openPopup();  // Add popup to marker
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap"></script>
@endsection
