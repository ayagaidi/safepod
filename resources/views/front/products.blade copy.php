@extends('front.app')
@section('title', __('products.proudacts'))
@section('content')

@php
    $q = request('q');
    $products = [];
    if($q){
       // Using parameter binding to run the provided query
       $products = DB::select("SELECT `name`, `namee`, `brandname`, `barcode`, `price`, `categories_id`, `created_at` FROM `products` WHERE `name` LIKE ? OR `namee` LIKE ? OR `brandname` LIKE ? OR `barcode` LIKE ?", ["%$q%", "%$q%", "%$q%", "%$q%"]);
    }
@endphp

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
            <div class="heading flex flex-col items-center">
                <div class="heading4 text-center">
                    Found <span class="result-quantity">{{ count($products) }}</span> results for "<span class="result">{{ $q }}</span>"
                </div>
                <div class="input-block lg:w-1/2 sm:w-3/5 w-full md:h-[52px] h-[44px] sm:mt-8 mt-5">
                    <div class="form-search w-full h-full relative">
                        {{-- Wrap the input inside a form to submit the query --}}
                        <form method="GET" action="{{ route('search') }}">
                            <input type="text" name="q" placeholder="Search..." value="{{ $q }}"
                                class="caption1 w-full h-full pl-4 md:pr-[150px] pr-32 rounded-xl border border-line">
                            <button type="submit" class="button-main absolute top-1 bottom-1 right-1 flex items-center justify-center">search</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="list-product-block relative md:pt-10 pt-6">
                <div class="heading6">Product Search: <span class="result">{{ $q }}</span></div>
                <div class="list-product list-product-result hide-product-sold grid lg:grid-cols-4 sm:grid-cols-3 grid-cols-2 sm:gap-[30px] gap-[20px] mt-5">
                    @if($q)
                        @if(count($products))
                            @foreach ($products as $product)
                                <div class="product-item p-4 border rounded">
                                    <div><strong>{{ $product->brandname }}</strong></div>
                                    <div>{{ $product->name ?? $product->namee }}</div>
                                    <div><small>{{ $product->barcode }}</small></div>
                                    <div>${{ $product->price }}</div>
                                    <div><small>{{ $product->created_at }}</small></div>
                                </div>
                            @endforeach
                        @else
                            <p>No product searched.</p>
                        @endif
                    @else
                        <p>No product searched.</p>
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
