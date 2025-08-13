<?php


namespace App\Http\Controllers\Dashbord;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
class CityController extends Controller
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

        return view('dashbord.city.index');
    }


    public function cities()
    {
    
        $City = City::orderBy('created_at', 'DESC');
        return datatables()->of($City)
        ->addColumn('edit', function ($City) {
            $city_id = encrypt($City->id);
        
            return '<a style="color: #f97424;" href="' . route('cities/edit',$city_id).'">            <img src="' . asset('edit.png') . '" alt="Edit" style="width:26px; height:26px;"></a>';
        })

        ->addColumn('delete', function ($City) {
            $city_id = encrypt($City->id);
          

            return ' <form action="' . route('cities/delete', $city_id) . '" method="POST">
        <input type="hidden" name="_method" value="DELETE">'
                . csrf_field() .
                '<button type="submit" style="background: none;border: none;"><i class="fa fa-trash" style="color:red"></i></button></form>';
         
        })
    
        ->rawColumns(['edit','delete'])


            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       


        return view('dashbord.city.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => trans('city.valirequiredcity'),

        ];
        $this->validate($request, [
            'name' => ['required', 'string', 'max:50','unique:cities'],

        ], $messages);
        try {
            DB::transaction(function () use ($request) {

                $city = new City();
                $city->name = $request->name;

                $city->save();
            });
            Alert::success(trans('city.successcityadd'));

            return redirect()->route('cities');
        } catch (\Exception $e) {

            Alert::warning($e->getMessage());

            return redirect()->route('cities');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit( $city)
    { 

            $city_id = decrypt($city);
            $city = City::find($city_id);
            return view('dashbord.city.edit')->with('city', $city);
       

   
     
    }
    public function delete($id)
    {
        $id = decrypt($id);
        $City = City::find($id);
        $City->delete();
        Alert::success('تمت عملية حذف  مدينة   بنجاح');
        return redirect()->back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
  
    public function update(Request $request, $city)
    {

        $city_id = decrypt($city);
      
        $messages = [
            'name.required' => trans('city.valirequiredcity'),

        ];
        $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],

        ], $messages);
        try {
            DB::transaction(function () use ($request, $city) {
                $city_id = decrypt($city);

                $cit = City::find($city_id);
                $cit->name = $request->name;

                $cit->save();
                          });

            Alert::success(trans('city.successcityedit'));

            return redirect()->route('cities');
        } catch (\Exception $e) {

            Alert::warning($e->getMessage());

            return redirect()->route('cities');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
