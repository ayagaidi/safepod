@extends('front.app')

@section('title', app()->getLocale() === 'ar'
    ? trans('home.cart') . ' - ' . 'عربة التسوق'
    : trans('home.cart') . ' - ' . 'Shopping Cart')

@section('content')
<form method="POST" action="{{ route('order.store') }}">
    @csrf
    {{-- نمرر سلة الشراء كما هي (سنحدّثها من JS عند تغيير الكمية/الحذف) --}}
    <input type="hidden" name="cart" id="cart-hidden-input" value='@json($cart)'>

    {{-- Breadcrumb --}}
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

                {{-- LEFT: Cart Table --}}
                <div class="xl:w-2/3 xl:pr-3 w-full">
                    <div class="kid-card">
                        @if(empty($cart) || count($cart) === 0)
                            <div class="empty-cart">
                                <div class="bubble"><i class="ph ph-shopping-cart-simple"></i></div>
                                <h3 class="heading4 m-0">{{ __('products.cart_empty') ?? (app()->getLocale()==='ar' ? 'سلة التسوق فارغة' : 'Your cart is empty') }}</h3>
                                <p class="mt-2 text-secondary2">{{ __('products.add_items_cart') ?? (app()->getLocale()==='ar' ? 'أضِف منتجات للمتابعة' : 'Add some items to continue.') }}</p>
                                <a class="pill go-shop" href="{{ route('all_products') }}">
                                    <i class="ph ph-storefront"></i><span>{{ __('products.continue_shopping') }}</span>
                                </a>
                            </div>
                        @else
                            <div class="table-head">
                                <div class="title-row">
                                    <i class="ph ph-shopping-cart-simple"></i>
                                    <span class="heading5">{{ __('products.cart') }}</span>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="kid-table min-w-full">
                                    <thead>
                                    <tr>
                                        <th>{{ __('products.products') }}</th>
                                        <th>{{ __('products.price') }}</th>
                                        <th>{{ __('product.discount_value') }}</th>
                                        <th>{{ __('product.discount_percentage') }}</th>
                                        <th>{{ __('products.size') }}</th>
                                        <th>{{ __('products.color') }}</th>
                                        <th>{{ __('products.quantity') }}</th>
                                        <th>{{ __('products.total_price') }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($cart as $item)
                                        @php
                                            $pid   = $item['product_id'];
                                            $price = (float)($item['price'] ?? 0);
                                            $discP = (float)($item['discount'] ?? 0);
                                            $discV = $price * $discP / 100;
                                            $qty   = (int)($item['quantity'] ?? 1);
                                            $total = ($price - $discV) * $qty;
                                        @endphp
                                        <tr id="cart-item-{{ $pid }}">
                                            <td class="prod-cell">
                                                <div class="prod-flex">
                                                    <div class="thumb">
                                                        <img src="{{ asset('images/product/' . ($item['product_image'] ?? 'default.png')) }}"
                                                             alt="{{ __('products.product_image') }}">
                                                    </div>
                                                    <div class="meta">
                                                        <div class="name">{{ $item['product_name'] ?? __('products.not_available') }}</div>
                                                        <div class="code text-secondary2">{{ $item['product_code'] ?? __('products.not_available') }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ number_format($price, 2) }} {{ __('products.lyd') }}</td>
                                            <td>{{ number_format($discV, 2) }} {{ __('products.lyd') }}</td>
                                            <td>{{ number_format($discP, 0) }}%</td>
                                            <td>{{ $item['size'] ?? __('products.not_available') }}</td>

                                            <td>
                                                @if(!empty($item['color']))
                                                    <span class="color-dot" style="background: {{ $item['color'] }}"></span>
                                                @else
                                                    {{ __('products.not_available') }}
                                                @endif
                                            </td>

                                            <td>
                                                <div class="qty-group" data-product-id="{{ $pid }}">
                                                    <button type="button" class="qty-btn dec" aria-label="Decrease">
                                                        <i class="ph ph-minus"></i>
                                                    </button>
                                                    <input type="number"
                                                           class="quantity-input"
                                                           value="{{ $qty }}" min="1"
                                                           data-product-id="{{ $pid }}">
                                                    <button type="button" class="qty-btn inc" aria-label="Increase">
                                                        <i class="ph ph-plus"></i>
                                                    </button>
                                                </div>
                                            </td>

                                            <td class="total-price" id="total-price-{{ $pid }}">
                                                {{ number_format($total, 2) }} {{ __('products.lyd') }}
                                            </td>

                                            <td class="actions">
                                                <button type="button"
                                                        class="remove-item danger"
                                                        title="{{ __('products.remove') }}"
                                                        aria-label="{{ __('products.remove') }}"
                                                        data-product-id="{{ $pid }}">
                                                    <i class="ph ph-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- RIGHT: Summary / Customer info --}}
                <div class="xl:w-1/3 xl:pl-12 w-full">
                    <div class="kid-card">
                        <div class="title-row">
                            <i class="ph ph-notepad"></i>
                            <span class="heading5">{{ __('products.order_summary') }}</span>
                        </div>

                        <div class="field">
                            <label for="customer_name" class="text-title">{{ __('products.customer_name') }}</label>
                            <input type="text" id="customer_name" name="customer_name"
                                   value="{{ old('customer_name', $customerName ?? '') }}"
                                   class="kid-input" placeholder="{{ __('products.enter_name') }}" required>
                        </div>

                        <div class="field">
                            <label for="customer_phone" class="text-title">{{ __('products.customer_phone') }}</label>
                            <input type="text" id="customer_phone" name="customer_phone"
                                   value="{{ old('customer_phone', $customerPhone ?? '') }}"
                                   class="kid-input"
                                   placeholder="{{ __('products.enter_phone') }}" required
                                   pattern="^(091|092|094|095|093)\d{7}$"
                                   title="{{ __('products.phone_validation_message') }}">
                        </div>

                        <div class="field">
                            <label for="customer_address" class="text-title">{{ __('products.customer_address') }}</label>

                            <select id="customer_city" name="customer_city" class="kid-input">
                                <option value="" disabled selected>{{ __('products.enter_city') }}</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ (old('customer_city', $customerCity ?? '') == $city->id) ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="text" id="customer_address" name="customer_address"
                                   value="{{ old('customer_address', $customerAddress ?? '') }}"
                                   class="kid-input mt-2" placeholder="{{ __('products.enter_address') }}" required>
                        </div>

                        <div class="field">
                            <label for="terms" class="checkline">
                                <input type="checkbox" id="terms" name="terms">
                                <span>{{ __('products.agree_to_terms') }}</span>
                            </label>
                            <a href="{{ route('policies') }}" target="_blank" class="link">
                                {{ __('products.terms_and_policies') }}
                            </a>
                        </div>

                        @php
                            $grandTotal = array_reduce($cart, function ($total, $item) {
                                $price = (float)($item['price'] ?? 0);
                                $discP = (float)($item['discount'] ?? 0);
                                $discV = $price * $discP / 100;
                                $qty   = (int)($item['quantity'] ?? 1);
                                return $total + (($price - $discV) * $qty);
                            }, 0);
                        @endphp

                        <div class="sum-row">
                            <div class="heading5">{{ __('products.total') }}</div>
                            <div id="grand-total-value">{{ number_format($grandTotal, 2) }} {{ __('products.lyd') }}</div>
                        </div>

                        <div class="btns mt-4">
                            <button type="submit" class="button-main w-full checkout-btn" style="background:#00c2a8" disabled>
                                {{ __('products.process_to_checkout') }}
                            </button>
                            <a class="text-button hover-underline center-link" href="{{ route('all_products') }}" style="color:#00a2c7">
                                {{ __('products.continue_shopping') }}
                            </a>
                        </div>
                    </div>
                </div>

            </div> {{-- /content-main --}}
        </div>
    </div>
