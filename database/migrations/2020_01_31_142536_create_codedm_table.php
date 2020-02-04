<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodedmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codedm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',128)->unique();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('codeean13_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codedm');
    }
}
