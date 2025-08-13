<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Stock;

class StocksServices
{
    public function addstock($quantty, $grades_id, $sizes_id, $products_id)
    {

        $Stock = new Stock();
        $Stock->quantty = $quantty;
        $Stock->grades_id = $grades_id;
        $Stock->sizes_id = $sizes_id;
        $Stock->products_id = $products_id;


        $Stock->save();
        return $quantty;
    }


    public function updatestock($quantty, $grades_id, $sizes_id, $products_id)
    {



        if (is_null($grades_id)) { 
            $Stock = Stock::where('products_id', $products_id)
                         ->where('sizes_id', $sizes_id)
                         ->first();
        } elseif (is_null($sizes_id)) {
            $Stock = Stock::where('products_id', $products_id)
                         ->where('grades_id', $grades_id)
                         ->first();
        } elseif (is_null($sizes_id) && is_null($grades_id)) {
            $Stock = Stock::where('products_id', $products_id)
                         ->first();
        }
        elseif (is_null($grades_id)) {
            $Stock = Stock::where('products_id', $products_id)
            ->where('sizes_id', $sizes_id)

                         ->first();
        }
       

        $Stock->quantty =$Stock->quantty+ $quantty;
        $Stock->save();
        return $quantty;
    }


    public function updatestockcute($quantty, $grades_id, $sizes_id, $products_id)
    {


        if (is_null($grades_id)) { 
            $Stock = Stock::where('products_id', $products_id)
                         ->where('sizes_id', $sizes_id)
                         ->first();
        } elseif (is_null($sizes_id)) {
            $Stock = Stock::where('products_id', $products_id)
                         ->where('grades_id', $grades_id)
                         ->first();
        } elseif (is_null($sizes_id) && is_null($grades_id)) {
            $Stock = Stock::where('products_id', $products_id)
                         ->first();
        }
        elseif (is_null($grades_id)) {
            $Stock = Stock::where('products_id', $products_id)
            ->where('sizes_id', $sizes_id)

                         ->first();
        }
        $Stock->quantty =$Stock->quantty-$quantty;
        $Stock->save();
        return $quantty;
    }
  
}
