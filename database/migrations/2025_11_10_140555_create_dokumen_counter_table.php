<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_counter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_unit'); // dari user
            $table->year('tahun');
            $table->string('jenis_dokumen', 20); // SPJ, KW, NP, BAPP, BAST, dll
            $table->integer('nomor_terakhir')->default(0);
            $table->timestamps();

            $table->unique(['id_unit', 'tahun', 'jenis_dokumen']); // mencegah duplikat counter
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_counter');
    }
};
