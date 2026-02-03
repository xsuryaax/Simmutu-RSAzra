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
        Schema::create('tbl_kamus_indikator', function (Blueprint $table) {
            $table->id();
            $table->integer('indikator_id');
            $table->string('kategori_indikator');
            $table->integer('kategori_id')->nullable();
            $table->string('dimensi_mutu_id');
            $table->text('dasar_pemikiran');
            $table->text('tujuan');
            $table->text('definisi_operasional');
            $table->integer('jenis_indikator_id');
            $table->text('satuan_pengukuran');
            $table->text('numerator');
            $table->text('denominator');
            $table->text('target_pencapaian');
            $table->text('kriteria_inklusi');
            $table->text('kriteria_eksklusi');
            $table->text('formula');
            $table->text('metode_pengumpulan_data');
            $table->text('sumber_data');
            $table->text('instrumen_pengambilan_data');
            $table->text('populasi');
            $table->text('sampel');
            
            $table->integer('periode_pengumpulan_data_id');
            $table->integer('periode_analisis_data_id');
            $table->integer('penyajian_data_id');
            $table->text('penanggung_jawab');
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
