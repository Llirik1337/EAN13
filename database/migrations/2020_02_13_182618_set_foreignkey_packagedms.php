<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignkeyPackagedms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packagedms', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('codedm_id');

            $table->foreign('package_id')->references('id')->on('packages');
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
        Schema::table('packagedms', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropForeign(['codedm_id']);

            $table->dropColumn(['package_id']);
            $table->dropColumn(['codedm_id']);
        });
    }
}
