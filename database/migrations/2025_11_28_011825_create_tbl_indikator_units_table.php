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
        Schema::create('tbl_indikator_unit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_indikator_unit');
            $table->decimal('target_indikator_unit', 5, 2);
            $table->enum('tipe_indikator_unit', ['lokal', 'nasional']);
            $table->string('periode_tahun');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status_periode', ['aktif', 'non-aktif']);
            $table->enum('status_indikator_unit', ['aktif', 'non-aktif']);
            $table->integer('unit_id');
            $table->integer('kamus_indikator_unit_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_indikator_unit');
    }
};
