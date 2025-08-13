<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exchangeitem extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'sizes_id',
        'products_id',
        'grades_id',
        'price',
        'quantty',
        'users_id',
        'exchanges_id',

    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function exchanges()
    {
        return $this->belongsTo(exchange::class);
    }
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
        return $this->belongsTo(products::class);
    }
}
