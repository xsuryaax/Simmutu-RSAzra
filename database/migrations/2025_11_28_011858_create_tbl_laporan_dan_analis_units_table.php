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
        Schema::create('tbl_laporan_dan_analis_unit', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_laporan')->nullable();
            $table->integer('indikator_id');
            $table->integer('unit_id');
            $table->decimal('nilai', 8, 2);
            $table->enum('pencapaian', ['tercapai', 'tidak-tercapai']);
            $table->enum('status_laporan', ['menunggu', 'disetujui', 'ditolak', 'pdsa'])->default('menunggu');
            $table->string('file_laporan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_laporan_dan_analis_unit');
    }
};
