<?php

namespace App\Http\Controllers\Dashbord;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Categories::orderBy('created_at', 'DESC')->paginate(10);
        return view('dashbord.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashbord.categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'englishname' => 'required|string|max:255|unique:categories',
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif',

            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:width=310,height=418',

        ], [
            'name.required' => trans('category.name_required'),
            'englishname.required' => trans('category.englishname_required'),
            'image.required' => 'يجب اختيار صورة.',
            'image.image' => 'الملف يجب أن يكون صورة.',
            'image.dimensions' => 'يجب أن تكون أبعاد الصورة 310 x418 بكسل.',

            'image.mimes' => 'الصور المسموح بها هي JPEG، PNG، JPG، GIF، SVG.',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2MB.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $category = new Categories();
                $category->name = $request->name;
                $category->englishname = $request->englishname;
                if ($request->file('image')) {
                    $fileObject = $request->file('image');
                    $image = "category" . time()  . ".jpg";
                    $fileObject->move('images/category/', $image);
                    $category->image = $image;
                }
                $category->save();
            });

            Alert::success(trans('category.add_success'));
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('categories.create');
        }
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('dashbord.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $category = Categories::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'englishname' => 'required|string|max:255|unique:categories,englishname,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',

        ]);

        try {
            DB::transaction(function () use ($request, $category) {
                $category->name = $request->name;
                $category->englishname = $request->englishname;
                // معالجة الصورة إذا تم رفعها
                if ($request->file('image')) {
                    // حذف الصورة القديمة إذا كانت موجودة
                    if ($category->image && file_exists(public_path('images/category/' . $category->image))) {
                        unlink(public_path('images/category/' . $category->image));
                    }

                    // رفع الصورة الجديدة
                    $fileObject = $request->file('image');

                    $image = "category" . time() . ".jpg";
                    $fileObject->move('images/category/', $image);
                    $category->image = $image;
                }
                $category->save();
            });

            Alert::success(trans('category.update_success'));
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('categories.edit', $id);
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $category = Categories::findOrFail($id);
            $category->delete();

            Alert::success(trans('category.delete_success'));
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('categories.index');
        }
    }


    public function changeCategoryStatus(Request $request, $id)
    {
        // Decrypt the category ID
        $category_id = decrypt($id);
        $category = Categories::find($category_id);

        if (!$category) {
            Alert::warning(trans('categories.notfound'));
            return redirect('categories');
        }

        try {
            // Use a database transaction for safety
            DB::transaction(function () use ($category) {
                // Toggle the active status
                $category->active = $category->active == 1 ? 0 : 1;
                $category->save();
            });

            // Log the activity and show a success alert
            Alert::success(trans('categories.changestatuesalert'));

            return redirect('categories');
        } catch (\Exception $e) {
            // Handle exceptions gracefully
            Alert::warning($e->getMessage());

            return redirect('categories');
        }
    }
}
