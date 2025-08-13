@extends('layouts.app')

@section('title', 'الاشعارات')

@section('content')
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="box-content">
            <a href="{{ route('notifications.index') }}" >الاشعارات</a> /  عرض الكل

        </div>
    </div>
    <div class="row small-spacing">
        <div class="col-md-12">
            <div class="box-content">
        <div class="card-body">
            <ul class="list-group">
                @foreach($notifications as $notification)
                    <li class="list-group-item d-flex justify-content-between align-items-center {{ $notification->is_read ? '' : 'list-group-item-warning' }}">
                        <div>
                            <a href="{{ route($notification->url) ?? '#' }}" class="font-weight-bold" style="color: black !important;"> 
                                <i  style="color: #2cb3e8  !important;" class="fa fa-bell text-primary"></i>  {{ $notification->message }}
                            </a>
                            <p class="mb-0 text-muted small">{{ $notification->created_at->format('F j, Y, g:i a') }}</p>
                        </div>
                        <span class="text-muted small">{{ $notification->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3" style="text-align: center;">
                {{ $notifications->links() }}
            </div>
        </div>
            </div>
    </div>
</div>
@endsection
