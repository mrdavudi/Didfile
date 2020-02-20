<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders',function (Blueprint $table){
            $table->increments('id');
            $table->string('orderDate',50);
            $table->string('price',30);

            $table->unsignedInteger('productId');
            $table->unsignedInteger('customerId');
            $table->unsignedInteger('sellerId');
            $table->unsignedInteger('bankId');
            $table->unsignedInteger('couponId');

            $table->foreign('productId')->references('id')->on('products')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('customerId')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('bankId')->references('id')->on('banks')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('couponId')->references('id')->on('coupons')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('sellerId')->references('id')->on('Users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
