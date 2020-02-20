<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Coupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons',function (Blueprint $table){
           $table->increments('id');
           $table->string('code',30)->unique();
           $table->string('description',100);
           $table->unsignedInteger('productId');
           $table->unsignedInteger('categoryId');

            $table->foreign('productId')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('categoryId')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
