<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderitems;
use App\Models\Disbursement;
use App\Models\DisbursementItem;
use App\Models\exchange;
use App\Models\exchangeitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */

    public function orderitem($id)
    {
        // Decrypt the provided id and fetch the order details
        $orderid = decrypt($id);
        $order = Order::with('orderstatues')->findOrFail($orderid);
        $ordersitem = Orderitems::with('orders', 'grades', 'sizes', 'products', 'products.stocks')
            ->where('orders_id', $orderid)
            ->get()
            ->map(function ($item) {
                // Initialize available stock
                $availableStock = $item->products->stocks->sum('quantty');

                // If the product has both grades and sizes, calculate stock based on both
                if ($item->grades && $item->sizes) {
                    $availableStock = $item->products->stocks
                        ->where('grades_id', $item->grades->id)
                        ->where('sizes_id', $item->sizes->id)
                        ->sum('quantty');
                }
                // If the product has only grades, calculate stock based on grades
                elseif ($item->grades) {
                    $availableStock = $item->products->stocks->where('grades_id', $item->grades->id)->sum('quantty');
                }
                // If the product has only sizes, calculate stock based on sizes
                elseif ($item->sizes) {
                    $availableStock = $item->products->stocks->where('sizes_id', $item->sizes->id)->sum('quantty');
                }

                // Add availableStock as a property to the item
                $item->availableStock = $availableStock;

                return $item;
            });

        // Check product availability and quantities for each product
        $insufficientItems = [];
        foreach ($ordersitem as $item) {
            // Check if the available stock is insufficient
            if ((float) $item->availableStock < (float) $item->quantty) { // Cast both values to float for decimal comparison
                $insufficientItems[] = [
                    'id' => $item->id,
                    'product_name' => $item->products->name,
                    'required_quantity' => $item->quantty,
                    'available_stock' => $item->availableStock,
                    'color' => $item->grades->name ?? 'N/A',
                    'size' => $item->sizes->name ?? 'N/A',
                ];
            }
        }

        // Pass data to the view
        return view('dashbord.order.orderitems')
            ->with('ordersitem', $ordersitem)
            ->with('order', $order)
            ->with('insufficientItems', $insufficientItems)
            ->with('canProceed', empty($insufficientItems));
    }

    public function allindex()
    {

        return view('dashbord.order.allndex');
    }

     public function ordersall()
    {
        $Order = Order::with(['orderstatues'])->orderBy('created_at', 'DESC')
          ;
        return datatables()->of($Order)
            ->addColumn('orderinfo', function ($Order) {
                $Orderid = encrypt($Order->id);

                return '<a  href="' . route('orderitem', $Orderid) . '"><img style="max-width: 50%;" src="' . asset('orderinfo.png') . '"></a>';
            })
            ->addColumn('preparation', function ($Order) {
                $Orderid = encrypt($Order->id);
                return '<a href="javascript:void(0)" onclick="Swal.fire({
                    title: \'تآكيد وضع الطلبية قيد التنفيذ\',
                    text: \'هل تريد وضع عدا الطلبيه قيد التنفيد؟\',
                    icon: \'warning\',
                    showCancelButton: true,
                    confirmButtonText: \'نعم\',
                    cancelButtonText: \'لا\'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href=\'' . route('pending/preparationfuction', $Orderid) . '\';
                    }
                })">
                <img style=\'max-width: 50%;\' src=\'' . asset('preparation.png') . '\'>
                </a>';
            })
          
            ->rawColumns(['orderinfo', 'preparation'])
            ->make(true);
    }
    public function pedningindex()
    {

        return view('dashbord.order.pendingndex');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function orderspenidng()
    {
        $Order = Order::with(['orderstatues'])->orderBy('created_at', 'DESC')
            ->where('order_statues_id', 1);
        return datatables()->of($Order)
            ->addColumn('orderinfo', function ($Order) {
                $Orderid = encrypt($Order->id);

                return '<a  href="' . route('orderitem', $Orderid) . '"><img style="max-width: 50%;" src="' . asset('orderinfo.png') . '"></a>';
            })
            ->addColumn('preparation', function ($Order) {
                $Orderid = encrypt($Order->id);
                return '<a href="javascript:void(0)" onclick="Swal.fire({
                    title: \'تآكيد وضع الطلبية قيد التنفيذ\',
                    text: \'هل تريد وضع عدا الطلبيه قيد التنفيد؟\',
                    icon: \'warning\',
                    showCancelButton: true,
                    confirmButtonText: \'نعم\',
                    cancelButtonText: \'لا\'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href=\'' . route('pending/preparationfuction', $Orderid) . '\';
                    }
                })">
                <img style=\'max-width: 50%;\' src=\'' . asset('preparation.png') . '\'>
                </a>';
            })
            ->addColumn('cancelorder', function ($Order) {
                $Orderid = encrypt($Order->id);
                return '<form action="' . route('pending/cancelfunction', $Orderid) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            <button style="border: none; background: url(\'' . asset('cancel-order.png') . '\') no-repeat center center; background-size: contain; width: 50px; height: 50px;" type="submit" class="btn btn-link p-0" onclick="return Swal.fire({
                                title: \'تآكيد الغاء الطلبية\',
                                text: \'هل تريد الغاء الطلبية؟\',
                                icon: \'warning\',
                                showCancelButton: true,
                                confirmButtonText: \'نعم\',
                                cancelButtonText: \'لا\'
                            }).then((result) => result.isConfirmed);">
                            </button>
                        </form>';
            })
            ->rawColumns(['orderinfo', 'preparation', 'cancelorder'])
            ->make(true);
    }

    public function preparationfuction(Request $request, $id)
    {
        $Orderr_id = decrypt($id);
        $Order = Order::find($Orderr_id);

        try {
            DB::transaction(function () use ($request, $id) {
                $Orderr_id = decrypt($id);
                $Order = Order::find($Orderr_id);

                $Order->order_statues_id = 2;
                $Order->save();
            });
            Alert::success("تم وضع الطلبية قيد التجهيز");

            return redirect('underprocess/oreder');
        } catch (\Exception $e) {

            Alert::warning($e->getMessage());

            return redirect()->back();
        }
    }

    public function cacnelfuction(Request $request, $id)
    {
        $Orderr_id = decrypt($id);
        $Order = Order::find($Orderr_id);

        try {
            DB::transaction(function () use ($request, $id) {
                $Orderr_id = decrypt($id);
                $Order = Order::find($Orderr_id);

                $Order->order_statues_id = 4;
                $Order->save();
            });
            Alert::success("تم الغاء الطلبية");

            return redirect('cancel/oreder');
        } catch (\Exception $e) {

            Alert::warning($e->getMessage());

            return redirect()->back();
        }
    }

    public function completelindex()
    {
        return view('dashbord.order.completendex');
    }

    public function orderscompletel()
    {
        $Order = Order::with(['orderstatues'])->orderBy('created_at', 'DESC')
            ->where('order_statues_id', 3);
        return datatables()->of($Order)
            ->addColumn('orderinfo', function ($Order) {
                $Orderid = encrypt($Order->id);

                return '<a  href="' . route('orderitem', $Orderid) . '"><img style="max-width: 50%;" src="' . asset('orderinfo.png') . '"></a>';
            })
            ->rawColumns(['orderinfo',])
            ->make(true);
    }
    public function cancelindex()
    {
        return view('dashbord.order.cancelindex');
    }
    /**
     * Store a newly created resource in storage.
     */

    public function orderscancel()
    {
        $Order = Order::with(['orderstatues'])->orderBy('created_at', 'DESC')
            ->where('order_statues_id', 4);
        return datatables()->of($Order)
            ->addColumn('orderinfo', function ($Order) {
                $Orderid = encrypt($Order->id);

                return '<a  href="' . route('orderitem', $Orderid) . '"><img style="max-width: 50%;" src="' . asset('orderinfo.png') . '"></a>';
            })
            ->rawColumns(['orderinfo',])
            ->make(true);
    }

    public function underptocessindex()
    {
        return view('dashbord.order.underptocessindex');
    }

    public function underptocessindexs()
    {
        $Order = Order::with(['orderstatues'])->orderBy('created_at', 'DESC')
            ->where('order_statues_id', 2);
        return datatables()->of($Order)
            ->addColumn('orderinfo', function ($Order) {
                $Orderid = encrypt($Order->id);

                return '<a  href="' . route('orderitem', $Orderid) . '"><img style="max-width: 50%;" src="' . asset('orderinfo.png') . '"></a>';
            })
            ->addColumn('preparation', function ($Order) {
                $Orderid = encrypt($Order->id);
                return '<a href="javascript:void(0)" onclick="Swal.fire({
                    title: \'تآكيد وضع الطلبية قيد التنفيذ\',
                    text: \'هل تريد وضع عدا الطلبيه قيد التنفيد؟\',
                    icon: \'warning\',
                    showCancelButton: true,
                    confirmButtonText: \'نعم\',
                    cancelButtonText: \'لا\'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href=\'' . route('pending/preparationfuction', $Orderid) . '\';
                    }
                })">
                <img style=\'max-width: 50%;\' src=\'' . asset('preparation.png') . '\'>
                </a>';
            })
            ->addColumn('cancelorder', function ($Order) {
                $Orderid = encrypt($Order->id);
                return '<form action="' . route('pending/cancelfunction', $Orderid) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            <button style="border: none; background: url(\'' . asset('cancel-order.png') . '\') no-repeat center center; background-size: contain; width: 50px; height: 50px;" type="submit" class="btn btn-link p-0" onclick="return Swal.fire({
                                title: \'تآكيد الغاء الطلبية\',
                                text: \'هل تريد الغاء الطلبية؟\',
                                icon: \'warning\',
                                showCancelButton: true,
                                confirmButtonText: \'نعم\',
                                cancelButtonText: \'لا\'
                            }).then((result) => result.isConfirmed);">
                            </button>
                        </form>';
            })
            ->rawColumns(['orderinfo', 'preparation', 'cancelorder'])
            ->make(true);
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
    public function update(Request $request, $id)
    {
        $orderId = decrypt($id);
        $quantities = $request->input('quantities');

        // Logic to update the order items based on the provided quantities
        foreach ($quantities as $itemId => $quantity) {
            $orderItem = Orderitems::find($itemId);
            if ($orderItem) {
                $orderItem->quantty = $quantity;
                $orderItem->save();
            }
        }

        // Add success alert
        Alert::success('تم التحديث', 'تم تحديث الطلبية بنجاح');

        return redirect()->back()->with('success', 'تم تحديث الطلبية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * Remove an item from an order.
     */
    public function removeItem(Request $request, $id)
    {
        $orderItemId = decrypt($id);
        $orderItem = Orderitems::find($orderItemId);

        if ($orderItem) {
            try {
                DB::transaction(function () use ($orderItem) {
                    $orderItem->delete(); // Remove the item from the order
                });

                Alert::success('تم الإزالة', 'تم إزالة العنصر من الطلبية بنجاح');
            } catch (\Exception $e) {
                Alert::error('خطأ', 'حدث خطأ أثناء إزالة العنصر');
            }
        } else {
            Alert::warning('غير موجود', 'العنصر المطلوب غير موجود');
        }

        return redirect()->back();
    }


    public function removeItemFromOrder(Request $request, $id)
    {
        $orderItemId = decrypt($id);

        $orderItem = Orderitems::find($orderItemId);

        if (!$orderItem) {
            return response()->json(['message' => 'العنصر غير موجود'], 404);
        }

        $orderItem->delete();

        return response()->json(['message' => 'تمت إزالة العنصر بنجاح'], 200);
    }
    /**
     * 
     * Display the order success page.
     */

    public function markAsComplete(Request $request, $id)
    {
        $orderId = decrypt($id);

        $order = Order::with('orderitems')->find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'الطلبية غير موجودة.');
        }

        try {
            DB::transaction(function () use ($order) {
                // Create a new exchange record
                $exchange = new exchange();
                $exchange->total_price = $order->total_price;
                $exchange->users_id = auth()->id();
                $exchange->full_name = $order->full_name;
                $exchange->phonenumber = $order->phonenumber;
                $exchange->exchangestypes_id = 2; // Online type
                $exchange->created_at = now();
                $exchange->save();

                // Create exchange items for each order item
                foreach ($order->orderitems as $item) {
                    $exchangeItem = new exchangeitem();
                    $exchangeItem->exchanges_id = $exchange->id;
                    $exchangeItem->products_id = $item->products_id;
                    $exchangeItem->grades_id = $item->grades_id;
                    $exchangeItem->sizes_id = $item->sizes_id;
                    $exchangeItem->price = $item->price;
                    $exchangeItem->quantty = $item->quantty;
                    $exchangeItem->users_id = auth()->id();
                    $exchangeItem->save();
                }

                // Update the order status to "completed"
                $order->order_statues_id = 3; // Assuming 3 is the status ID for "completed"
                $order->save();
            });
            Alert::success('تم التحديث', 'تم جعل الطلبية مكتملة بنجاح');

            return redirect()->back()->with('success', 'تم جعل الطلبية مكتملة بنجاح.');
        } catch (\Exception $e) {

            Alert::error('حدث خطأ أثناء معالجة الطلبية' . $e->getMessage());

            return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة الطلبية: ' . $e->getMessage());
        }
    }
}
