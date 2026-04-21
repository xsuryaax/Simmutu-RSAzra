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
        // 1. Rename existing tables for better alignment with Indikator Mutu
        // tbl_spm_laporan -> tbl_spm_laporan_dan_analis
        Schema::rename('tbl_spm_laporan', 'tbl_spm_laporan_dan_analis');
        
        // tbl_spm_analisa -> tbl_spm_hasil_analisa
        Schema::rename('tbl_spm_analisa', 'tbl_spm_hasil_analisa');

        // 2. Refine tbl_spm_laporan_dan_analis to match tbl_laporan_dan_analis
        Schema::table('tbl_spm_laporan_dan_analis', function (Blueprint $table) {
            $table->decimal('nilai_validator', 10, 2)->nullable();
            $table->enum('status_laporan', ['valid', 'tidak-valid'])->nullable();
            $table->decimal('target_saat_input', 10, 2)->nullable();
            $table->decimal('target_min_saat_input', 10, 2)->nullable();
            $table->decimal('target_max_saat_input', 10, 2)->nullable();
            $table->enum('arah_target_saat_input', ['lebih_besar', 'lebih_kecil', 'range'])->nullable();
        });

        // Master remains tbl_spm as requested.
        // Already contains what it needs based on tbl_indikator comparison.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_spm_laporan_dan_analis', function (Blueprint $table) {
            $table->dropColumn([
                'nilai_validator',
                'status_laporan',
                'target_saat_input',
                'target_min_saat_input',
                'target_max_saat_input',
                'arah_target_saat_input'
            ]);
        });
        
        Schema::rename('tbl_spm_laporan_dan_analis', 'tbl_spm_laporan');
        Schema::rename('tbl_spm_hasil_analisa', 'tbl_spm_analisa');
    }
};
