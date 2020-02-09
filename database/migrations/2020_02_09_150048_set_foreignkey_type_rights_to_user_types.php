<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignkeyTypeRightsToUserTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_rights', function (Blueprint $table) {
            $table->unsignedBigInteger('user_types_id');
            $table->foreign('user_types_id')->references('id')->on('user_types');
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
            $table->dropForeign('type_rights_user_types_id_id_foreign');
        });
    }
}
