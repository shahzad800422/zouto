<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifyCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('shopify_customers')) {
            Schema::create('shopify_customers', function (Blueprint $table) {
                $table->id();
                $table->integer('id_customer');
                $table->string('email');
                $table->string('firstname');
                $table->string('lastname');
                $table->string('currency');
                $table->string('address1');
                $table->string('city');
                $table->string('state');
                $table->string('country');
                $table->string('zipcode');
                $table->string('phone');
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
        Schema::dropIfExists('shopify_customers');
    }
}
