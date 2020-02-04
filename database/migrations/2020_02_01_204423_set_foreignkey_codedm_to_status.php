<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignkeyCodedmToStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('codedm', function (Blueprint $table) {
            //
            // $table->unsignedBigInteger('status');
            $table->foreign('status_id')->references('id')->on('statuscodedm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('codedm', function (Blueprint $table) {
            //
            $table->dropForeign('codedm_status_id_id_foreign');
        });
    }
}
