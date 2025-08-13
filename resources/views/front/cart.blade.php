@extends('front.app')

@section('title', app()->getLocale() === 'ar' ? trans('home.cart') . ' - ' . 'عربة التسوق' : trans('home.cart') . ' - ' . 'Shopping Cart')

@section('content')
    <form method="POST" action="{{ route('order.store') }}"> <!-- Updated form action -->
        @csrf
        <input type="hidden" name="cart" value="{{ json_encode($cart) }}"> <!-- Pass all cart data -->
        <div class="breadcrumb-block style-shared">
            <div class="breadcrumb-main bg-linear overflow-hidden">
                <div class="container lg:pt-[124px] pt-24 pb-10 relative">
                    <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                        <div class="text-content">
                            <div class="heading2 text-center">{{ __('products.cart') }}</div>
                            <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                                <a href="{{ route('/') }}" class="hover:underline">{{ __('products.home') }}</a>
                                <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                <div class="text-secondary2 capitalize">{{ __('products.cart') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-block md:py-20 py-10">
            <div class="container">
                <div class="content-main flex justify-between max-xl:flex-col gap-y-8">
                    <div class="xl:w-2/3 xl:pr-3 w-full">
                        <div class="list-product w-full sm:mt-7 mt-5">
                            <div class="overflow-x-auto"> <!-- added responsive wrapper -->
                                <table class="min-w-full text-center"> <!-- updated table class for responsiveness -->
                                    <thead>
                                        <tr>
                                            @foreach ([
                                                ['width' => '1/6', 'label' => app()->getLocale() === 'ar' ? __('products.products', [], 'ar') : __('products.products', [], 'en')],
                                                ['width' => '1/8', 'label' => app()->getLocale() === 'ar' ? __('products.price', [], 'ar') : __('products.price', [], 'en')],
                                                ['width' => '1/8', 'label' => app()->getLocale() === 'ar' ? __('product.discount_value', [], 'ar') : __('product.discount_value', [], 'en')],
                                                ['width' => '1/12', 'label' => app()->getLocale() === 'ar' ? __('product.discount_percentage', [], 'ar') : __('product.discount_percentage', [], 'en')],
                                                ['width' => '1/16', 'label' => app()->getLocale() === 'ar' ? __('products.size', [], 'ar') : __('products.size', [], 'en')],
                                                ['width' => '1/16', 'label' => app()->getLocale() === 'ar' ? __('products.color', [], 'ar') : __('products.color', [], 'en')],
                                                ['width' => '1/16', 'label' => app()->getLocale() === 'ar' ? __('products.quantity', [], 'ar') : __('products.quantity', [], 'en')],
                                                ['width' => '1/5', 'label' => app()->getLocale() === 'ar' ? __('products.total_price', [], 'ar') : __('products.total_price', [], 'en')],
                                                ['width' => '1/12', 'label' => '']
                                            ] as $column)
                                                <th class="text-sm text-gray-500 px-2 py-2" style="width: {{ $column['width'] }};">
                                                    {{ $column['label'] }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $item)
                                            <tr id="cart-item-{{ $item['product_id'] }}">
                                                <td class="px-2 py-3">
                                                    <img src="{{ asset('images/product/' . ($item['product_image'] ?? 'default.png')) }}" alt="{{ __('products.product_image') }}" class="w-12 h-12 mx-auto">
                                                    <div class="font-medium mt-2">{{ $item['product_name'] ?? __('products.not_available') }}</div>
                                                    <div class="text-sm text-gray-500">{{ $item['product_code'] ?? __('products.not_available') }}</div>
                                                </td>
                                                <td class="px-2 py-3">{{ number_format($item['price'] ?? 0, 2) }} {{ __('products.lyd') }}</td>
                                                <td class="px-2 py-3">{{ $item['price'] * $item['discount'] / 100}}{{ __('products.lyd') }}</td> <!-- والثانيه نسبه التخفيض -->
                                                <td class="px-2 py-3">{{ number_format($item['discount'] ) }}  %</td> <!-- بالعكس: الاول قيمه التخفيض -->

                                                <td class="px-2 py-3">{{ $item['size'] ?? __('products.not_available') }}</td>
                                                <td class="px-2 py-3">
                                                    @if(!empty($item['color']))
                                                        <span class="inline-block w-6 h-6 mr-1 rounded" style="background-color: {{ $item['color'] }};"></span>
                                                        {{-- {{ $item['color'] }} --}}
                                                    @else
                                                        {{ __('products.not_available') }}
                                                    @endif
                                                </td>
                                                <td class="px-2 py-3">
                                                    <input type="number" class="quantity-input border border-line rounded w-16 text-center" 
                                                           data-product-id="{{ $item['product_id'] }}" 
                                                           value="{{ $item['quantity'] }}" min="1">
                                                </td>
                                                <td class="px-2 py-3 total-price" id="total-price-{{ $item['product_id'] }}">
                                                    @php
                                                        $price = $item['price'] ?? 0;
                                                        $discount = $item['price']  * $item['discount']/100;
                                                        $discountedPrice = $price - $discount;
                                                        $totalPrice = $discountedPrice * ($item['quantity'] ?? 1);
                                                    @endphp
                                                    {{ number_format($totalPrice, 2) }} {{ __('products.lyd') }}
                                                </td>
                                                <td class="px-2 py-3">
                                                    <button class="text-red-500 hover:underline remove-item" data-product-id="{{ $item['product_id'] }}">
                                                        <i class="ph ph-trash text-red-500" style="color: red; font-size: 20px; font-weight: bold;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="xl:w-1/3 xl:pl-12 w-full">
                        <div class="checkout-block bg-surface p-6 rounded-2xl">
                            <div class="heading5">{{ __('products.order_summary') }}</div>
                            <div class="customer-info-block py-5 border-b border-line">
                                <label for="customer_name" class="text-title">{{ __('products.customer_name') }}</label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $customerName ?? '') }}" 
                                    class="w-full mt-2 p-2 border border-line rounded-lg" placeholder="{{ __('products.enter_name') }}" required>
                            </div>
                            <div class="customer-info-block py-5 border-b border-line">
                                <label for="customer_phone" class="text-title">{{ __('products.customer_phone') }}</label>
                                <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $customerPhone ?? '') }}" 
                                    class="w-full mt-2 p-2 border border-line rounded-lg" placeholder="{{ __('products.enter_phone') }}" required
                                    pattern="^(091|092|094|095|093)\d{7}$" title="{{ __('products.phone_validation_message') }}">
                            </div>
                            <!-- Added address block -->
                            <div class="customer-info-block py-5 border-b border-line">
                                <label for="customer_address" class="text-title">{{ __('products.customer_address') }}</label>
                                  
                                <select id="customer_city" name="customer_city" class="w-full mt-2 p-2 border border-line rounded-lg">
                                    <option value="" disabled selected>{{ __('products.enter_city') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ (old('customer_city', $customerCity ?? '') == $city->id) ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" id="customer_address" name="customer_address" value="{{ old('customer_address', $customerAddress ?? '') }}" 
                                    class="w-full mt-2 p-2 border border-line rounded-lg" placeholder="{{ __('products.enter_address') }}" required>
                            </div>
                            <div class="customer-info-block py-5 border-b border-line">
                                <label for="terms" class="text-title">
                                    <input type="checkbox" id="terms" name="terms" required>
                                    {{ __('products.agree_to_terms') }}
                                </label>
                                <div class="mt-2">
                                    <a href="{{ route('policies') }}" style="color: #2cb3e8;" target="_blank" class="text-primary hover:underline">
                                        {{ __('products.terms_and_policies') }}
                                    </a>
                                </div>
                            </div>
                            <div class="total-cart-block pt-4 pb-4 flex justify-between">
                                <div class="heading5">{{ __('products.total') }}</div>
                                <div class="">
                                    @php
                                        $grandTotal = array_reduce($cart, function ($total, $item) {
                                            $discountedPrice = $item['price'] - ($item['price'] * $item['discount'] / 100); // Correct discount calculation
                                            return $total + ($discountedPrice * $item['quantity']);
                                        }, 0);
                                    @endphp
                                    {{ number_format($grandTotal, 2) }} {{ __('products.lyd') }}
                                </div>
                            </div>
                            <div class="block-button flex flex-col items-center gap-y-4 mt-5">
                                <button type="submit" class="checkout-btn button-main text-center w-full" style="background-color: #2cb3e8;" disabled>
                                    {{ __('products.process_to_checkout') }}
                                </button>
                                <a class="text-button hover-underline" href="{{ route('all_products') }}" style="color: #2cb3e8;">
                                    {{ __('products.continue_shopping') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Add custom style for mobile view -->
    <style>
    @media (max-width: 600px) {
      .swal2-actions-custom {
        flex-direction: column !important;
      }
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-item');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const itemRow = document.getElementById(`cart-item-${productId}`);

                    Swal.fire({
                        title: '{{ __('products.confirm_remove') }}',
                        text: '{{ __('products.remove_item_warning') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        customClass: { actions: 'swal2-actions-custom' },
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '{{ __('products.yes_remove') }}',
                        cancelButtonText: '{{ __('products.cancel') }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ url('/cart/remove') }}/${productId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    itemRow.remove();
                                    // New code: if cart is empty update grand total to 0.
                                    const tbody = document.querySelector('table tbody');
                                    if (!tbody || tbody.children.length === 0) {
                                        const grandTotalElement = document.querySelector('.total-cart-block .heading5 + div');
                                        if (grandTotalElement) {
                                            grandTotalElement.textContent = `0.00 {{ __('products.lyd') }}`;
                                        }
                                    }
                                    // Update cart icon count if provided
                                    if(data.cartCount !== undefined) {
                                        const cartIconCount = document.getElementById('cart-count');
                                        if (cartIconCount) {
                                            cartIconCount.textContent = data.cartCount;
                                        }
                                    }
                                    Swal.fire(
                                        '{{ __('products.removed') }}',
                                        '{{ __('products.item_removed_success') }}',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        '{{ __('products.error') }}',
                                        '{{ __('products.error_occurred') }}',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    '{{ __('products.error') }}',
                                    '{{ __('products.error_occurred') }}',
                                    'error'
                                );
                            });
                        }
                    });
                });
            });

            const quantityInputs = document.querySelectorAll('.quantity-input');

            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.getAttribute('data-product-id');
                    const newQuantity = this.value;

                    fetch(`{{ url('/cart/update') }}/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ quantity: newQuantity }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the total price for the product
                            const totalPriceElement = document.getElementById(`total-price-${productId}`);
                            totalPriceElement.textContent = `${data.totalPrice.toFixed(2)} {{ __('products.lyd') }}`;

                            // Update the grand total
                            const grandTotalElement = document.querySelector('.total-cart-block .heading5 + div');
                            grandTotalElement.textContent = `${data.grandTotal.toFixed(2)} {{ __('products.lyd') }}`;

                            // Update cart icon count if provided
                            if(data.cartCount !== undefined) {
                                const cartIconCount = document.getElementById('cart-count');
                                if (cartIconCount) {
                                    cartIconCount.textContent = data.cartCount;
                                }
                            }
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating quantity:', error);
                    });
                });
            });

            const termsCheckbox = document.getElementById('terms');
            const checkoutButton = document.querySelector('.checkout-btn');

            termsCheckbox.addEventListener('change', function() {
                checkoutButton.disabled = !this.checked;
            });
        });
    </script>
@endsection
