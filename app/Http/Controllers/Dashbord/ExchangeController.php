<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Contactus;
use App\Models\Discount;
use App\Models\employee;
use App\Models\exchange;
use App\Models\exchangeitem;
use App\Models\Item;
use App\Models\products;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\StocksServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use RealRashid\SweetAlert\Facades\Alert;

class ExchangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('dashbord.exchange.index');
    }



    public function stockall(Request $request)
    {

        if (!$request->barcode) {
            return response()->json(['error' => 'ادخل الباركود'], 400);
        }

        $pro = products::where('barcode', $request->barcode)->first();
    
     
        // جلب جميع الألوان المتاحة للمنتج المحدد مع المخزون
        $grades = Stock::where('stocks.products_id', $pro->id)
            ->leftJoin('grades', 'stocks.grades_id', '=', 'grades.id')
            ->select('grades.id', 'grades.name', DB::raw('SUM(stocks.quantty) as stock'))
            ->groupBy('grades.id', 'grades.name')
            ->distinct()
            ->get();

        // جلب جميع المقاساتات المتاحة للمنتج المحدد مع المخزون
        $sizes = Stock::where('stocks.products_id', $pro->id)
            ->leftJoin('sizes', 'stocks.sizes_id', '=', 'sizes.id')
            ->select('sizes.id', 'sizes.name', DB::raw('SUM(stocks.quantty) as stock'))
            ->groupBy('sizes.id', 'sizes.name')
            ->distinct()
            ->get();

        // حساب إجمالي المخزون للمنتج
        $total_stock = Stock::where('stocks.products_id', $pro->id)->sum('quantty');
        $discount = Discount::where('products_id', $pro->id)->first();

        if (!$discount) {
            $price = $pro->price; // لا يوجد تخفيض، السعر يبقى كما هو
        } else {
            $price = $pro->price - ($pro->price * ($discount->percentage / 100)); // طرح نسبة التخفيض من السعر الأصلي
        }

        return response()->json([
            'grades' => $grades->isEmpty() ? [] : $grades,
            'sizes' => $sizes->isEmpty() ? [] : $sizes,
            'items_id'=>$pro->id,
            'name'=>$pro->name,
            'price'=>$price,
            'total_stock'=>$total_stock

        ]);
       
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Items = Stock::with(['products'])
            ->whereHas('products', function ($query) {
                $query->where('is_available', 1);
            })
            ->get()
            ->groupBy('products_id') // تجميع المنتجات حسب معرفها
            ->map(function ($group) {
                $firstItem = $group->first(); // أخذ أول عنصر كمثال
                $firstItem->total_quantity = $group->sum('quantty'); // جمع الكميات لنفس المنتج
                return $firstItem;
            })
            ->values(); // إعادة الفهرسة بعد `map()`
    
        return view('dashbord.exchange.create', compact('Items'));
    }
    


    private function calculateTotal($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        return $total;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ التأكد من أن البيانات صحيحة
        $request->validate([
            'full_name' => 'required|string|max:255',
            'items' => 'required|json',
            // 'phonenumber' => 'required|string|max:255',
            'phonenumber' => 'required|digits_between:10,10|numeric|starts_with:091,092,094,021,095,093',

            
        ]);

        $items = json_decode($request->items, true);
        if (!is_array($items) || count($items) === 0) {
            return redirect()->back()->withErrors(['error' => 'يجب اختيار عناصر صحيحة']);
        }

        try {
            DB::beginTransaction();
            $totalPrice = 0;
    
            foreach ($items as $item) {


                // if (!isset($item['quantity'], $item['price']) || 
                // !is_numeric($item['quantity']) || !is_numeric($item['price']) || 
                // floatval($item['quantity']) <= 0 || floatval($item['price']) <= 0) {
                //     throw new \Exception("كمية المنتج أو السعر غير صحيحة.");
                // }
    
                $itemTotal = $item['quantity'] * $item['price'];

                $totalPrice += $itemTotal;

            }


    
            $exchange = Exchange::create([
                'total_price' => $totalPrice,
                'users_id' => auth()->id(),
                'full_name' => $request->full_name,
                'phonenumber' => $request->phonenumber,
                'exchangestypes_id'=>1
            ]);

            foreach ($items as $item) {
                // dd( $item['grade_id'] ?? null);


                if($item['grade_id']==""){
                    $null=null;
                }else{
                    $null=$item['grade_id'];
                }
                if($item['size_id']==""){
                    $nullsizes_id=null;
                }else{
                    $nullsizes_id=$item['size_id'];
                }
                ExchangeItem::create([
                    
                    'exchanges_id' => $exchange->id,
                    'products_id' => $item['item_id'],
                    'grades_id' => $null,
                    'sizes_id' => $nullsizes_id,
                    'quantty' => $item['quantity'],
                    'price' => $item['price'],
                    'users_id'=> auth()->id()
                ]);
    
                // ✅ تحديث المخزون
                $stockService = new StocksServices();
                $stockService->updatestockcute(
                    $item['quantity'],
                     $null,
                     $nullsizes_id,
                    $item['item_id']
                );
            }
    
            DB::commit();
            Alert::success('تم إضافة عملية بيع بنجاح.');
            return redirect()->route('exchange');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('حدث خطأ أثناء إضافة إذن الصرف: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    





    public function invoice($encryptedexchangeId)
    {
        // Decrypt the receipt ID
        $exchangeId = decrypt($encryptedexchangeId);

        // Log the activity

        // Fetch the receipt along with its related supplier and user data
        $exchange = exchange::with(['users'])->find($exchangeId);

        // Fetch all the items related to this receipt
        $exchangeItems = exchangeitem::with(['products','grades','sizes', 'users', 'exchanges'])->where('exchanges_id', $exchange->id)->get();
        $created_at = Carbon::parse($exchange->created_at)->format('Y-m-d H:i');

        $contactus=Contactus::first();
        // Pass the receipt and items to the view
        return view('dashbord.exchange.invoice', [

            'contactus' => $contactus,

            'exchange' => $exchange,
            'created_at' => $created_at,
            'exchangeItems' => $exchangeItems
        ]);
    }
    public function show($encryptedexchangeId)
    {
        // Decrypt the receipt ID
        $exchangeId = decrypt($encryptedexchangeId);

        // Log the activity

        // Fetch the receipt along with its related supplier and user data
        $exchange = exchange::with(['users','exchangestypes'])->find($exchangeId);

        // Fetch all the items related to this receipt
        $exchangeItems = exchangeitem::with(['products','grades','sizes', 'users', 'exchanges'])->where('exchanges_id', $exchange->id)->get();
        $created_at = Carbon::parse($exchange->created_at)->format('Y-m-d H:i');

        // Pass the receipt and items to the view
        return view('dashbord.exchange.info', [


            'exchange' => $exchange,
            'created_at' => $created_at,
            'exchangeItems' => $exchangeItems
        ]);
    }
    public function exchange()
    {

      
            $exchange = exchange::with(['users','exchangestypes'])->orderBy('created_at', 'DESC');
            return datatables()->of($exchange)
                ->addColumn('showall', function ($receipts) {
                    $receipts_id = encrypt($receipts->id);

                    return '<a href="' . route('exchange/show', $receipts_id) . '"><i  class="fa  fa-file"> </i></a>';
                })
                ->addColumn('invoice', function ($receipts) {
                    $receipts_id = encrypt($receipts->id);

                    return '<a  target="_blank" href="' . route('exchange/invoice', $receipts_id) . '"><i  class="fa  fa-file"> </i></a>';
                })
                ->rawColumns(['showall','invoice'])
                ->make(true);
        
    }
    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(exchange $exchange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, exchange $exchange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(exchange $exchange)
    {
        //
    }
}
