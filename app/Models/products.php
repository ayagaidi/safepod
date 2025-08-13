<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function categories() {
        return $this->belongsTo(Categories::class);
    }
    public function grades()
    {
        return $this->hasMany(Grade::class, 'products_id');
    }
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function imagesfiles()
    {
        return $this->hasMany(Imagesfile::class);
    }

    /**
     * Define the relationship with the Discount model.
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class, 'products_id');
    }

    /**
     * Define the relationship with the Stock model.
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'products_id');
    }
}
