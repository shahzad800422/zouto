<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transaction')) {
            Schema::create('transaction', function (Blueprint $table) {
                $table->id();
                $table->integer('id_cart');
                $table->integer('id_customer');
                $table->string('payment_type');
                $table->string('paid_amount');
                $table->string('paid_amount_currency');
                $table->string('amount_capturable');
                $table->string('amount_refunded');
                $table->string('txn_id');
                $table->string('pi_id');
                $table->string('payment_method');
                $table->string('payment_status');
                $table->integer('locked_status');
                $table->string('created');
                $table->string('modified');
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
        Schema::dropIfExists('transaction');
    }
}
