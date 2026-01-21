<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('spj', function (Blueprint $table) {
            $table->string('nomor_kwitansi')->nullable();
            $table->string('nomor_nota')->nullable();
            $table->string('nomor_bapp')->nullable(); // berita acara pengadaan
            $table->string('nomor_bapb')->nullable(); // berita acara pemeriksaan
            $table->string('nomor_bast')->nullable(); // berita acara serah terima
            $table->string('nomor_ba_penerimaan')->nullable(); // berita acara penerimaan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spj', function (Blueprint $table) {
            //
        });
    }
};
