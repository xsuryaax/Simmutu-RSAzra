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
        Schema::create('tbl_indikator_nasional', function (Blueprint $table) {
            $table->id();
            $table->string('nama_indikator_nasional');
            $table->decimal('target_indikator_nasional', 5, 2);
            $table->string('periode_tahun');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status_periode', ['aktif', 'non-aktif']);
            $table->enum('status_indikator_nasional', ['aktif', 'non-aktif']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_indikator_nasional');
    }
};
