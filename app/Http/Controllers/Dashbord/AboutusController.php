<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Aboutus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class AboutusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ab = Aboutus::first();

        return view('dashbord.aboutus.index')->with('ab', $ab);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {




        return view('dashbord.aboutus.create');
    }


    public function aboutus()
    {

        $aboutus = Aboutus::all();
        return datatables()->of($aboutus)

            ->addColumn('edit', function ($aboutus) {
                $aboutus_id = encrypt($aboutus->id);

                return '<a style="color: #f97424;" href="' . route('aboutus/edit') . '">            <img src="' . asset('edit.png') . '" alt="Edit" style="width:26px; height:26px;"></a>';
            })
         

            ->addColumn('dec', function ($aboutus) {
                $dec = strip_tags($aboutus->dec);
    
                return $dec;
            })
            ->addColumn('decen', function ($aboutus) {
                $decen = strip_tags($aboutus->decen);
    
                return $decen;
            })
            // ->addColumn('imge', function ($Slider) {
            //     $imageUrl = asset('images/aboutus/' . $Slider->imge);
            //     return '<a href="' . $imageUrl . '" target="_blank"><img src="' . $imageUrl . '" alt="' . $Slider->imge . '" style="max-width: 100px !important;"></a>';
            // })

            ->rawColumns(['edit','decen','dec'])


            ->make(true);
    }



    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'dec.required' =>trans('aboutus.dec_R'),
            'decen.required' => trans('aboutus.decen_R'),
            'imge.required' => 'يجب اختيار صورة.',
            'imge.image' => 'الملف يجب أن يكون صورة.',
            'imge.mimes' => 'الصور المسموح بها هي JPEG، PNG، JPG، GIF.',
            'imge.dimensions' => 'يجب أن تكون أبعاد الصورة 780X654 بكسل.',
            'imge.max' => 'حجم الصورة يجب ألا يتجاوز 2MB.',
        ];
        $this->validate($request, [
            'dec' => ['required'],
            'decen' => ['required'],

            // 'imge' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:width=780,height=654',


        ], $messages);
        try {
            DB::transaction(function () use ($request) {

                $aboutus = new aboutus();
                $aboutus->dec = $request->dec;
                $aboutus->decen = $request->decen;
                // if ($request->file('imge')) {
                //     $fileObject = $request->file('imge');
                //     $image = "aboutus" . time() . ".jpg";
                //     $fileObject->move('images/aboutus/', $image);
                //     $aboutus->imge = $image;
                // }
                $aboutus->save();
            });
            Alert::success(trans('aboutus.sadd'));

            return redirect()->route('aboutus');
        } catch (\Exception $e) {

            Alert::warning(trans('aboutus.fail'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(aboutus $aboutus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

        $ab = Aboutus::first();

        return view('dashbord.aboutus.edit')->with('ab', $ab);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $messages = [
            'dec.required' =>trans('aboutus.dec_R'),
            'decen.required' => trans('aboutus.decen_R'),

            'imge.required' => 'يجب اختيار صورة.',
            'imge.image' => 'الملف يجب أن يكون صورة.',
            'imge.mimes' => 'الصور المسموح بها هي JPEG، PNG، JPG، GIF.',
            'imge.dimensions' => 'يجب أن تكون أبعاد الصورة 780X654 بكسل.',
            'imge.max' => 'حجم الصورة يجب ألا يتجاوز 2MB.',
        ];
        $this->validate($request, [
            'dec' => ['required'],
            'decen' => ['required'],
            // 'imge' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:width=780,height=654',

            // 'img' => ['required'],


        ], $messages);
        try {
            DB::transaction(function () use ($request) {

                $aboutus = Aboutus::first();
                $aboutus->dec = $request->dec;
                $aboutus->decen = $request->decen;
                // if ($request->file('imge')) {
                //     $fileObject = $request->file('imge');
                //     $image = "aboutus" . time() . ".jpg";
                //     $fileObject->move('images/aboutus/', $image);
                //     $aboutus->imge = $image;
                // }
      
                $aboutus->save();
            });
            Alert::success(trans('aboutus.saed'));

            return redirect()->route('aboutus');
        } catch (\Exception $e) {

            Alert::warning(trans('aboutus.faile'));

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(aboutus $aboutus)
    {
        //
    }
}
