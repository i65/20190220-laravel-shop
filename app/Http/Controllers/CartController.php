<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;

class CartController extends Controller
{
    // 添加到购物车
    public function add(AddCartRequest $request)
    {
        $user = $request->user();
        $skuId = $request->input('sku_id');
        $amount = $request->input('amount');

        // 从数据库中查询该商品是否已经在购物车中
        if ($cart = $user->cartItems()->where('product_sku_id', $skuId)->first()) {

            // 如果存在则直接叠加商品数量
            $cart->update([
                'amount' => $cart->amount + $amount,
            ]);
        } else {
            // 否则创建一个新的购物车记录

            // 当更新 belongsTo 关联时，
            // 可以使用 associate 方法。此方法将会在子模型中设置外键
            $cart = new CartItem(['amount' => $amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }
        return [];    
    }
    
}
