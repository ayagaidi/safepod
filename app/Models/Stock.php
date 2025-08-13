<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [

        'sizes_id',
        'products_id',
        'grades_id',
        'quantty',

    ];



    public function grades()
    {
        return $this->belongsTo(Grade::class);
    }
    public function sizes()
    {
        return $this->belongsTo(Size::class);
    }

    public function products()
    {
        return $this->belongsTo(products::class)->orderBy('created_at', 'desc');
    }
}
