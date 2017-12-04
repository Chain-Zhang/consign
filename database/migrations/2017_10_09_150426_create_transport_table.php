<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id');
            $table->string('car_model');//车型
            $table->string('vin_no');//车架号
            $table->string('owner');//出车方
            $table->string('owner_phone');//出车方电话号码
            $table->string('from');//始发地
            $table->string('to');//目的地
            $table->double('charge');//总收费用
            $table->double('st_charge');//小板车费用
            $table->double('lt_charge');//大板车费用
            $table->integer('payment_method');//付款方式:1-现付;2-到付
            $table->integer('payment_status');//付款状态:0-未付款;1-已付款
            $table->integer('transport_status');//运输状态:0-已下单;1-已接单;2-已发货;3-已达目的地;4-已签收
            $table->dateTime('order_date')->nullable();//下单时间
            $table->dateTime('ordered_date')->nullable();//接单时间
            $table->dateTime('delivery_date')->nullable();//发货时间
            $table->dateTime('arrived_date')->nullable();//到达时间
            $table->dateTime('sign_date')->nullable();//签收时间
            $table->integer('salesman_id');//业务员编号
            $table->integer('created_by');//创建人编号
            $table->boolean('is_transfer');//是否中转
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport');
    }
}
