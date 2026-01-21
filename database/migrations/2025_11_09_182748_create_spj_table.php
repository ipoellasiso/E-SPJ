<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spj', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anggaran');
            $table->string('nomor_spj', 100)->nullable();
            $table->date('tanggal')->nullable();
            $table->text('uraian')->nullable();
            $table->decimal('total', 20, 2)->default(0);
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->timestamps();

            // Jika kamu sudah punya tabel anggaran & unit, aktifkan ini:
            // $table->foreign('id_anggaran')->references('id')->on('anggaran')->onDelete('cascade');
            // $table->foreign('id_unit')->references('id')->on('unit')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spj');
    }
};
