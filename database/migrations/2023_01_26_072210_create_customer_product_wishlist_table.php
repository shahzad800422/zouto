<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductWishlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_product_wishlist')) {
            Schema::create('customer_product_wishlist', function (Blueprint $table) {
                $table->id();
                $table->integer('id_customer');
                $table->string('title');
                $table->string('additional_info');
                $table->string('product_size');
                $table->string('product_color');
                $table->double('price');
                $table->string('net_price');
                $table->string('currency');
                $table->integer('qty');
                $table->string('days');
                $table->string('weight');
                $table->string('weight_type');
                $table->double('admin_weight');
                $table->string('admin_weight_type');
                $table->string('product_url');
                $table->string('product_image');
                $table->double('length');
                $table->double('width');
                $table->double('height');
                $table->string('comment');
                $table->integer('status');
                $table->string('shipped_status');
                $table->double('shipping_cost');
                $table->string('shipping_type');
                $table->double('admin_shipping_cost');
                $table->string('source');
                $table->timestamp('date_add')->useCurrent();
                $table->string('hs_code');
                $table->string('origin_good');
                $table->integer('limit_product');
                $table->string('tracked_number');
                $table->enum('instock',['1','0']);
                $table->string('in_stock_date');
                $table->string('attributes');
                $table->string('supplier_track_number');
                $table->string('warehouse_name');
                $table->integer('product_status');
                $table->string('parcel_number');
                $table->string('parcel_weight');
                $table->string('parcel_weight_type');
                $table->string('parcel_l');
                $table->string('parcel_b');
                $table->string('parcel_h');
                $table->integer('parcel_status');
                $table->integer('invoiced');
                $table->string('invoice_number');
                $table->string('awb');
                $table->integer('parcel_for');
                $table->integer('parcel_archived');
                $table->string('selected_shipping');
                $table->string('selected_shipping_price');
                $table->string('parcel_locked_price');
                $table->string('selected_weight');
                $table->string('master_weight');
                $table->string('awb_archive');
                $table->integer('is_archived');
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
        Schema::dropIfExists('customer_product_wishlist');
    }
}
