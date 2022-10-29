<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('status', 25);
            $table->decimal('lat', 10, 8);
            $table->decimal('long', 11, 8);
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->time('jam_keluar');
            $table->string('ket', 255);
            $table->string('surat_sakit', 255);
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
        Schema::dropIfExists('kehadirans');
    }
};
