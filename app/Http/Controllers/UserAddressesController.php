<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Http\Requests\UserAddressRequest;

class UserAddressesController extends Controller
{
    // 收货地址展示页面
    public function index(Request $request)
    {
        return view('user_addresses.index', [
            'addresses' => $request->user()->addresses,
        ]);
    }
    // 新增收货地址页面
    public function create()
    {
        return view('user_addresses.create_and_edit', ['address' => new UserAddress()]);
    }

    /**
     * $request->user() 获取当前登录用户。
     * user()->addresses() 获取当前用户与地址的关联关系（注意：这里并不是获取当前用户的地址列表）
     * addresses()->create() 在关联关系里创建一个新的记录。
     * $request->only() 通过白名单的方式从用户提交的数据里获取我们所需要的数据。
     * return redirect()->route('user_addresses.index'); 跳转回我们的地址列表页面
     * */ 
    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return redirect()->route('user_addresses.index');
    }
}
