<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('user_id');
            $table->foreignId('siswa_id');
            $table->foreignId('target_id');
            $table->unsignedBigInteger('from_surat');
            $table->foreign('from_surat')->references('id')->on('surats');
            $table->integer('from_ayat');
            $table->unsignedBigInteger('to_surat');
            $table->foreign('to_surat')->references('id')->on('surats');
            $table->integer('to_ayat');
            $table->integer('total_ayat');
            $table->integer('makhroj');
            $table->integer('tajwid');
            $table->integer('kelancaran');
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
        Schema::dropIfExists('harians');
    }
}
