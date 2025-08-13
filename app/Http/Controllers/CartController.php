<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Discount;
use App\Models\products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        try {
            if ($request->method() !== 'POST') {
                return response()->json(['success' => false, 'message' => __('products.invalid_request_method')], 400);
            }

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'color' => 'nullable|string',
                'size' => 'nullable|string',
                'quantity' => 'required|integer|min:1',
                'discount_code' => 'nullable|string',
            ]);

            $cart = session()->get('cart', []);
            $product = products::find($request->product_id);

            if ($request->size && $request->color) {
                $availableStock = $product->stocks()
                    ->where('sizes_id', $product->sizes()->where('name', $request->size)->value('id'))
                    ->where('grades_id', $product->grades()->where('name', $request->color)->value('id'))
                    ->value('quantty');
            } elseif ($request->size) {
                $availableStock = $product->stocks()
                    ->where('sizes_id', $product->sizes()->where('name', $request->size)->value('id'))
                    ->whereNull('grades_id')
                    ->value('quantty');
            } elseif ($request->color) {
                $availableStock = $product->stocks()
                    ->where('grades_id', $product->grades()->where('name', $request->color)->value('id'))
                    ->whereNull('sizes_id')
                    ->value('quantty');
            } else {
                $availableStock = $product->stocks()
                    ->whereNull('sizes_id')
                    ->whereNull('grades_id')
                    ->value('quantty');
            }

            $productDiscount = Discount::where('products_id', $request->product_id)->first();
            $existingItemKey = null;
            foreach ($cart as $key => $item) {
                if ($item['product_id'] == $request->product_id &&
                    $item['color'] == $request->color &&
                    $item['size'] == $request->size) {
                    $existingItemKey = $key;
                    break;
                }
            }

            if ($existingItemKey !== null) {
                $cart[$existingItemKey]['quantity'] += $request->quantity;
            } else {
                $cart[] = [
                    'product_id'      => $request->product_id,
                    'product_name'    => $product->name,
                    'product_image'   => $product->image,
                    'product_code'    => $product->barcode,
                    'color'           => $request->color,
                    'grades_id'       => $request->color ? $product->grades()->where('name', $request->color)->value('id') : null,
                    'size'            => $request->size,
                    'sizes_id'        => $request->size ? $product->sizes()->where('name', $request->size)->value('id') : null,
                    'quantity'        => $request->quantity,
                    'price'           => $product->price,
                    'discount'        => $productDiscount ? $productDiscount->percentage : 0,
                    'discounted_price'=> $productDiscount ? ($product->price - ($product->price * ($productDiscount->percentage / 100))) : $product->price
                ];

            }

            session()->put('cart', $cart);
  
            $cartTotal = array_reduce($cart, function ($total, $item) {
                return $total + (($item['discounted_price'] ?? 0) * $item['quantity']);
            }, 0);

            return response()->json([
                'success' => true,
                'message' => __('products.added_to_cart'),
                'cart' => $cart,
                'total' => $cartTotal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('products.error_occurred') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        $discount = 0;

        foreach ($cart as &$item) {
            $itemSubtotal = ($item['price'] ?? 0) * $item['quantity'];
            $itemDiscount = !empty($item['discount']) ? $itemSubtotal * ($item['discount'] / 100) : 0;

            $item['discount_percentage'] = !empty($item['discount']) ? $item['discount'] : 0; // Pass discount percentage
            $item['discounted_price'] = $itemSubtotal - $itemDiscount;

            $subtotal += $itemSubtotal;
            $discount += $itemDiscount;
        }

        $total = $subtotal - $discount;

        $cities=City::get();
        return view('front.cart', compact('cart', 'subtotal', 'discount', 'total','cities'));
    }

    public function getCartItems()
    {
        $cart = session()->get('cart', []);
        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function clear(Request $request)
    {
        $orderStatus = $request->input('order_status');

        if (in_array($orderStatus, ['completed', 'canceled'])) {
            session()->forget('cart');
            return redirect()->back()->with('success', __('products.cart_cleared'));
        }

        return redirect()->back()->with('error', __('products.cart_not_cleared'));
    }

    public function remove($product_id)
    {
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, fn($item) => $item['product_id'] != $product_id);
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => __('products.item_removed')]);
    }

    public function getCartItemCount()
    {
        $cart = session()->get('cart', []);
        $count = array_reduce($cart, fn($total, $item) => $total + $item['quantity'], 0);

        return response()->json(['success' => true, 'count' => $count]);
    }

    public function updateQuantity(Request $request, $product_id)
    {
        $cart = session()->get('cart', []);
        $newQuantity = $request->input('quantity');

        foreach ($cart as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] = $newQuantity;
                $item['discounted_price'] = $item['price'] - ($item['price'] * ($item['discount'] / 100));
                break;
            }
        }

        session()->put('cart', $cart);

        $grandTotal = array_reduce($cart, function ($total, $item) {
            return $total + ($item['discounted_price'] * $item['quantity']);
        }, 0);

        return response()->json([
            'success' => true,
            'totalPrice' => $cart[array_search($product_id, array_column($cart, 'product_id'))]['discounted_price'] * $newQuantity,
            'grandTotal' => $grandTotal,
        ]);
    }
}
