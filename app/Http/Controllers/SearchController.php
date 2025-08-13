<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Grade;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // added import

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q') ?? ''; // ensure q is not null
        $products = [];
        if ($q) {
            $products = DB::table('products as p')
                ->leftJoin('categories as c', 'p.categories_id', '=', 'c.id')
                ->select('p.id', 'p.image', 'p.name', 'p.namee', 'p.brandname', 'p.barcode', 'p.price', 'p.categories_id', 'p.created_at', 'c.name as category_name', 'c.englishname as category_namee')
                ->where(function($query) use ($q) {
                    $query->where('p.name', 'LIKE', '%' . $q . '%')
                          ->orWhere('p.namee', 'LIKE', '%' . $q . '%')
                          ->orWhere('p.brandname', 'LIKE', '%' . $q . '%')
                          ->orWhere('p.barcode', 'LIKE', '%' . $q . '%');
                })
                ->paginate(12)
                ->appends(['q' => $q]); // Append the query parameter for pagination
        }
        $discount = Discount::get();
        $sizes = Size::all(); // Fetch sizes
        $grades = Grade::all(); // Fetch grades
        $colors = DB::table('stocks')
            ->join('grades', 'stocks.grades_id', '=', 'grades.id')
            ->select('grades.id', 'grades.name')
            ->distinct()
            ->get();
        return view('front.search', compact('q', 'products'))
            ->with('discount', $discount)
            ->with('sizes', $sizes)
            ->with('grades', $grades)
            ->with('colors', $colors);
    }

}