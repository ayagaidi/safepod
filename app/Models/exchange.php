<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exchange extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'total_price',
        'users_id',
        'full_name',
        'phonenumber',
        'exchangestypes_id'


    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($request) {
            // الحصول على آخر رقم طلب
            $lastRequest = self::latest('id')->first();

            // تحديد الرقم الجديد
            $nextNumber = $lastRequest ? ((int) substr($lastRequest->exchangesnumber, 5)) + 1 : 1;

            // إنشاء رقم الطلب بالتنسيق المطلوب
            $request->exchangesnumber = 'REC-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        });
    }

    public function exchangestypes()
    {
        return $this->belongsTo(exchangestype::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
