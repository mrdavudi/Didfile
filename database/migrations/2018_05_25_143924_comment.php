<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments',function (Blueprint $table){
            $table->increments('id');
            $table->text('text');
            $table->unsignedInteger('sid');
            $table->unsignedInteger('userId');
            $table->unsignedInteger('productId');

            $table->foreign('sid')->references('id')->on('comments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('Users')->onUpdate('cascade');
            $table->foreign('productId')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
