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
        Schema::create('tbl_imprs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_imprs');
            $table->decimal('target_imprs', 5, 2);
            $table->enum('tipe_imprs', ['lokal', 'nasional']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status_periode', ['aktif', 'non-aktif']);
            $table->enum('status_imprs', ['aktif', 'non-aktif']);
            $table->integer('kategori_id');
            $table->integer('kamus_imprs_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_imprs');
    }
};
