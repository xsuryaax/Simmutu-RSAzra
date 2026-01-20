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
        Schema::create('tbl_kamus_indikator', function (Blueprint $table) {
            $table->id();
            $table->text('definisi_operasional');
            $table->text('tujuan');
            $table->text('dasar_pemikiran');
            $table->text('formula_pengukuran');
            $table->text('metodologi');
            $table->text('detail_pengukuran');
            $table->text('sumber_data');
            $table->text('penanggung_jawab');
            $table->string('jenis_indikator');
            $table->integer('kategori_id')->nullable();
            $table->integer('indikator_id');
            $table->string('dimensi_mutu_id');
            $table->integer('metodologi_pengumpulan_data_id');
            $table->integer('cakupan_data_id');
            $table->integer('frekuensi_pengumpulan_data_id');
            $table->integer('frekuensi_analisis_data_id');
            $table->integer('metodologi_analisis_data_id');
            $table->integer('interpretasi_data_id');
            $table->integer('publikasi_data_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kamus_indikator');
    }
};
