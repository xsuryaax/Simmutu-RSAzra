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
        Schema::create('tbl_hasil_analisa', function (Blueprint $table) {
            $table->id();
            $table->Integer('indikator_id');
            $table->date('tanggal_analisa');
            $table->text('analisa')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->Integer('unit_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_hasil_analisa');
    }
};
