<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_cart')) {
            Schema::create('customer_cart', function (Blueprint $table) {
                $table->id();
                $table->integer('id_customer');
                $table->integer('id_cart');
                $table->integer('id_product');
                $table->integer('status');
                $table->integer('type');
                $table->string('shipping_name');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_cart');
    }
}
