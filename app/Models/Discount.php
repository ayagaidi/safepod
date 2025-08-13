<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $fillable = [
        'percentage',
        'products_id',

    ];

    public function products()
    {
        return $this->belongsTo(products::class);
    }


   
}
