<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('urusan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50);
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('bidang_urusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_urusan')->constrained('urusan')->cascadeOnDelete();
            $table->string('kode', 50);
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('unit_organisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bidang')->constrained('bidang_urusan')->cascadeOnDelete();
            $table->string('kode', 50);
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_unit')->constrained('unit_organisasi')->cascadeOnDelete();
            $table->string('kode', 50);
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_program')->constrained('program')->cascadeOnDelete();
            $table->string('kode', 50);
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('sub_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kegiatan')->constrained('kegiatan')->cascadeOnDelete();
            $table->string('kode', 50);
            $table->string('nama');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_kegiatan');
        Schema::dropIfExists('kegiatan');
        Schema::dropIfExists('program');
        Schema::dropIfExists('unit_organisasi');
        Schema::dropIfExists('bidang_urusan');
        Schema::dropIfExists('urusan');
    }
};
