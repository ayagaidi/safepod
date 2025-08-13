@extends('front.app')
@section('title', __('products.proudacts'))
@section('content')

    <div id="menu-department-block" class="menu-department-block relative h-full hidden">
        <!-- Added 'hidden' class to hide the section on page load -->
    </div>

    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[124px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">{{ __('products.search') }}
                             
                        </div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('/') }}" class="hover:underline">{{ __('products.home') }}</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <div class="text-secondary2 capitalize">{{ __('products.search') }} 
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shop-product search-result-block lg:py-20 md:py-14 py-10">
        <div class="container">
           
            <div class="list-product-block relative md:pt-10 pt-6">
                <div class="heading6">{{ __('products.search_result') }}: <span class="result">{{ $q }}</span></div>
                    @if($q)
                   
                        @if(count($products))
                        <div class="list-product hide-product-sold grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 grid-cols-1 sm:gap-8 gap-6 mt-7"
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
                                data-item="149" >
                                @if (App::getLocale() == 'ar')
                                    <span
                                        class="caption2 uppercase absolute top-2 right-2 text-gray-500 bg-white px-2 py-1 rounded shadow">
                                        {{ $product->category_name ?? __('products.unknown_category') }}
                                    </span>
                                @else
                                    <span
                                        class="caption2 uppercase absolute top-2 right-2 text-gray-500 bg-white px-2 py-1 rounded shadow">
                                        {{ $product->category_namee ?? __('products.unknown_category') }}
                                    </span>
                                @endif
                                @if ($discountt)
                                    <div
                                        class="discount-badge absolute top-3 left-3 bg-red text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ __('products.discount') }} - {{ $discountt->percentage }}%
                                    </div>
                                @endif
                                <div class="bg-img w-full aspect-square rounded-lg overflow-hidden">
                                    <img class="w-full h-full object-cover product-image"
                                        src="{{ asset('images/product/' . $product->image) }}"
                                        alt="{{ $product->name }}" />
                                </div>
                                <div class="product-infor text-center mt-4">
                                    <span class="caption2 uppercase block text-gray-500">
                                        {{ $product->brandname }}
                                    </span>
                                    @if (App::getLocale() == 'ar')
                                    <span class="caption2 mt-2 font-semibold block text-gray-800" lang="{{ app()->getLocale() }}">
                                        {{ $product->name ?? __('products.unknown_product') }}
                                    </span>
                                @else
                                <span class="caption2 mt-2 font-semibold block text-gray-800" lang="{{ app()->getLocale() }}">
                                    {{ $product->namee ?? __('products.unknown_product') }}
                                </span>
                                @endif
                                
                                    
                                    <div class="flex items-center justify-center gap-3 mt-3">
                                        <span class="text-gray-800 font-bold text-lg">{{ $product->price }}
                                                {{ __('products.lyd') }}</span>
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
                                                <div style=" border-color: {{ $grade->name }}"
                                                    class="grade-item w-6 h-6 border flex items-center justify-center">
                                                     {{ $grade->name }}
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
                        {{-- Pagination links --}}
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                        {{-- Custom pagination style --}}
                        
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
                        @else
                            <p style="text-align: center">{{ __('products.no_search_result') }}</p>
                        @endif
                    @else
                    <p style="text-align: center">{{ __('products.no_search_result') }}</p>
                    @endif
                </div>
            </div>
           
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBlock = document.getElementById('menu-department-block');

            if (menuBlock) {
                menuBlock.classList.toggle('hidden'); // Toggle visibility on page load
            }

            const colorElements = document.querySelectorAll('.color-item');

            colorElements.forEach((element, index) => {
                const colorCode = element.getAttribute('data-item');
                const colorNameElement = document.getElementById(`color-name-${index}`);

                if (colorCode && colorNameElement) { // Ensure both the attribute and element exist
                    const sanitizedColorCode = colorCode.replace(/\s+/g, ''); // Remove spaces
                    if (sanitizedColorCode.startsWith('#')) {
                        fetch(`https://www.thecolorapi.com/id?hex=${sanitizedColorCode.substring(1)}`)
                            .then(response => response.json())
                            .then(data => {
                                colorNameElement.textContent = data.name.value || 'Unknown';
                            })
                            .catch(() => {
                                colorNameElement.textContent = 'Error';
                            });
                    } else {
                        colorNameElement.textContent = 'Invalid Color';
                    }
                }
            });

            // Fetch and display color names for grades
            const gradeElements = document.querySelectorAll('.grade-item');

            gradeElements.forEach((element, index) => {
                const gradeColorCode = element.getAttribute('data-item');
                const gradeNameElement = document.getElementById(`grade-name-${index}`);

                if (gradeColorCode && gradeNameElement) { // Ensure both the attribute and element exist
                    const sanitizedGradeColorCode = gradeColorCode.replace(/\s+/g, ''); // Remove spaces
                    if (sanitizedGradeColorCode.startsWith('#')) {
                        fetch(`https://www.thecolorapi.com/id?hex=${sanitizedGradeColorCode.substring(1)}`)
                            .then(response => response.json())
                            .then(data => {
                                gradeNameElement.textContent = data.name.value || 'Unknown';
                            })
                            .catch(() => {
                                gradeNameElement.textContent = 'Error';
                            });
                    } else {
                        gradeNameElement.textContent = 'Invalid Color';
                    }
                }
            });

            // Convert specific color #d783ff to its name
            const specificColorCode = '#d783ff';
            fetch(`https://www.thecolorapi.com/id?hex=${specificColorCode.substring(1)}`)
                .then(response => response.json())
                .then(data => {
                    console.log(`The name of the color ${specificColorCode} is: ${data.name.value}`);
                })
                .catch(() => {
                    console.error('Error fetching the color name for #d783ff');
                });

            const productImages = document.querySelectorAll('.product-image');
            const body = document.querySelector('body');

            productImages.forEach(image => {
                image.addEventListener('click', () => {
                    const overlay = document.createElement('div');
                    overlay.classList.add('image-overlay');
                    overlay.innerHTML = `
                        <div class="overlay-content">
                            <img src="${image.src}" alt="Product Image" class="enlarged-image">
                    `;
                    body.appendChild(overlay);

                    const closeButton = overlay.querySelector('.close-overlay');
                    closeButton.addEventListener('click', () => {
                        overlay.remove();
                    });

                    overlay.addEventListener('click', (e) => {
                        if (e.target === overlay) {
                            overlay.remove();
                        }
                    });
                });
            });
        });
    </script>
    <style>
        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: red;
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            z-index: 1;
        }

        .product-item {
            position: relative;
            /* Ensure the badge is positioned relative to the product card */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e5e5e5;
            border-radius: 10px;
            overflow: hidden;
        }

        .product-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-infor {
            padding: 15px;
            text-align: center;
        }

        .product-infor .caption2 {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
        }

        .product-infor .caption2.uppercase {
            font-size: 0.85rem;
            color: #888;
        }

        .product-infor .flex {
            justify-content: center;
        }

        .quick-view-btn {
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 10px;
        }

        .quick-view-btn:hover {
            background-color: #28a745;
            transform: scale(1.1);
        }

        .list-product {
            gap: 30px;
            padding: 20px 0;
        }

        .line-through {
            position: relative;
            color: red;
            font-size: 0.9rem;
        }

        .line-through::before {
            content: 'X';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2em;
            color: red;
            font-weight: bold;
        }

        .discounted-price {
            color: green;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .bg-img {
            width: 100px;
            /* Adjusted width */
            height: 100px;
            /* Adjusted height */
            flex-shrink: 0;
            aspect-ratio: 1/1;
            overflow: hidden;
            border-radius: 8px;
            /* Optional: Add rounded corners */
        }

        .bg-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .overlay-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
        }

        .enlarged-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .close-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #fff;
            border: none;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-overlay:hover {
            background: #f00;
            color: #fff;
        }
    </style>
@endsection
