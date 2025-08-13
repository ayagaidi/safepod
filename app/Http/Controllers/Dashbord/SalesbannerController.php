<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Salesbanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;

class SalesbannerController extends Controller
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


        return view('dashbord.salesbanners.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {




        return view('dashbord.salesbanners.create');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'imge' => 'required|image|mimes:jpeg,png,jpg,gif',

            // 'imge' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:width=780,height=654',
            'tilte' => 'required|string|max:255',
            'tilten' => 'required|string|max:255',
            'value' => 'required|numeric|min:1|max:100',
        ], [
            'tilte.required' => "قم بادخال العنوان بالعربي",
            'value.required' => "قم بادخال قيمة التخفيض",
            'tilten.required' => "قم بادخال العنوان بالانجليزي",
            'imge.required' => 'يجب اختيار صورة.',
            'imge.image' => 'الملف يجب أن يكون صورة.',
            'imge.mimes' => 'الصور المسموح بها هي JPEG، PNG، JPG، GIF.',
            'imge.dimensions' => 'يجب أن تكون أبعاد الصورة 780X654 بكسل.',
            'imge.max' => 'حجم الصورة يجب ألا يتجاوز 2MB.',
        ]);

        // التحقق مما إذا كان هناك إعلان تخفيض بالفعل
        if (Salesbanner::count() > 0) {
            Alert::warning('لا يمكنك إضافة أكثر من إعلان تخفيض واحد.');
            return redirect()->back();
        }

        try {
            DB::transaction(function () use ($request) {
                $Salesbanner = new Salesbanner();
                $Salesbanner->tilte = $request->tilte;
                $Salesbanner->value = $request->value;
                $Salesbanner->tilten = $request->tilten;

                if ($request->file('imge')) {
                    $fileObject = $request->file('imge');
                    $image = "Salesbanner" . time() . ".jpg";

                    // Resize the image to 780x654 before saving using PHP's GD library
                    $sourcePath = $fileObject->getRealPath();
                    $destinationPath = public_path('images/Salesbanner/' . $image);

                    list($originalWidth, $originalHeight, $imageType) = getimagesize($sourcePath);
                    $newWidth = 780;
                    $newHeight = 654;

                    // Create the source image based on the file type
                    switch ($imageType) {
                        case IMAGETYPE_JPEG:
                            $sourceImage = imagecreatefromjpeg($sourcePath);
                            break;
                        case IMAGETYPE_PNG:
                            $sourceImage = imagecreatefrompng($sourcePath);
                            break;
                        case IMAGETYPE_GIF:
                            $sourceImage = imagecreatefromgif($sourcePath);
                            break;
                        default:
                            throw new \Exception('Unsupported image type.');
                    }

                    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

                    // Preserve transparency for PNG and GIF
                    if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
                        imagealphablending($resizedImage, false);
                        imagesavealpha($resizedImage, true);
                        $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                        imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
                    }

                    imagecopyresampled(
                        $resizedImage,
                        $sourceImage,
                        0,
                        0,
                        0,
                        0,
                        $newWidth,
                        $newHeight,
                        $originalWidth,
                        $originalHeight
                    );

                    // Save the resized image as a JPEG file
                    imagejpeg($resizedImage, $destinationPath, 90);

                    // Free up memory
                    imagedestroy($sourceImage);
                    imagedestroy($resizedImage);

                    $Salesbanner->imge = $image;
                }

                $Salesbanner->save();
            });

            Alert::success('تم إضافة اعلان التخفيض بنجاح');
            return redirect()->route('salesbanners'); // إعادة التوجيه إلى صفحة السلايدر
        } catch (\Exception $e) {
            Alert::warning('حدث خطأ أثناء إضافة اعلان التخفيض: ' . $e->getMessage());
            return redirect()->back();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Salesbanner $salesbanner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salesbanner $salesbanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function salesbanners()
    {

        $salesbanners = Salesbanner::all();
        return datatables()->of($salesbanners)

            ->addColumn('delete', function ($product) {
                $product_id = encrypt($product->id);
                return '
                <button class="btn btn-danger btn-sm delete-button" data-id="' . $product_id . '">
                    حذف
                </button>';
            })


            ->addColumn('imge', function ($Slider) {
                $imageUrl = asset('images/Salesbanner/' . $Slider->imge);
                return '<a href="' . $imageUrl . '" target="_blank"><img src="' . $imageUrl . '" alt="' . $Slider->imge . '" style="max-width: 100px !important;"></a>';
            })


            ->rawColumns(['delete', 'imge'])


            ->make(true);
    }
    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     try {
    //         // Decrypt the product ID
    //         $Salesbanner_id = decrypt($id);

    //         // Find the product in the database
    //         $Salesbanner = Salesbanner::findOrFail($Salesbanner_id);

    //         // Check if the product has an image, and delete it from the server
    //         if ($Salesbanner_id->imge && file_exists(public_path('images/Salesbanner/' . $Salesbanner_id->imge))) {
    //             unlink(public_path('images/Salesbanner/' . $Salesbanner_id->imge));
    //         }

    //         // Delete the product record
    //         $Salesbanner_id->delete();

    //         // Success alert
    //         Alert::success("تم حذف علان التخفيض  بنجاح");

    //         // Redirect to the products listing page
    //         return redirect()->route('salesbanners');
    //     } catch (\Exception $e) {
    //         // Error handling
    //         Alert::warning("حدث خطأ أثناء حذف علان التخفيض ", $e->getMessage());
    //         return redirect()->route('salesbanners');
    //     }
    // }

    public function destroy($id)
    {
        $id = decrypt($id); // تأكد من فك التشفير إذا كنت مشفر الـ ID
        $banner = SalesBanner::findOrFail($id);
        $banner->delete();

        return response()->json(['success' => true]);
    }
}
