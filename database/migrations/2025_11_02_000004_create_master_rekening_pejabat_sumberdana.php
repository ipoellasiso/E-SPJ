<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rekening', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50);
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('pejabat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip', 30)->nullable();
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });

        Schema::create('penugasan_pejabat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_anggaran')->constrained('anggaran')->cascadeOnDelete();
            $table->foreignId('id_pejabat')->constrained('pejabat')->cascadeOnDelete();
            $table->string('peran')->nullable(); // misal: PPTK, PPK, Bendahara
            $table->timestamps();
        });

        Schema::create('sumber_dana', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sumber_dana');
        Schema::dropIfExists('penugasan_pejabat');
        Schema::dropIfExists('pejabat');
        Schema::dropIfExists('rekening');
    }
};
