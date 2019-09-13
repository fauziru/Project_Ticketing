<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevBuatRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request', function (Blueprint $table) {
            $table->bigIncrements('req_id');
            $table->foreign('pic_id')->references('pic_id')->on('pic');
            $table->smallInteger('stat_id');
            $table->smallInteger('kategori_id');
            $table->smallInteger('prioritas_id');
            $table->string('diajukan_oleh','20');
            $table->string('deskripsi_masalah','150');
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
        Schema::dropIfExists('request');
    }
}
