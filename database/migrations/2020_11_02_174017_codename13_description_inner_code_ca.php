<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Codename13DescriptionInnerCodeCa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('codeean13', function (Blueprint $table) {
            $table->string('description', 1024)->nullable();
            $table->string('innerCode',255)->nullable();
            $table->boolean('Certification')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('codeean13', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('innerCode');
            $table->dropColumn('Certification');
        });
    }
}
