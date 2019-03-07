<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersAddCouponCodeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // onDelete('set null') 代表如果这个订单有关联优惠券并且该优惠券被删除时将自动把 coupon_code_id 设成 null。
            // 我们不能因为删除了优惠券就把关联了这个优惠券的订单都删除了，这是绝对不允许的。

            $table->unsignedInteger('coupon_code_id')->nullable()->after('paid_at');
            $table->foreign('coupon_code_id')->references('id')->on('coupon_codes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // dropForeign() 删除外键关联，要早于 dropColumn() 删除字段调用，否则数据库会报错。
            $table->dropForeign(['coupon_code_id']);
            $table->dropColumn('coupon_code_id');
        });
    }
}
