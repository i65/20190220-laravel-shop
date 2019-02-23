<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelsProductSku extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'price',
        'stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
