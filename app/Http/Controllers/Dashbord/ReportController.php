<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\exchange;
use App\Models\exchangeitem;
use App\Models\products;
use App\Models\Returns;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sales()
    {
        return view('dashbord.report.index');
    }

    public function searchSales(Request $request)
    {
        \Log::info('Search Sales Request:', $request->all()); // Debugging log

        // Validate that "من تاريخ" is less than "إلى تاريخ"
        if ($request->fromDate && $request->toDate && $request->fromDate > $request->toDate) {
            return response()->json([
                'error' => 'تأكد أن تاريخ البداية أقل من تاريخ النهاية'
            ], 400);
        }

        $query = exchange::query();

        if ($request->fromDate) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        }

        if ($request->toDate) {
            $query->whereDate('created_at', '<=', $request->toDate);
        }

        if ($request->operationNumber) {
            $query->where('exchangesnumber', $request->operationNumber);
        }

        if ($request->phoneNumber) {
            $query->where('phonenumber', $request->phoneNumber);
        }

        if ($request->customerName) {
            $query->where('full_name', $request->customerName);
        }
       
        // Include the customer relationship for full name and phone
        $data = $query->with(['exchangestypes'])->get();

        $data->transform(function ($receipts) {
            $receipts->showall = '<a href="' . route('exchange/show', encrypt($receipts->id)) . '"><i class="fa fa-file"> </i></a>';
            $receipts->invoice = '<a target="_blank" href="' . route('exchange/invoice', encrypt($receipts->id)) . '"><i class="fa fa-file"> </i></a>';
            return $receipts;
        });

        \Log::info('Search Sales Result:', $data->toArray()); // Debugging log

        return response()->json([
            'data' => $data
        ]);
    }


    public function return()
    {
        return view('dashbord.report.returnindex');
    }



    public function searchreturn(Request $request)
    {
        \Log::info('Search Returns Request:', $request->all()); // Debugging log

        // Validate that "من تاريخ" is less than "إلى تاريخ"
        if ($request->fromDate && $request->toDate && $request->fromDate > $request->toDate) {
            return response()->json([
                'error' => 'تأكد أن تاريخ البداية أقل من تاريخ النهاية'
            ], 400);
        }

        $query = Returns::query();

        if ($request->fromDate) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        }

        if ($request->toDate) {
            $query->whereDate('created_at', '<=', $request->toDate);
        }

        if ($request->operationNumber) {

        $query->whereHas('exchanges', function ($query) use ($request) {
            $query->where('exchangesnumber', $request->operationNumber);
        });
        }

        
        
       
        // Include the customer relationship for full name and phone
        $data = $query->with(['grades', 'users','products','sizes', 'exchanges'])->get();

       

        \Log::info('Search Returns Result:', $data->toArray()); // Debugging log

        return response()->json([
            'data' => $data
        ]);
    }
}
