<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daftar_penerima_honor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_spj');
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->decimal('jumlah', 18, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_spj')->references('id')->on('spj')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('daftar_penerima_honor');
    }
};
