<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_promo')) {
            Schema::create('customer_promo', function (Blueprint $table) {
                $table->id();
                $table->string('p_name');
                $table->string('p_exp_date');
                $table->string('p_price');
                $table->integer('p_limit');
                $table->enum('p_statue',['1','0'])->default('0');
                $table->enum('p_type',['1','0'])->default('0');
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
        Schema::dropIfExists('customer_promo');
    }
}
