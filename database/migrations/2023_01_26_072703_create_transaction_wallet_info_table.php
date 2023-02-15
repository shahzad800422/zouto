<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionWalletInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transaction_wallet_info')) {
            Schema::create('transaction_wallet_info', function (Blueprint $table) {
                $table->id();
                $table->integer('id_cart');
                $table->string('transaction_date');
                $table->string('ajouter');
                $table->string('de_client');
                $table->string('re_client');
                $table->string('products');
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
        Schema::dropIfExists('transaction_wallet_info');
    }
}
