<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
// use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
// use Encore\Admin\Show;

class OrdersController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('订单列表')
            ->body($this->grid());
    }    

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        // 只展示已支付的订单， 并且默认按支付时间倒序排序
        $grid->model()->whereNotNull('paid_at')->orderBy('paid_at', 'desc');
        
        $grid->no('订单流水号');
        // 展示关联关系的字段时，使用 column 方法
        $grid->column('user.name', '买家');
        $grid->total_amount('总金额')->sortable();
        $grid->paid_at('支付时间')->sortable();
        $grid->ship_status('物流')->display(function($value) {
            return Order::$shipStatusMap[$value];
        });
        $grid->refund_status('退款状态')->display(function($value) {
            return Order::$refundStatusMap[$value];
        });
        // 禁用创建按钮，后台不需要创建订单
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 禁用删除和编辑按钮
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });        

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->id('Id');
        $show->no('No');
        $show->user_id('User id');
        $show->address('Address');
        $show->total_amount('Total amount');
        $show->remark('Remark');
        $show->paid_at('Paid at');
        $show->payment_method('Payment method');
        $show->payment_no('Payment no');
        $show->refund_status('Refund status');
        $show->refund_no('Refund no');
        $show->closed('Closed');
        $show->reviewed('Reviewed');
        $show->ship_status('Ship status');
        $show->ship_data('Ship data');
        $show->extra('Extra');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->text('no', 'No');
        $form->number('user_id', 'User id');
        $form->textarea('address', 'Address');
        $form->decimal('total_amount', 'Total amount');
        $form->textarea('remark', 'Remark');
        $form->datetime('paid_at', 'Paid at')->default(date('Y-m-d H:i:s'));
        $form->text('payment_method', 'Payment method');
        $form->text('payment_no', 'Payment no');
        $form->text('refund_status', 'Refund status')->default('pending');
        $form->text('refund_no', 'Refund no');
        $form->switch('closed', 'Closed');
        $form->switch('reviewed', 'Reviewed');
        $form->text('ship_status', 'Ship status')->default('pending');
        $form->textarea('ship_data', 'Ship data');
        $form->textarea('extra', 'Extra');

        return $form;
    }
}
