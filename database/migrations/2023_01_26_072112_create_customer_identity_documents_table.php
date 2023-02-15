<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerIdentityDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_identity_documents')) {
            Schema::create('customer_identity_documents', function (Blueprint $table) {
                $table->id();
                $table->integer('id_customer');
                $table->integer('verified');
                $table->string('title');
                $table->string('identity_document');
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
        Schema::dropIfExists('customer_identity_documents');
    }
}
