<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use App\Models\Orderitems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Schema;
use App\Models\OrderItem;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'customer_name.required'    => app()->getLocale() == 'ar' ? 'يرجى إدخال اسم العميل' : 'Please enter the customer name',
            'customer_phone.required'   => app()->getLocale() == 'ar' ? 'يرجى إدخال رقم الهاتف' : 'Please enter the customer phone number',
            'customer_address.required' => app()->getLocale() == 'ar' ? 'يرجى إدخال العنوان' : 'Please enter the customer address',
        ];

        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string',
            'customer_address' => 'required|string',
            'customer_city'    => 'required|string', // Add validation for customer_city
        ], $messages);

        // Retrieve cart from session
        $cart = session('cart', []);
    

        if (empty($cart)) {
            return redirect()->back()->withErrors(['cart' => __('The cart must contain products')]);
        }

        DB::beginTransaction();
        try {
            // حساب إجمالي الطلب
            $total = array_reduce($cart, function ($carry, $item) {
                $discountedPrice = $item['price'] - $item['discount'];
                return $carry + ($discountedPrice * $item['quantity']);
            }, 0);


            $city=City::find($validated['customer_city']);
            if (!$city) {
               $cityName='';
                // return redirect()->back()->withErrors(['customer_city' => __('Invalid city selected')]);
            }else{
                $cityName = $city->name;
            }
            // إنشاء الطلب الجديد
            $order = Order::create([
                'full_name'    => $validated['customer_name'],
                'phonenumber'   => $validated['customer_phone'],
                'address' => $cityName . ' ' . $validated['customer_address'], // Ensure customer_city is concatenated
                'total_price'            => $total,
                'order_statues_id'=>1
            ]);



            // إضافة عناصر الطلب من السلة
            foreach ($cart as $item) {

                Orderitems::create([
                    'orders_id'   => $order->id,
                    'products_id' => $item['product_id'],
                    'price'       => $item['price'],
                    'grades_id'   => isset($item['grades_id']) ? $item['grades_id'] : null, // if product has no color, null is saved
                    'sizes_id'    => isset($item['sizes_id']) ? $item['sizes_id'] : null,  // if product has no size, null is saved
                    'quantty'     => $item['quantity'],

                ]);
            }

            // إضافة إشعار للطلب الجديد
            DB::table('notifications')->insert([
                'orders_id'  => $order->id,
                'url'=>'pending/oreder',
                'message'    => __('لديك طلب جديد تحت رقم: ORD - ') . $order->id,
                'messageen'  => __('You have a new request under number: ORD - ') . $order->id,
                'created_at' => now(),

            ]);

            session()->forget('cart');

            DB::commit();

            // Redirect to the success page and pass the order id
            return redirect()->route('order/success')->with('order_id', $order->id);
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error(trans('category.update_failed'));
            return redirect()->back()->withErrors(['error' => __('products.error_occurred')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * Display the order success page.
     */
    public function success()
    {
        $orderId = session('order_id');
        $order=Order::find($orderId);
        return view('front.order-success', compact('order'));
    }

    /**
     * Remove an item from the order.
     */

    /**
     * Mark the order as completed.
     */
   
}
