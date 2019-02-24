<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 关联UserAddress模型
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    // 与商品的关联
    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'user_favorite_products')
                ->withTimestamps()
                ->orderBy('user_favorite_products.created_at', 'desc');
    }

    // 与购物车关联
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
