<?php

namespace App\Http\Controllers;

use App\Models\Aboutus;
use App\Models\Categories;
use App\Models\Contactus;
use App\Models\Discount;
use App\Models\Grade;
use App\Models\Inbox;
use App\Models\Policy;
use App\Models\products;
use App\Models\Salesbanner;
use App\Models\Size;
use App\Models\Slider;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $about = Aboutus::find(1);
        $slider = Slider::get();
        $salesbanner = Salesbanner::first();
     
        $categoriess = categories::take(4)->get();
        $productscategories = Stock::with('products')->get();
        $discount = Discount::all(); // updated to fetch all records
        $sizes = Size::all();         // updated to fetch all records
        $grades = Grade::all();       // updated to fetch all records
        $colors = DB::table('stocks')
        ->join('grades', 'stocks.grades_id', '=', 'grades.id')
        ->select('grades.id', 'grades.name')
        ->distinct()
        ->paginate(12)
        ->appends(request()->all());
        return view('front.index')
        ->with('discount', $discount)
        ->with('sizes', $sizes)
        ->with('grades', $grades)
        ->with('colors', $colors)

            ->with('salesbanner', $salesbanner)
            ->with('productscategories', $productscategories)

            ->with('categoriess', $categoriess)

            ->with('slider', $slider)
            ->with('about', $about);
    }


    public function discountprod(Request $request)
    {
        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
            $products = products::with('categories')
                ->where('is_available', 1)
                ->where('categories_id', $categoryId)
                ->whereHas('discounts')
                ->latest()
                ->paginate(12)
                ->appends($request->all());
        } elseif ($request->has('size_id')) {
            $sizeId = $request->input('size_id');
            $stocks = Stock::with('products', 'products.categories')
                ->where('sizes_id', $sizeId)
                ->whereHas('products', function ($query) {
                    $query->where('is_available', 1)
                          ->whereHas('discounts');
                })
                ->paginate(12);
            $stocks->setCollection(
                $stocks->getCollection()->map(function ($stock) {
                    return $stock->products; // Extract the product for consistency
                })
            );
            $stocks->appends($request->all());
            $products = $stocks;
        } elseif ($request->has('grades_id')) {
            $gradeId = $request->input('grades_id');
            $stocks = Stock::with('products', 'products.categories')
                ->where('grades_id', $gradeId)
                ->whereHas('products', function ($query) {
                    $query->where('is_available', 1)
                          ->whereHas('discounts');
                })
                ->paginate(12);
            $stocks->setCollection(
                $stocks->getCollection()->map(function ($stock) {
                    return $stock->products; // Extract the product for consistency
                })
            );
            $stocks->appends($request->all());
            $products = $stocks;
        } elseif ($request->has('brand')) {
            $brandName = $request->input('brand');
            $products = products::with('categories')
                ->where('is_available', 1)
                ->where('brandname', $brandName)
                ->whereHas('discounts')
                ->latest()
                ->paginate(12)
                ->appends($request->all());
        } elseif ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'priceHighToLow') {
                $products = products::with('categories')
                    ->where('is_available', 1)
                    ->whereHas('discounts')
                    ->orderBy('price', 'desc')
                    ->paginate(12)
                    ->appends($request->all());
            } elseif ($sort === 'priceLowToHigh') {
                $products = products::with('categories')
                    ->where('is_available', 1)
                    ->whereHas('discounts')
                    ->orderBy('price', 'asc')
                    ->paginate(12)
                    ->appends($request->all());
            } else {
                $products = products::with('categories')
                    ->where('is_available', 1)
                    ->whereHas('discounts')
                    ->latest()
                    ->paginate(12)
                    ->appends($request->all());
            }
        } else {
            $products = products::with('categories')
                ->where('is_available', 1)
                ->whereHas('discounts')
                ->latest()
                ->paginate(12)
                ->appends($request->all());
        }

        $minProductPrice = DB::table('stocks')
            ->join('products', 'stocks.products_id', '=', 'products.id')
            ->min('products.price');
        $maxProductPrice = DB::table('stocks')
            ->join('products', 'stocks.products_id', '=', 'products.id')
            ->max('products.price');

        $sizes = DB::table('stocks')
            ->join('sizes', 'stocks.sizes_id', '=', 'sizes.id')
            ->select('sizes.id', 'sizes.name')
            ->distinct()
            ->paginate(12)
            ->appends($request->all());

        $colors = DB::table('stocks')
            ->join('grades', 'stocks.grades_id', '=', 'grades.id')
            ->select('grades.id', 'grades.name')
            ->distinct()
            ->get();


        $categories = Categories::where('active', 1)
            ->withCount(['products' => function ($query) {
                $query->where('is_available', 1)
                      ->whereHas('discounts');
            }])
            ->get();
           

        $categoriesproducts = products::where('is_available', 1)
            ->whereHas('discounts')
            ->count();

        $brands = DB::table('products')
            ->select('products.brandname')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('discounts')
                      ->whereRaw('discounts.products_id = products.id');
            })
            ->groupBy('products.brandname')
            ->get();

        $discount = Discount::all(); // updated to fetch all records
        $sizes = Size::all();         // updated to fetch all records
        $grades = Grade::all();       // updated to fetch all records

        return view('front.discountprod')
            ->with('products', $products)
            ->with('discount', $discount)
            ->with('sizes', $sizes)
            ->with('grades', $grades)
            ->with('minProductPrice', $minProductPrice)
            ->with('maxProductPrice', $maxProductPrice)
            ->with('sizes', $sizes)
            ->with('colors', $colors)
            ->with('categories', $categories)
            ->with('brands', $brands)
            ->with('categoriesproducts', $categoriesproducts);
    }


    public function productcategory($id)
    {
        $categoryId = decrypt($id); // Decrypt the category ID
    
        $categoriess=Categories::find($categoryId);
      
        $products = products::with('categories')
            ->where('is_available', 1)
            ->where('categories_id', $categoryId)
            ->latest()
            ->paginate(12)
            ->appends(request()->all());
    
        $minProductPrice = DB::table('stocks')
            ->join('products', 'stocks.products_id', '=', 'products.id')
            ->min('products.price');
        $maxProductPrice = DB::table('stocks')
            ->join('products', 'stocks.products_id', '=', 'products.id')
            ->max('products.price');
    
        $sizes = DB::table('stocks')
            ->join('sizes', 'stocks.sizes_id', '=', 'sizes.id')
            ->select('sizes.id', 'sizes.name')
            ->distinct()
            ->get();

    
        $colors = DB::table('stocks')
            ->join('grades', 'stocks.grades_id', '=', 'grades.id')
            ->select('grades.id', 'grades.name')
            ->distinct()
            ->get();

    
        $categories = Categories::where('active', 1)
            ->withCount(['products' => function ($query) {
                $query->where('is_available', 1);
            }])
            ->get();

    
        // Filter brands based on the selected category
        $brands = DB::table('products')
            ->where('categories_id', $categoryId)
            ->select('products.brandname')
            ->groupBy('products.brandname')
        ->get();
    
        $discount = Discount::all(); // updated to fetch all records
        $sizes = Size::all();         // updated to fetch all records
        $grades = Grade::all();       // updated to fetch all records
    
        return view('front.productcategory')
        ->with('categoriess', $categoriess)

        
            ->with('id', $id)
            ->with('products', $products)
            ->with('discount', $discount)
            ->with('sizes', $sizes)
            ->with('grades', $grades)
            ->with('minProductPrice', $minProductPrice)
            ->with('maxProductPrice', $maxProductPrice)
            ->with('colors', $colors)
            ->with('categories', $categories)
            ->with('brands', $brands);
    }



    
    public function products(Request $request)
    {
      if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
            $products = products::with('categories')
                ->where('is_available', 1)
                ->where('categories_id', $categoryId)
                ->latest()
                ->paginate(12)
                ->appends($request->all());
        } elseif ($request->has('size_id')) {
            $sizeId = $request->input('size_id');
            $stocks = Stock::with('products', 'products.categories')
                ->where('sizes_id', $sizeId)
                ->whereHas('products', function ($query) {
                    $query->where('is_available', 1);
                })
                ->paginate(12);
            $stocks->setCollection(
                $stocks->getCollection()->map(function ($stock) {
                    return $stock->products; // Extract the product for consistency
                })
            );
            $stocks->appends($request->all());
            $products = $stocks;
        } elseif ($request->has('grades_id')) {
            $gradeId = $request->input('grades_id');
            $stocks = Stock::with('products', 'products.categories')
                ->where('grades_id', $gradeId)
                ->whereHas('products', function ($query) {
                    $query->where('is_available', 1);
                })
                ->paginate(12);
            $stocks->setCollection(
                $stocks->getCollection()->map(function ($stock) {
                    return $stock->products; // Extract the product for consistency
                })
            );
            $stocks->appends($request->all());
            $products = $stocks;
        } elseif ($request->has('brand')) {
            $brandName = $request->input('brand');
            $products = products::with('categories')
                ->where('is_available', 1)
                ->where('brandname', $brandName)
                ->latest()
                ->paginate(12)
                ->appends($request->all());
        } elseif ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'priceHighToLow') {
                $products = products::with('categories')
                    ->where('is_available', 1)
                    ->orderBy('price', 'desc')
                    ->paginate(12)
                    ->appends($request->all());
            } elseif ($sort === 'priceLowToHigh') {
                $products = products::with('categories')
                    ->where('is_available', 1)
                    ->orderBy('price', 'asc')
                    ->paginate(12)
                    ->appends($request->all());
            } else {
                $products = products::with('categories')
                    ->where('is_available', 1)
                    ->latest()
                    ->paginate(12)
                    ->appends($request->all());
            }
        } else {
            $products = products::with('categories')
                ->where('is_available', 1)
                ->latest()
                ->paginate(12)
                ->appends($request->all());
        }

        $minProductPrice = DB::table('stocks')
            ->join('products', 'stocks.products_id', '=', 'products.id')
            ->min('products.price');
        $maxProductPrice = DB::table('stocks')
            ->join('products', 'stocks.products_id', '=', 'products.id')
            ->max('products.price');

        $sizes = DB::table('stocks')
            ->join('sizes', 'stocks.sizes_id', '=', 'sizes.id')
            ->select('sizes.id', 'sizes.name')
            ->distinct()
            ->get();


        $colors = DB::table('stocks')
            ->join('grades', 'stocks.grades_id', '=', 'grades.id')
            ->select('grades.id', 'grades.name')
            ->distinct()
            ->get();


        $categories = Categories::where('active', 1)
            ->withCount(['products' => function ($query) {
                $query->where('is_available', 1);
            }])
            ->get();


        $categoriesproducts = products::where('is_available', 1)->count();

        $brands = DB::table('products')
           
            ->select('products.brandname')
            ->groupBy('products.brandname')
            ->get();


        $discount = Discount::all(); // updated to fetch all records
        $sizes = Size::all();         // updated to fetch all records
        $grades = Grade::all();       // updated to fetch all records

        return view('front.products')
            ->with('products', $products)
            ->with('discount', $discount)
            ->with('sizes', $sizes)
            ->with('grades', $grades)
            ->with('minProductPrice', $minProductPrice)
            ->with('maxProductPrice', $maxProductPrice)
            ->with('sizes', $sizes)
            ->with('colors', $colors)
            ->with('categories', $categories)
            ->with('brands', $brands)
            ->with('categoriesproducts', $categoriesproducts);
    }

    public function proudactinfo($id)
    {
        $productId = decrypt($id);

        $product = products::with(['categories', 'discounts', 'stocks.sizes', 'stocks.grades'])
            ->find($productId);

        $images = DB::table('imagesfiles')
            ->where('products_id', $productId)
            ->paginate(12)
            ->appends(request()->all());

        $discount = $product->discounts->first();
        $discountedPrice = $discount
            ? $product->price - ($product->price * $discount->percentage) / 100
            : null;


            $products = products::with('categories')->where('id','!=',$product->id)->where('categories_id',$product->categories_id)->where('is_available', 1)->latest()->paginate(12)->appends(request()->all());

            $discount = Discount::all(); // updated to fetch all records
            $sizes = Size::all();         // updated to fetch all records
            $grades = Grade::all();       // updated to fetch all records
            $colors = DB::table('stocks')
            ->join('grades', 'stocks.grades_id', '=', 'grades.id')
            ->select('grades.id', 'grades.name')
            ->distinct()
            ->paginate(12)
            ->appends(request()->all());
        return view('front.product')
        ->with('products', $products)
        ->with('colors', $colors)

        ->with('discount', $discount)
        ->with('sizes', $sizes)
        ->with('grades', $grades)

            ->with('product', $product)
            ->with('imagesfiles', $images)
            ->with('discountedPrice', $discountedPrice);
    }


    
     public function policies()
    {
        $policies = Policy::first();
        return view('front.policies')
            ->with('policies', $policies);
    }
    
    public function about()
    {
        $aboutus = Aboutus::paginate(12)->appends(request()->all());
        return view('front.about')
            ->with('aboutus', $aboutus);
    }


    public function contacts()
    {
        // Use first() to get a single record instead of paginate()
        $contact = Contactus::first();
        // Get map location from the database columns "lan" and "long"
        $mapLocation = [
            'lat' => $contact->lan,
            'lng' => $contact->long
        ];
        return view('front.contact')
            ->with('contact', $contact)
            ->with('mapLocation', $mapLocation); // new variable for map
    }

    public function categories()
    {
        $categories = Categories::where('active', 1)->paginate(12)->appends(request()->all());
        return view('front.categories')
            ->with('categories', $categories);
    }


    public function send(Request $request)
    {
        // Custom validation messages
        $messages = [
            'name.required' => __('validation.name_required'),
            'message.required' => __('validation.message_required'),
            'subject.required' => __('validation.subject_required'),
            'email.required' => __('validation.email_required'),
            'email.email' => __('validation.email_invalid'),
            'email.dns' => __('validation.email_dns_invalid'),
        ];

        // Validation rules
        $this->validate($request, [
            'name' => 'required',
            'message' => 'required',
            'subject' => 'required',
            'email' => 'required|email:rfc,dns',
        ], $messages);

        try {
            // Database transaction
            DB::transaction(function () use ($request) {
                $Inbox = new Inbox();
                $Inbox->name = $request->name;
                $Inbox->message = $request->message;
                $Inbox->subject = $request->subject;
                $Inbox->email = $request->email;
                $Inbox->save();
            });

            Alert::success(__('messages.success_message'));
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::warning(__('messages.failure_message', ['error' => $e->getMessage()]));
            return redirect()->back();
        }
    }


    public function menu()
    {

        $Categories = Categories::where('active', 1)->paginate(12)->appends(request()->all());
        return view('menu')->with('Categories', $Categories);
    }

    public function menuinfo($id)
    {

        $cat = decrypt($id);

        $Categories = Categories::find($cat);
        $products = products::where('categories_id', $cat)->paginate(12)->appends(request()->all());
        return view('menuinfo')
            ->with('products', $products)
            ->with('Categories', $Categories)
        ;
    }
}
