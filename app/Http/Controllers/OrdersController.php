<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;
use App\Http\Requests\OrderRequest;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Models\Order;
use Carbon\Carbon;
use App\Jobs\CloseOrder;
use App\Services\CartService;
use App\Services\OrderService;

use App\Http\Requests\SendReviewRequest;

// 申请退款的用户提交检验
use App\Http\Requests\ApplyRefunRequest;

use App\Events\OrderReviewed;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            // 使用 with 方法预加载， 避免 N + 1 问题
            ->with(['items.product', 'items.productSku'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('orders.index', ['orders' => $orders]);
    }
    // 订单详情页
    public function show(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        // load() 方法与上一章节介绍的 with() 预加载方法有些类似，称为 延迟预加载，
        // 不同点在于 load() 是在已经查询出来的模型上调用，而 with() 则是在 ORM 查询构造器上调用。
        return view('orders.show', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }


    // 保存订单提交
    // 利用 Laravel 的自动解析功能注入 CartService 类
    public function store(OrderRequest $request, OrderService $orderService)
    {
        $user = $request->user();
        $address = UserAddress::find($request->input('address_id'));
        return $orderService->store($user, $address, $request->input('remark'), $request->input('items'));
        // 开启一个数据库事务        
        // 别忘了把 $cartService 加入 use 中
        // $order = \DB::transaction(function () use ($user, $request, $cartService) {
        //     $address = UserAddress::find($request->input('address_id'));
        //     // 更新此地址的最后使用时间
        //     $address->update(['last_used_at' => Carbon::now()]);
        //     // 创建一个订单
        //     $order = new Order([
        //         'address' => [ // 将地址信息放入订单中
        //             'address' => $address->full_address,
        //             'zip' => $address->zip,
        //             'contact_name' => $address->contact_name,
        //             'contact_phone' => $address->contact_phone,
        //         ],
        //         'remark' => $request->input('remark'),
        //         'total_amount' => 0,
        //     ]);
            
        //     // 订单关联到当前用户
        //     $order->user()->associate($user);
        //     // 写入数据库            
        //     $order->save();

        //     $totalAmount = 0;

        //     $items = $request->input('items');
        //     // 遍历用户提交的 SKU

        //     foreach ($items as $data) {
        //         $sku = ProductSku::find($data['sku_id']);
        //         // 创建一个 OrderItem 并直接与当前订单关联
        //         // 可以新建一个关联关系的对象（也就是 OrderItem）但不保存到数据库
        //         $item = $order->items()->make([
        //             'amount' => $data['amount'],
        //             'price' => $sku->price,
        //         ]);
        //         $item->product()->associate($sku->product_id);
        //         $item->productSku()->associate($sku);
        //         $item->save();

        //         $totalAmount += $sku->price * $data['amount'];                
        //         if ($sku->decreaseStock($data['amount']) <= 0) {                
        //             throw new InvalidRequestException('该商品库存不足');
        //         }
        //     }

        //     // 更新订单总金额
        //     $order->update(['total_amount' => $totalAmount]);

        //     // 将下单的商品从购物车中移除
        //     // $skuIds = collect($items)->pluck('sku_id');
        //     // $user->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
        //     $skuIds = collect($request->input('items'))->pluck('sku_id')->all();
        //     $cartService->remove($skuIds);


        //     // 创建订单之后触发延迟任务
        //     $this->dispatch(new CloseOrder($order, config('app.order_ttl')));

        //     return $order;
        // });

        // return $order;
    }

    // 确认收货
    public function received(Order $order, Request $request)
    {
        // 检验权限
        $this->authorize('own', $order);

        // 判断订单是否为已发货
        if ($order->ship_status !== Order::SHIP_STATUS_DELIVERED) {
            throw new InvalidRequestException('发货状态不正确');
        }

        // 更新发货状态为已收到
        $order->update([
            'ship_status' => Order::SHIP_STATUS_RECEIVED
        ]);

        // 返回原页面
        // return redirect()->back();
        // 由于我们把确认收货的操作从表单提交改成了 AJAX 请求，因此控制器中的返回值需要修改一下
        return $order;
    }

    // 评价页面
    public function review(Order $order)
    {
        // 检验权限
        $this->authorize('own', $order);
        // 判断是否已经支付
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可评价');
        }
        // 使用 load 方法加载关联数据，避免 N + 1 性能问题
        return view('orders.review', ['order' => $order->load('items.productSku', 'items.product')]);
    }

    // 提交评价接口
    public function sendReview(Order $order, SendReviewRequest $request)
    {       
        // 校验权限
        $this->authorize('own', $order);
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可评价');
        }
        // 判断是否已经评价
        if ($order->reviewed) {
            throw new InvalidRequestException('该订单已评价，不可重复提交');
        }
        $reviews = $request->input('reviews');
        // 开启事务
        \DB::transaction(function () use ($reviews, $order) {
            // 遍历用户提交的数据
            foreach ($reviews as $review) {
                $orderItem = $order->items()->find($review['id']);
                // 保存评价和评分
                $orderItem->update([
                    'rating' => $review['rating'],
                    'review' => $review['review'],
                    'reviewed_at' => Carbon::now(),
                ]);
            }
            // 将订单标记为已评价
            $order->update(['reviewed' => true]);
            
            event(new OrderReviewed($order));
        });

        return redirect()->back();
    }

    // 申请退款
    public function applyRefund(Order $order, ApplyRefunRequest $request)
    {
        // 校验订单是否属于当前用户
        $this->authorize('own', $order);
        // 判断订单是否已付款
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可退款');
        }
        // 判断订单退款状态是否正确
        if ($order->refund_status !== Order::REFUND_STATUS_PENDING) {
            throw new InvalidRequestException('该订单已经申请过退款，请勿重复申请');
        }
        // 将用户输入的退款理由放到订单的 extra 字段中
        $extra = $order->extra ?: [];
        $extra['refund_reason'] = $request->input('reason');
        // 将订单退款状态改为已申请退款
        $order->update([
            'refund_status' => Order::REFUND_STATUS_APPLIED,
            'extra' => $extra,
        ]);

        return $order;
    }
}
