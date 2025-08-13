<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\products;
use Illuminate\Http\Request;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
class DiscountController extends Controller
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

        return view('dashbord.discount.index');
    }


    public function getproudact(Request $request)
    {
        $barcode = $request->barcode;
        $pro = products::where('barcode', $barcode)->first();
    
        if (!$pro) {
            return response()->json(['error' => 'المنتج غير موجود!'], 404);
        }
   
    
        return response()->json([
           
            'products'=>$pro
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('dashbord.discount.create');
    }

    public function discount()
    {

      
            $discount = Discount::with(['products']);
            return datatables()->of($discount)
            ->addColumn('delete', function ($discount) {
                $discount_id = encrypt($discount->id);
                return '<a href="' . route('discounts/delete', $discount_id) . '" onclick="return confirm(\'هل أنت متأكد أنك تريد حذف هذا slider?\')">
                         
                                                       <img src="' . asset('delete.png  ') . '" alt="Edit" style="width:26px; height:26px;">
    
                        </a>';
            })
                ->addColumn('discountid', function ($discount) {
                return  $discount->id;
            })
          
            ->rawColumns(['delete','discountid'])

                ->make(true);
        
    }
    public function destroy($id)
{
    try {
        // $Discount_id = decrypt($id);
        // $Discount = Discount::findOrFail($id);
        $Discount = Discount::where('products_id', $id)->first();

        $Discount->delete();

        return response()->json(['success' => 'تم حذف التخفيض بنجاح']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'حدث خطأ أثناء الحذف', 'message' => $e->getMessage()], 500);
    }
}


    // public function destroy($id)
    // {
    //     try {
    //         // Decrypt the product ID
    //         $Discount_id = decrypt($id);

    //         // Find the product in the database
    //         $Discount = Discount::findOrFail($Discount_id);

          

    //         // Delete the product record
    //         $Discount->delete();

    //         // Success alert
    //         Alert::success("تم حذف التخفيض بنجاح");

    //         // Redirect to the products listing page
    //         return redirect()->route('discounts');
    //     } catch (\Exception $e) {
    //         // Error handling
    //         Alert::warning("حدث خطأ أثناء حذف التخفيض", $e->getMessage());
    //         return redirect()->route('discounts');
    //     }
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ التأكد من أن البيانات صحيحة
        $request->validate([
            'products_id' => 'required|string|max:255',
            'percentage' => 'required',

            
        ]);

      
        // التحقق مما إذا كان يوجد تخفيض للمنتج بناءً على معرف المنتج
$discount = Discount::where('products_id', $request->proudatid)->first();

if ($discount) {
    // إذا كان موجودًا، قم بتحديث البيانات
    Alert::error("هذا المنتج مخفض مسبقا");
        return redirect()->back();
} else {
    // إذا لم يكن موجودًا، قم بإنشاء تخفيض جديد
    try {
        DB::beginTransaction();
        $totalPrice = 0;




        $Discount = Discount::create([
            'percentage' => $request->percentage,
            'products_id' => $request->proudatid
           

            
        ]);

       

        DB::commit();
        Alert::success('تم إضافة تخفيض  بنجاح.');
        return redirect()->route('discounts');
    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error('حدث خطأ أثناء إضافة تخفيض: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}


       
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   
}