</form>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hiddenInput = document.getElementById('cart-hidden-input');

    /** Helper: read & write hidden cart JSON **/
    function getCartJSON(){
        try { return JSON.parse(hiddenInput.value || '[]'); } catch(e){ return []; }
    }
    function setCartJSON(cart){
        hiddenInput.value = JSON.stringify(cart);
    }
    function updateCartRowTotalsFromServer(data, productId){
        // per-item total
        if (typeof data.totalPrice !== 'undefined') {
            const rowTotal = document.getElementById('total-price-' + productId);
            if (rowTotal) rowTotal.textContent = `${Number(data.totalPrice).toFixed(2)} {{ __('products.lyd') }}`;
        }
        // grand total
        if (typeof data.grandTotal !== 'undefined') {
            const grand = document.getElementById('grand-total-value');
            if (grand) grand.textContent = `${Number(data.grandTotal).toFixed(2)} {{ __('products.lyd') }}`;
        }
    }

    /** Remove item **/
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const itemRow = document.getElementById('cart-item-' + productId);

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
                if (!result.isConfirmed) return;

                fetch(`{{ url('/cart/remove') }}/${productId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept':'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) throw new Error('remove failed');

                    // remove row
                    if (itemRow) itemRow.remove();

                    // update hidden cart
                    const cart = getCartJSON().filter(x => String(x.product_id) !== String(productId));
                    setCartJSON(cart);

                    // update grand total if API sent it; else set 0 when empty
                    if (typeof data.grandTotal !== 'undefined') {
                        const grand = document.getElementById('grand-total-value');
                        if (grand) grand.textContent = `${Number(data.grandTotal).toFixed(2)} {{ __('products.lyd') }}`;
                    } else if (cart.length === 0) {
                        const grand = document.getElementById('grand-total-value');
                        if (grand) grand.textContent = `0.00 {{ __('products.lyd') }}`;
                    }

                    // update cart icon counter if present
                    if (typeof data.cartCount !== 'undefined') {
                        const badge = document.getElementById('cart-count');
                        if (badge) badge.textContent = data.cartCount;
                    }

                    Swal.fire('{{ __('products.removed') }}', '{{ __('products.item_removed_success') }}', 'success');
                })
                .catch(() => {
                    Swal.fire('{{ __('products.error') }}', '{{ __('products.error_occurred') }}', 'error');
                });
            });
        });
    });

    /** Quantity change via input **/
    function sendQtyUpdate(productId, newQty){
        return fetch(`{{ url('/cart/update') }}/${productId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type':'application/json' },
            body: JSON.stringify({ quantity: newQty }),
        }).then(r => r.json());
    }

    function updateHiddenCartQty(productId, newQty){
        const cart = getCartJSON();
        const item = cart.find(x => String(x.product_id) === String(productId));
        if (item) item.quantity = Number(newQty);
        setCartJSON(cart);
    }

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-product-id');
            const newQuantity = Math.max(1, parseInt(this.value || '1', 10));
            this.value = newQuantity;

            sendQtyUpdate(productId, newQuantity)
                .then(data => {
                    if (!data.success) throw new Error('update failed');
                    updateHiddenCartQty(productId, newQuantity);
                    updateCartRowTotalsFromServer(data, productId);

                    if (typeof data.cartCount !== 'undefined') {
                        const badge = document.getElementById('cart-count');
                        if (badge) badge.textContent = data.cartCount;
                    }
                })
                .catch(() => {
                    Swal.fire('{{ __('products.error') }}', '{{ __('products.error_occurred') }}', 'error');
                });
        });
    });

    /** Quantity stepper buttons **/
    document.querySelectorAll('.qty-group').forEach(group => {
        const pid = group.getAttribute('data-product-id');
        const input = group.querySelector('.quantity-input');
        const dec = group.querySelector('.qty-btn.dec');
        const inc = group.querySelector('.qty-btn.inc');

        dec.addEventListener('click', () => {
            const val = Math.max(1, (parseInt(input.value || '1', 10) - 1));
            if (val === parseInt(input.value, 10)) return;
            input.value = val;
            input.dispatchEvent(new Event('change'));
        });
        inc.addEventListener('click', () => {
            const val = Math.max(1, (parseInt(input.value || '1', 10) + 1));
            input.value = val;
            input.dispatchEvent(new Event('change'));
        });
    });

    /** Terms checkbox -> enable/disable checkout **/
    const termsCheckbox = document.getElementById('terms');
    const checkoutButton = document.querySelector('.checkout-btn');
    termsCheckbox.addEventListener('change', function() {
        checkoutButton.disabled = !this.checked;
    });
});
</script>

