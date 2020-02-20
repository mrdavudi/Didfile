<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products',function (Blueprint $table){
            $table->increments('id');
            $table->string('title',100);
            $table->string('price',20);
            $table->string('size',15);
            $table->string('time',30);
            $table->string('countFile',15);
            $table->text('description');
            $table->string('type',50);
            $table->string('level',20);
            $table->string('detail_description',255);
            $table->text('headings');
            $table->text('pic');

            $table->unsignedInteger('categoryId');
            $table->unsignedInteger('userId');
            $table->unsignedInteger('fileTypeId');

            $table->foreign('categoryId')->references('id')->on('categories')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('userId')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fileTypeId')->references('id')->on('filetype')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
