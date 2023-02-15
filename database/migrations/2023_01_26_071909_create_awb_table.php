<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('awb')) {
            Schema::create('awb', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('awb_number');
                $table->string('invoice_number');
                $table->string('awb_archive');
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
        Schema::dropIfExists('awb');
    }
}
