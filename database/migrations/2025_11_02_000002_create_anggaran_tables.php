<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_subkegiatan')->nullable();
            $table->year('tahun');
            $table->string('sumber_dana')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('waktu_pelaksanaan')->nullable();
            $table->string('kelompok_sasaran')->nullable();
            $table->decimal('pagu_anggaran', 18, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('rincian_anggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_anggaran')->constrained('anggaran')->cascadeOnDelete();
            $table->string('kode_rekening', 50)->nullable();
            $table->text('uraian')->nullable();
            $table->string('koefisien', 50)->nullable();
            $table->string('satuan', 100)->nullable();
            $table->decimal('harga', 18, 2)->default(0);
            $table->decimal('ppn', 18, 2)->default(0);
            $table->decimal('jumlah', 18, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->foreignId('id_parent')->nullable()->constrained('rincian_anggaran')->nullOnDelete();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rincian_anggaran');
        Schema::dropIfExists('anggaran');
    }
};
