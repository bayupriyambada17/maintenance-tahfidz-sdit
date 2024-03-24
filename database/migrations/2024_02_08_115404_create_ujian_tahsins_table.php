<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianTahsinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_tahsins', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('user_id');
            $table->foreignId('siswa_id');
            $table->foreignId('kelas_id');
            $table->text('from');
            $table->text('to');
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
        Schema::dropIfExists('ujian_tahsins');
    }
}
