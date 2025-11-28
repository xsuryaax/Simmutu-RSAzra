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
        Schema::create('tbl_indikator', function (Blueprint $table) {
            $table->id();
            $table->string('nama_indikator');
            $table->decimal('target_indikator', 5, 2);
            $table->enum('tipe_indikator', ['lokal', 'nasional']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status_periode', ['aktif', 'non-aktif']);
            $table->enum('status_indikator', ['aktif', 'non-aktif']);
            $table->integer('unit_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_indikator');
    }
};
