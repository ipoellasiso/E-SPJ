<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('uraian');
            $table->timestamps();
        });

        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->string('kode', 10)->unique();
            $table->string('uraian');
            $table->timestamps();
        });

        Schema::create('jenis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id')->constrained('kelompok')->onDelete('cascade');
            $table->string('kode', 15)->unique();
            $table->string('uraian');
            $table->timestamps();
        });

        Schema::create('objek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_id')->constrained('jenis')->onDelete('cascade');
            $table->string('kode', 20)->unique();
            $table->string('uraian');
            $table->timestamps();
        });

        Schema::create('rincian_objek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objek_id')->constrained('objek')->onDelete('cascade');
            $table->string('kode', 25)->unique();
            $table->string('uraian');
            $table->timestamps();
        });

        Schema::create('sub_rincian_objek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rincian_objek_id')->constrained('rincian_objek')->onDelete('cascade');
            $table->string('kode', 30)->unique();
            $table->string('uraian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_rincian_objek');
        Schema::dropIfExists('rincian_objek');
        Schema::dropIfExists('objek');
        Schema::dropIfExists('jenis');
        Schema::dropIfExists('kelompok');
        Schema::dropIfExists('akun');
    }
};
