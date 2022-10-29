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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 12)->unique();
            $table->string('nama_staf', 255);
            $table->string('jabatan', 50);
            $table->string('jurusan', 100);
            $table->string('golongan', 50);
            $table->string('notelp', 15);
            $table->string('image', 255)->nullable();
            $table->string('password');
            $table->integer('role_id');
            $table->enum('active', ['1', '0'])->default('1');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
