<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bidang')->nullable()->after('id_unit');
            $table->index('id_bidang', 'idx_program_id_bidang');
        });

        // isi id_bidang dari unit_organisasi.id_bidang
        DB::statement("
            UPDATE program p
            JOIN unit_organisasi u ON p.id_unit = u.id
            SET p.id_bidang = u.id_bidang
            WHERE p.id_unit IS NOT NULL
        ");

        Schema::table('program', function (Blueprint $table) {
            $table->foreign('id_bidang', 'fk_program_id_bidang')
                ->references('id')->on('bidang_urusan')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        // jika mau hapus id_unit setelah yakin:
        // Schema::table('program', function (Blueprint $table) {
        //     $table->dropForeign(['id_unit']); // HATI2: sesuaikan nama FK jika custom
        //     $table->dropColumn('id_unit');
        // });
    }

    public function down()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->dropForeign('fk_program_id_bidang');
            $table->dropIndex('idx_program_id_bidang');
            $table->dropColumn('id_bidang');
        });
    }
};
