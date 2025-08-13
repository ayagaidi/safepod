<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Grade;
use App\Models\Imagesfile;
use App\Models\products;
use App\Models\productsfiles;
use App\Models\Size;
use App\Services\StocksServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\ImageFile;
use RealRashid\SweetAlert\Facades\Alert;

class ProductsController extends Controller
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

        return view('dashbord.products.index');
    }

    public function products()
    {
        $products = products::with('categories')->get();

        return datatables()->of($products)
            ->addColumn('changeStatus', function ($product) {
                $product_id = encrypt($product->id);
                return '<a href="' . route('products/changeStatus', $product_id) . '">
                              <img src="' . asset('refresh.png') . '" alt="Edit" style="width:26px; height:26px;">
                        </a>';
            })
            ->addColumn('edit', function ($product) {
                $product_id = encrypt($product->id);
                return '<a href="' . route('products/edit', $product_id) . '">
                              <img src="' . asset('edit.png') . '" alt="Edit" style="width:26px; height:26px;">
                        </a>';
            })
            ->addColumn('gallery', function ($product) {

                $product_id = encrypt($product->id);
                return '<a href="' . route('products/gellary', $product_id) . '">
                              <img src="' . asset('picture.png') . '" alt="gellary" style="width:26px; height:26px;">
                        </a>';
            })
            ->addColumn('delete', function ($product) {
                $product_id = encrypt($product->id);
                return '<a href="javascript:;" onclick="Swal.fire({
                    title: \'هل أنت متأكد أنك تريد حذف هذا المنتج؟\',
                    icon: \'warning\',
                    showCancelButton: true,
                    confirmButtonText: \'نعم\',
                    cancelButtonText: \'إلغاء\'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = \'' . route('products/delete', $product_id) . '\';
                    }
                })">
                    <img src="' . asset('delete.png') . '" alt="Delete" style="width:26px; height:26px;">
                </a>';
            })
            ->addColumn('image', function ($product) {
                $imageUrl = asset('images/product/' . $product->image);
                return '<a href="' . $imageUrl . '" target="_blank"><img src="' . $imageUrl . '" alt="' . $product->name . '" style="max-width: 100px !important;"></a>';
            })

            ->addColumn('grade', function ($product) {
                $grades = $product->grades;
                if ($grades->isNotEmpty()) {
                    // For each grade, show as a colored badge; assumes each grade has a 'color' property.
                    return $grades->map(function ($grade) {
                        $color = isset($grade->namee) ? $grade->namee : '#666';
                        return '<div style="background-color: ' . $color . '; color: #fff; padding: 16px; border-radius: 3px; margin-right:3px;"></div>';
                    })->implode(' ');
                } else {
                    return 'لايوجد';
                }
            })
            ->addColumn('size', function ($product) {
                // Check if size is not null and decode JSON if it exists
                // Fetch sizes related to this product using the relationship
                $sizes = $product->sizes; // Assuming the `Product` model has a `sizes` relationship method

                if ($sizes->isNotEmpty()) {
                    // If sizes exist, return them as a comma-separated string
                    return $sizes->map(function ($size) {
                        return $size->name; // Assuming the `size` model has a `name` field
                    })->implode(', ');
                } else {
                    // If no sizes are found, return 'لايوجد'
                    return 'لايوجد';
                }
            })

            ->rawColumns(['changeStatus', 'delete', 'edit', 'gallery', 'image', 'grade'])
            ->make(true);
    }


    public function gellary($id)
    {
        $products_id = decrypt($id);
        $product = products::findOrFail($products_id);
        $image = Imagesfile::where('products_id', $products_id)->get();

        // If no images, show swal alert and redirect back
        if ($image->isEmpty()) {
            Alert::warning('لايوجد صور');
            return redirect()->back();
        }

        return view('dashbord.products.gellary')
            ->with('product', $product)
            ->with('image', $image);
    }

    public function deleteImage($id)
    {
        $img_id = decrypt($id);
        $image = Imagesfile::findOrFail($img_id);
        if (file_exists(public_path('images/product/' . $image->name))) {
            unlink(public_path('images/product/' . $image->name));
        }
        $image->delete();
        return redirect()->back()->with('success', 'تم حذف الصورة بنجاح');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Categories::where('active', 1)->get();
        return view('dashbord.products.create')
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define custom validation messages
        $messages = [
            'name.required' => 'اسم المنتج مطلوب',
            'namee.required' => 'اسم المنتج (إنجليزي) مطلوب',
            'price.required' => 'السعر مطلوب',
            'categories_id.required' => 'الفئة مطلوبة',
            'image.mimes' => 'يجب أن تكون صورة الغلاف بصيغة صحيحة (jpg, jpeg, png)',
        ];

        // Validate the incoming request
        $this->validate($request, [
            'categories_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'namee' => 'required|string|max:255',
            'barcode' => 'required|string|max:255',
            'brandname' => 'required|string|max:255',


            'grade.*' => 'nullable|string|max:255',
            'size.*' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'price' => 'required|numeric',
            'images.*' => 'nullable|mimes:jpeg,png,jpg,gif',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ], $messages);

        // Use a transaction to ensure data consistency
        try {
            DB::transaction(function () use ($request) {
                // Create a new Product instance
                $product = new products();
                $product->categories_id = $request->categories_id;
                $product->name = $request->name;
                $product->namee = $request->namee;
                $product->barcode = $request->barcode;
                $product->brandname = $request->brandname;


                // Product details
                $product->notes = $request->notes;
                $product->description = $request->description;
                $product->descriptione = $request->descriptione;
                $product->description_ar = $request->description_ar;
                $product->description_en = $request->description_en;
                $product->price = $request->price;
                $product->is_available = 1; // Default to active product

                // Handle the main image upload
                if ($request->file('image')) {
                    $fileObject = $request->file('image');
                    $image = "product_" . time()  . ".jpg";
                    $fileObject->move('images/product/', $image);
                    $product->image = $image;
                }

                $product->save();

                // Insert Sizes (if provided)
                if ($request->size) {
                    foreach ($request->size as $size) {
                        if (!empty($size)) { // Check if the size is not empty
                            Size::create([
                                'name' => $size,
                                'products_id' => $product->id
                            ]);
                        } else {
                            // Handle empty size or log an error if necessary
                            // Example:
                            // Log::error("Size is missing.");
                        }
                    }
                }

                // Insert grades (if provided)
                if ($request->has('grade')) {
                    $grades = $request->grade;
                    foreach ($grades as $grade) {
                        Grade::create([
                            'name' => $grade,
                            'namee' => $grade,
                            'products_id' => $product->id,
                        ]);
                    }
                }

                // Insert Additional Images (if provided)
                if ($request->file('images')) {
                    foreach ($request->file('images') as $file) {
                        $filename = "product_img_" . time()  . ".jpg";
                        $file->move('images/product/', $filename);

                        Imagesfile::create([
                            'name' => $filename,
                            'products_id' => $product->id
                        ]);
                    }
                }

                // Add stock after product creation
                $newstoc = new StocksServices();

                // Get grade IDs and size IDs from the product or request
                $grades_id = $product->grades()->pluck('id')->toArray();  // Assuming grades relation
                $sizes_id = $product->sizes()->pluck('id')->toArray();  // Assuming sizes relation

                // Default quantity (0 if not provided)
                $quantity = $request->has('quantity') ? $request->quantity : 0;

                // If the product has sizes but no grades
                if (!empty($sizes_id) && empty($grades_id)) {
                    foreach ($sizes_id as $size_id) {
                        $stock = $newstoc->addstock($quantity, null, $size_id, $product->id);
                    }
                }

                // If product has grades but no sizes
                elseif (empty($sizes_id) && !empty($grades_id)) {
                    foreach ($grades_id as $grade_id) {
                        $stock = $newstoc->addstock($quantity, $grade_id, null, $product->id);
                    }
                }

                // If the product has neither sizes nor grades
                elseif (empty($sizes_id) && empty($grades_id)) {
                    // No sizes or grades, add stock for the product
                    $stock = $newstoc->addstock($quantity, null, null, $product->id);
                }

                // If the product has both sizes and grades
                elseif (!empty($sizes_id) && !empty($grades_id)) {
                    foreach ($grades_id as $grade_id) {
                        foreach ($sizes_id as $size_id) {
                            $stock = $newstoc->addstock($quantity, $grade_id, $size_id, $product->id);
                        }
                    }
                }
            });

            // Success alert
            Alert::success(trans('product.success_product_add'));
            return redirect()->route('products'); // Redirect to the product creation page or listing page

        } catch (\Exception $e) {
            // Error handling
            Alert::warning(trans('product.error_product_add'), $e->getMessage());
            return back()->withInput();
        }
    }









    protected function convertToString($value)
    {
        // Convert the array to a comma-separated string
        return $value ? implode(',', $value) : '';
    }


    public function changeStatus(Request $request, $id)

    {
        $products_id = decrypt($id);
        $products = products::find($products_id);

        try {
            DB::transaction(function () use ($request, $id) {
                $products_id = decrypt($id);
                $products = products::find($products_id);
                if ($products->is_available == 1) {
                    $is_available = 0;
                } else {
                    $is_available = 1;
                }

                $products->is_available = $is_available;
                $products->save();
            });
            Alert::success("تمت عملية تغيير حالة منتج");

            return redirect('products');
        } catch (\Exception $e) {

            Alert::warning($e->getMessage());

            return redirect('products');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $products_id = decrypt($id);
        $product = products::find($products_id);
        $image = Imagesfile::where('products_id', $products_id)->get();

        $categories = Categories::where('active', 1)->get();
        return view('dashbord.products.edit')
            ->with('product', $product)
            ->with('image', $image)
            ->with('categories', $categories);
    }


    public function destroy($id)
    {
        try {
            // Decrypt the product ID
            $product_id = decrypt($id);

            // Find the product in the database
            $product = products::findOrFail($product_id);

            // Check if the product has an image, and delete it from the server
            if ($product->image && file_exists(public_path('images/product/' . $product->image))) {
                unlink(public_path('images/product/' . $product->image));
            }

            // Delete the product record
            $product->delete();

            // Success alert
            Alert::success("تم حذف المنتج بنجاح");

            // Redirect to the products listing page
            return redirect()->route('products');
        } catch (\Exception $e) {
            // Error handling
            Alert::warning("حدث خطأ أثناء حذف المنتج", $e->getMessage());
            return redirect()->route('products');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // تعريف رسائل التحقق المخصصة
        $messages = [
            'name.required' => 'اسم المنتج مطلوب',
            'namee.required' => 'اسم المنتج (إنجليزي) مطلوب',
            'price.required' => 'السعر مطلوب',
            'categories_id.required' => 'الفئة مطلوبة',
            'image.mimes' => 'يجب أن تكون صورة الغلاف بصيغة صحيحة (jpg, jpeg, png)',
        ];

        // التحقق من البيانات
        $this->validate($request, [
            'categories_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'namee' => 'required|string|max:255',
            'description' => 'nullable|string',
            'descriptione' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
        ], $messages);

        // بدء عملية التحديث داخل معاملة (Transaction)
        try {
            DB::transaction(function () use ($request, $id) {
                $product_id = decrypt($id);

                $product = products::findOrFail($product_id);

                $product->categories_id = $request->categories_id;
                $product->name = $request->name;
                $product->namee = $request->namee;
                $product->description = $request->description;
                $product->descriptione = $request->descriptione;
                $product->description_ar = $request->description_ar;
                $product->description_en = $request->description_en;
                $product->price = $request->price;

                // معالجة الصورة إذا تم رفعها
                if ($request->file('image')) {
                    // حذف الصورة القديمة إذا كانت موجودة
                    if ($product->image && file_exists(public_path('images/product/' . $product->image))) {
                        unlink(public_path('images/product/' . $product->image));
                    }

                    // رفع الصورة الجديدة
                    $fileObject = $request->file('image');
                    $image = "category" . time() . ".jpg";
                    $fileObject->move('images/product/', $image);
                    $product->image = $image;
                }

                // Insert Additional Images (if provided)
                if ($request->file('images')) {
                    foreach ($request->file('images') as $file) {
                        $filename = "product_img_" . time()  . ".jpg";
                        $file->move('images/product/', $filename);

                        Imagesfile::create([
                            'name' => $filename,
                            'products_id' => $product->id
                        ]);
                    }
                }


                $product->save();
            });

            // Changed alert message to direct string
            Alert::success('تم تعديل المنتج بنجاح');
            return redirect()->route('products'); // إعادة التوجيه إلى صفحة المنتجات

        } catch (\Exception $e) {
            // معالجة الخطأ
            Alert::warning(trans('product.error_product_update'), $e->getMessage());
            return back()->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
}
