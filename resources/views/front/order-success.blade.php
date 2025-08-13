@extends('front.app')

@section('title', __('order.success_title'))

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-8 text-center max-w-md w-full">
            <!-- Fix image: updated image path and styling -->
            <h1 class="text-4xl font-bold text-green-500">{{ __('order.success_message') }}</h1>

            <p class="mt-4 text-lg text-gray-700">{{ __('order.success_description') }}</p>
            @if($order)
                <p class="mt-4 text-xl font-semibold">{{ __('order.tran') }}: {{ $order->ordersnumber }}</p>
            @else
                <p class="mt-4 text-xl font-semibold">{{ __('order.tran_not_available') }}</p>
            @endif
            <img src="{{ asset('shopping.png') }}" alt="Order Successful" class="mx-auto w-20 h-30 mb-6">

            <a href="{{ route('/') }}" class="mt-6 inline-block px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                {{ __('order.return_home') }}
            </a>
        </div>
    </div>
@endsection
