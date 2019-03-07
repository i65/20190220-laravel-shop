<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CouponCode;
use Carbon\Carbon;


use App\Exceptions\CouponCodeUnavailableException;

class CouponCodesController extends Controller
{
    // 优惠券展示页面
    public function show($code, Request $request)
    {
        // 判断优惠券是否存在
        if (!$record = CouponCode::where('code', $code)->first()) {
            throw new CouponCodeUnavailableException('优惠券不存在');
        }

        $record->checkAvailable($request->user());

        return $record;
    }
}
