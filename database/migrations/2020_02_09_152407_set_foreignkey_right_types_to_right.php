<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignkeyRightTypesToRight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_rights', function (Blueprint $table) {
            $table->unsignedBigInteger('right_id');
            $table->foreign('right_id')->references('id')->on('rights');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_rights', function (Blueprint $table) {
            $table->dropForeign('type_rights_right_id_foreign');
            $table->dropColumn('right_id');
        });
    }
}
