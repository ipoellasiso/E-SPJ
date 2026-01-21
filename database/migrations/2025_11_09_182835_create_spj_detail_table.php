<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spj_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_spj');
            $table->unsignedBigInteger('id_rincian_anggaran')->nullable();
            $table->string('nama_barang', 255)->nullable();
            $table->decimal('volume', 12, 2)->default(0);
            $table->string('satuan', 50)->nullable();
            $table->decimal('harga', 20, 2)->default(0);
            $table->decimal('jumlah', 20, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_spj')->references('id')->on('spj')->onDelete('cascade');
            // Jika kamu sudah punya tabel rincian_anggaran, aktifkan ini juga:
            // $table->foreign('id_rincian_anggaran')->references('id')->on('rincian_anggaran')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spj_detail');
    }
};
