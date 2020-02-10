<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignkeyCodedmToCodeean13 extends Migration
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

            $table->foreign('codeean13_id')->references('id')->on('codeean13');
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
            $table->dropForeign('codedm_codeean13_id_foreign');
        });
    }
}
