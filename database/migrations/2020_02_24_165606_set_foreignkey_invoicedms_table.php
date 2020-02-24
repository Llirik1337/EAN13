<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignkeyInvoicedmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoicedms', function (Blueprint $table) {
            $table->unsignedBigInteger('invoce_id');
            $table->unsignedBigInteger('codedm_id');

            $table->foreign('invoce_id')->references('id')->on('invoices');
            $table->foreign('codedm_id')->references('id')->on('codedm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoicedms', function (Blueprint $table) {
            $table->dropForeign(['invoce_id', 'codedm_id']);
            $table->dropColumn(['invoce_id', 'codedm_id']);
        });
    }
}
