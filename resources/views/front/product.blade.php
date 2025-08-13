@extends('front.app')

@section('title', trans('home.productinfo'))

@section('content')


    <div class="product-detail external">
        <div class="featured-product countdown-timer underwear md:py-20 py-14">
            <div class="container flex justify-between gap-y-6 flex-wrap">
                <div style="padding-left: 25px" class="list-img md:w-1/2 md:pr-[25px]  w-full flex-shrink-0">
                    <div class="sticky">
                        <!-- Display the first product image -->
                        <div class="main-image">
                            <img style="width: 620px;height: 620px;" id="main-product-image"
                                src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full rounded-lg">
                        </div>

                        <!-- Display the gallery of other images -->
                        <div class="gallery grid grid-cols-4 gap-3 mt-5">
                            <img style="width: 146px;height: 146px;object-fit:contain"
                                src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->name }}"
                                class="gallery-item cursor-pointer border border-gray-300 rounded-lg hover:shadow-lg transition-all duration-300 w-24 h-24 object-cover"
                                onclick="changeMainImage(this)">
                            @foreach ($imagesfiles as $image)
                                <img style="width: 146px;height: 146px;object-fit:contain"
                                    src="{{ asset('images/product/' . $image->name) }}" alt="{{ $product->name }}"
                                    class="gallery-item cursor-pointer border border-gray-300 rounded-lg hover:shadow-lg transition-all duration-300 w-24 h-24 object-cover"
                                    onclick="changeMainImage(this)">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="product-infor md:w-1/2 w-full lg:pl-[15px] md:pl-2">
                    <div>
                        <div class="flex justify-between">
                            <div>

                                @if (App::getLocale() == 'ar')
                                    <div class="product-name heading4 mt-1">{{ $product->name }}</div>
                                @else
                                    <div class="product-name heading4 mt-1">{{ $product->namee }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                            <div class="product-price heading5 text-green-600">
                                @if ($discountedPrice)
                                    {{ number_format($discountedPrice, 2) }} {{ __('products.lyd') }}
                                @else
                                    {{ $product->price }} {{ __('products.lyd') }}
                                @endif
                            </div>
                            @if ($discountedPrice)
                                <div class="product-origin-price font-normal text-secondary2">
                                    <del>{{ $product->price }} {{ __('products.lyd') }}</del>
                                </div>
                                @if (isset($discount) && isset($discount->percentage))
                                    <div
                                        class="product-sale caption2 font-semibold bg-green px-3 py-0.5 inline-block rounded-full">
                                        -{{ $discount->percentage }}%
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="list-action mt-6">
                            @if ($product->stocks->pluck('grades')->filter()->isNotEmpty())
                                <div class="choose-color mt-5">
                                    <div class="text-title">@lang('products.colors'):</div>
                                    <div class="list-color flex items-center gap-2 flex-wrap mt-3">
                                        @foreach ($product->stocks->pluck('grades')->filter() as $grade)
                                            <div class="color-item w-12 h-12 rounded-full border border-gray-400 flex items-center justify-center hover:scale-110 transition-transform duration-300 cursor-pointer"
                                                 onclick="selectColor('{{ $grade->name }}')" id="color-{{ $grade->name }}">
                                                <span class="text-sm font-semibold">{{ $grade->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($product->stocks->pluck('sizes')->filter()->isNotEmpty())
                                <div class="choose-size mt-5">
                                    <div class="heading flex items-center justify-between">
                                        <div class="text-title">@lang('products.sizes'):</div>
                                    </div>
                                    <div class="list-size flex items-center gap-2 flex-wrap mt-3">
                                        @foreach ($product->stocks->pluck('sizes')->filter() as $size)
                                            <div class="size-item px-3 py-1 border rounded hover:bg-gray-200 transition-colors duration-300 cursor-pointer"
                                                 onclick="selectSize('{{ $size->name }}')" id="size-{{ $size->name }}">
                                                {{ $size->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="more-infor mt-6">
                                @if ($discountedPrice)
                                    <div class="flex items-center gap-1 mt-3 text-green-600 font-semibold">
                                        @lang('products.discount_available')
                                    </div>
                                @endif
                                <div class="flex items-center gap-1 mt-3">
                                    <div class="text-title">
                                        @if (App::getLocale() == 'ar')
                                            @lang('products.code_ar')
                                        @else
                                            @lang('products.code')
                                        @endif
                                    </div>
                                    <div class="text-secondary">{{ $product->barcode }}</div>
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <div class="text-title">@lang('products.categories'):</div>
                                    <div class="list-category text-secondary">
                                        @if (App::getLocale() == 'ar')
                                            {{ $product->categories->name ?? __('products.unknown_category') }}
                                        @else
                                            {{ $product->categories->englishname ?? __('products.unknown_category') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="choose-quantity flex items-center max-xl:flex-wrap lg:justify-between gap-5 mt-3">
                                <div
                                    class="quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-between rounded-lg border border-line sm:w-[140px] w-[120px] flex-shrink-0">
                                    <i class="ph-bold ph-minus cursor-pointer body1" onclick="updateQuantity(-1)"></i>
                                    <div id="quantity" class="quantity body1 font-semibold">1</div>
                                    <i class="ph-bold ph-plus cursor-pointer body1" onclick="updateQuantity(1)"></i>
                                </div>

                                <button
                                    class="add-cart-btn button-main whitespace-nowrap w-full text-center bg-black text-white border border-black hover:bg-gray-800 transition-colors duration-300"
                                    onclick="addToCart()">@lang('products.add_to_cart')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="list-product hide-product-sold grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 mt-7"
        data-item="9">
        @foreach ($products as $product)
            @php
                $discountt = $discount->where('products_id', $product->id)->first();
                $discountedPrice = $discountt
                    ? $product->price - ($product->price * $discountt->percentage) / 100
                    : null;
                $productSizes = $sizes->where('products_id', $product->id);
                $productGrades = $grades->where('products_id', $product->id);
                $productColors = $colors->where('products_id', $product->id);
            @endphp
            <a href="{{ route('product/info', encrypt($product->id)) }}"
                class="product-item style-marketplace-list flex flex-col items-center bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 relative"
                data-item="149" data-brand-id="{{ $product->brand_id }}">
                @if (App::getLocale() == 'ar')
                    <span class="caption2 uppercase absolute top-2 right-2 text-gray-500 bg-white px-2 py-1 rounded shadow">
                        {{ $product->categories->name ?? __('products.unknown_category') }}
                    </span>
                @else
                    <span class="caption2 uppercase absolute top-2 right-2 text-gray-500 bg-white px-2 py-1 rounded shadow">
                        {{ $product->categories->englishname ?? __('products.unknown_category') }}
                    </span>
                @endif
                @if ($discountt)
                    <div class="discount-badge absolute top-3 left-3 bg-red text-white text-xs font-bold px-2 py-1 rounded">
                        {{ __('products.discount') }} - {{ $discountt->percentage }}%
                    </div>
                @endif
                <div class="bg-img w-full aspect-square rounded-lg overflow-hidden">
                    <img class="w-full h-full object-cover product-image"
                        src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->name }}" />
                </div>
                <div class="product-infor text-center mt-4">
                    <span class="caption2 uppercase block text-gray-500">
                        {{ $product->brandname }}
                    </span>
                    <span class="caption2 mt-2 font-semibold block text-gray-800">
                        {{ $product->name ?? __('products.unknown_product') }}
                    </span>
                    <div class="flex items-center justify-center gap-3 mt-3">
                        @if ($discountt)
                            <span class="text-gray-500 line-through text-sm">{{ $product->price }}
                                {{ __('products.lyd') }}</span>
                            <span class="text-green-600 font-bold text-lg">{{ number_format($discountedPrice, 2) }}
                                {{ __('products.lyd') }}</span>
                        @else
                            <span class="text-gray-800 font-bold text-lg">{{ $product->price }}
                                {{ __('products.lyd') }}</span>
                        @endif
                    </div>
                    <div class="mt-3 text-sm text-gray-600">
                        @foreach ($productSizes as $size)
                            <span style="font-weight: bold;font-size: initial;">{{ $size->name }}</span>
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <div class="list-grades flex items-center justify-center flex-wrap gap-2 mt-2">
                            @foreach ($productGrades as $grade)
                                <div style="background-color: {{ $grade->name }}; border-color: {{ $grade->name }}"
                                    class="grade-item w-6 h-6 rounded-full border flex items-center justify-center">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-auto w-full flex justify-center">
                    <button
                        class="quick-view-btn px-4 py-2 bg-black text-white rounded-lg hover:bg-green-600 transition-colors duration-300">
                        <span>@lang('products.view')<i class="ph ph-eye text-sm"> </i></span>
                    </button>
                </div>
            </a>
        @endforeach
    </div>
    <style>
        .discount-badge {
            z-index: 10;
        }

        .product-item:hover {
            transform: translateY(-5px);
        }

        .bg-img img {
            transition: transform 0.3s ease;
        }

        .bg-img:hover img {
            transform: scale(1.1);
        }

        .quick-view-btn {
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 10px;
            width: 90%;
            /* Adjusted width for better alignment */
            text-align: center;
        }

        .quick-view-btn:hover {
            background-color: #28a745;
            transform: scale(1.05);
        }

        .product-item {
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Ensure the product card takes full height */
        }

        .product-infor {
            flex-grow: 1;
            /* Push the button to the bottom */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let selectedColor = null;
        let selectedSize = null;

        // Add these variables to determine if the product has color or size options
        var hasColor = {{ $product->stocks->pluck('grades')->filter()->isNotEmpty() ? 'true' : 'false' }};
        var hasSize = {{ $product->stocks->pluck('sizes')->filter()->isNotEmpty() ? 'true' : 'false' }};

        function changeMainImage(imageElement) {
            const mainImage = document.getElementById('main-product-image');
            mainImage.src = imageElement.src;
            mainImage.classList.add('opacity-0');
            setTimeout(() => {
                mainImage.classList.remove('opacity-0');
            }, 100);
        }

        function selectColor(color) {
            selectedColor = color;
            // Remove highlight from all color items
            document.querySelectorAll('.color-item').forEach(item => {
                item.classList.remove('bg-gray-500', 'text-sel', 'border-gray-500');
            });
            // Highlight the selected color
            const selectedElement = document.getElementById(`color-${color}`);
            if (selectedElement) {
                selectedElement.classList.add('bg-gray-500', 'text-sel', 'border-gray-500');
                // Show selection notification for color
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '@lang('products.color_selected')',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }

        function selectSize(size) {
            selectedSize = size;
            // Remove highlight from all size items
            document.querySelectorAll('.size-item').forEach(item => {
                item.classList.remove('bg-gray-500', 'text-sel', 'border-gray-500');
            });
            // Highlight the selected size
            const selectedElement = document.getElementById(`size-${size}`);
            if (selectedElement) {
                selectedElement.classList.add('bg-gray-500', 'text-sel', 'border-gray-500');
                // Show selection notification for size
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '@lang('products.size_selected')',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }

        function updateQuantity(change) {
            const quantityElement = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityElement.textContent);
            currentQuantity = Math.max(1, currentQuantity + change); // Ensure quantity is at least 1
            quantityElement.textContent = currentQuantity;
        }

        function addToCart() {
            // Only enforce selection if the product has the respective option
            if ((hasColor && !selectedColor) || (hasSize && !selectedSize)) {
                Swal.fire({
                    icon: 'warning',
                    title: '@lang('products.select_color_or_size')',
                    text: '@lang('products.please_select_color_or_size')',
                });
                return;
            }

            const quantity = parseInt(document.getElementById('quantity').textContent);

            fetch('{{ route('cart.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: '{{ $product->id }}',
                        color: selectedColor,
                        size: selectedSize,
                        quantity: quantity
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text || `HTTP error! status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: '@lang('products.added_to_cart')',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // Update the cart quantity in the cart icon
                        const cartQuantityElement = document.querySelector('.cart-quantity');
                        const currentCartQuantity = parseInt(cartQuantityElement.textContent) || 0;
                        cartQuantityElement.textContent = currentCartQuantity + quantity;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '@lang('products.error_adding_to_cart')',
                            text: data.message || '@lang('products.try_again_later')',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: '@lang('products.error_adding_to_cart')',
                        text: '@lang('products.try_again_later')',
                    });
                });
        }
    </script>

@endsection
