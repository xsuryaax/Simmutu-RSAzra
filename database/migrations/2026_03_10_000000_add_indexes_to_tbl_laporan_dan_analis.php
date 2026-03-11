<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_laporan_dan_analis', function (Blueprint $table) {
            $table->index('indikator_id');
            $table->index('unit_id');
            $table->index('tanggal_laporan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_laporan_dan_analis', function (Blueprint $table) {
            $table->dropIndex(['indikator_id']);
            $table->dropIndex(['unit_id']);
            $table->dropIndex(['tanggal_laporan']);
        });
    }
};