{{-- Minor responsive helpers --}}
<style>
/* Card shell (consistent with theme) */
.kid-card{
  background:#fff; border:1px solid #e9eef3; border-radius:16px; padding:16px;
  box-shadow:0 8px 18px rgba(16,24,40,.06);
}

/* Empty cart */
.empty-cart{ text-align:center; padding:28px }
.empty-cart .bubble{
  width:64px; height:64px; margin:0 auto 10px; border-radius:999px; display:grid; place-items:center;
  background:#f0fffc; color:#00a28f; border:1px solid #dbf5ef
}
.empty-cart .bubble .ph{ font-size:28px }
.empty-cart .go-shop{ margin-top:10px }

/* Pills / links */
.pill{
  display:inline-flex; align-items:center; gap:8px; height:36px; padding:0 14px;
  border-radius:999px; border:1px solid #e7ebf0; background:#fff; font-weight:800; color:#0f172a; text-decoration:none
}
.pill:hover{ border-color:#00c2a8; box-shadow:0 8px 18px rgba(16,24,40,.08) }
.center-link{ display:inline-flex; justify-content:center; width:100% }

/* Table */
.kid-table{ width:100%; border-collapse:separate; border-spacing:0 10px }
.kid-table thead th{
  font-size:.85rem; color:#64748b; font-weight:800; text-transform:uppercase; text-align:center;
  padding:10px 8px; border-bottom:1px dashed #e7ebf0
}
.kid-table tbody tr{
  background:#fff; border:1px solid #eef2f7; border-radius:12px; box-shadow:0 8px 18px rgba(16,24,40,.06)
}
.kid-table tbody td{
  padding:12px 8px; text-align:center; vertical-align:middle
}

/* Product cell */
.prod-flex{ display:flex; align-items:center; gap:10px; justify-content:center }
.thumb{ width:48px; height:48px; border-radius:10px; overflow:hidden; background:#fff; border:1px solid #eef2f7 }
.thumb img{ width:100%; height:100%; object-fit:cover }
.meta .name{ font-weight:800; color:#0f172a }
.meta .code{ font-size:.85rem }

/* Color dot */
.color-dot{ display:inline-block; width:18px; height:18px; border-radius:999px; border:1px solid #e5e7eb }

/* Qty group */
.qty-group{ display:inline-flex; align-items:center; gap:6px; border:1px solid #e7ebf0; border-radius:10px; padding:4px }
.qty-group .qty-btn{
  width:32px; height:32px; border:0; background:#f7fffe; color:#0f172a; border-radius:8px; display:grid; place-items:center; cursor:pointer
}
.qty-group .qty-btn:hover{ background:#eafff9 }
.qty-group .quantity-input{
  width:56px; height:32px; border:0; text-align:center; font-weight:700; outline:none
}

/* Actions */
.actions .danger{
  width:36px; height:36px; border-radius:10px; border:0; background:#fff1f2; color:#e11d48; display:grid; place-items:center
}
.actions .danger:hover{ filter:brightness(.96) }

/* Summary fields */
.title-row, .table-head .title-row{
  display:flex; align-items:center; gap:8px; margin-bottom:10px; color:#0f172a
}
.title-row .ph{ font-size:18px }
.field{ margin:12px 0 }
.kid-input{
  width:100%; height:42px; border:1px solid #e7ebf0; border-radius:10px; padding:0 12px; outline:none
}
.kid-input:focus{ border-color:#00c2a8 }
.checkline{ display:flex; align-items:center; gap:8px }
.link{ display:inline-block; margin-top:6px; color:#00a2c7; text-decoration:none }
.link:hover{ text-decoration:underline }

.sum-row{ display:flex; align-items:center; justify-content:space-between; margin-top:10px; padding-top:10px; border-top:1px dashed #e7ebf0 }

/* SweetAlert mobile button stack */
@media (max-width: 600px) {
  .swal2-actions-custom { flex-direction: column !important; }
}

/* Responsive: turn table rows into cards on very small screens */
@media (max-width: 520px){
  .kid-table thead{ display:none }
  .kid-table, .kid-table tbody, .kid-table tr, .kid-table td{ display:block; width:100% }
  .kid-table tbody tr{ margin-bottom:12px; padding:10px }
  .kid-table tbody td{ text-align:left }
  .prod-flex{ justify-content:flex-start }
}
</style>
@endsection
