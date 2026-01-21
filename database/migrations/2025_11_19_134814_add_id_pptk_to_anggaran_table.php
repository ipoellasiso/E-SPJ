<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('anggaran', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pptk')->nullable()->after('id_unit');
        });
    }

    public function down()
    {
        Schema::table('anggaran', function (Blueprint $table) {
            $table->dropColumn('id_pptk');
        });
    }
};
