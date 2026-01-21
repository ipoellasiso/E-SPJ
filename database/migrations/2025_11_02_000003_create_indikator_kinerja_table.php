<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('indikator_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_anggaran')->constrained('anggaran')->cascadeOnDelete();
            $table->enum('jenis', ['Capaian', 'Masukan', 'Keluaran', 'Hasil']);
            $table->string('tolok_ukur');
            $table->string('target_kinerja');
            $table->string('satuan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator_kinerja');
    }
};
