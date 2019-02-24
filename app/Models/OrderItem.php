<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'amount', 
        'price',
        'rating',
        'review',
        'reviewed_at',
    ];
    protected $dates = ['reviewed_at'];
    
    // 代表这个模型没有 created_at 和 updated_at 两个时间戳字段
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
