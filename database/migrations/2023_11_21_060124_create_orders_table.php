<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('dealer_id')->nullable();
            $table->string('order_status')->nullable();
            $table->string('name',50)->nullable();
            $table->string('email')->nullable();
            $table->string('phone',50)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode',50)->nullable();
            $table->string('dealer_code')->nullable();
            $table->string('dealer_discount_type',50)->nullable();
            $table->string('dealer_discount_value',50)->nullable();
            $table->json('product_ids')->nullable();
            $table->json('gold_price')->nullable();
            $table->double('sub_total')->default(0.00);
            $table->double('charges')->default(0.00);
            $table->double('total')->default(0.00);
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
        Schema::dropIfExists('orders');
    }
}
