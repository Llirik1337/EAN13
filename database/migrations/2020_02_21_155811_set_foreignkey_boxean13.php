<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignkeyBoxean13 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boxean13s', function (Blueprint $table) {
            $table->unsignedBigInteger('boxes_id');
            $table->unsignedBigInteger('packages_id');

            $table->foreign('boxes_id')->references('id')->on('boxes');
            $table->foreign('packages_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boxean13s', function (Blueprint $table) {
            $table->dropForeign(['boxes_id']);
            $table->dropForeign(['codedm_id']);

            $table->dropColumn(['boxes_id']);
            $table->dropColumn(['codedm_id']);
        });
    }
}
