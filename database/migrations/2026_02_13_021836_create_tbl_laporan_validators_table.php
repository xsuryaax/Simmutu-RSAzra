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
        Schema::create('tbl_laporan_validator', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_laporan')->nullable();
            $table->integer('indikator_id');
            $table->integer('laporan_analis_id');
            $table->integer('unit_id')->nullable();
            $table->string('kategori_indikator')->nullable();
            $table->integer('kategori_id')->nullable();
            $table->integer('numerator');
            $table->integer('denominator');
            $table->decimal('nilai_validator', 8, 2);
            $table->enum('pencapaian', ['tercapai', 'tidak-tercapai']);
            $table->enum('status_laporan', ['valid', 'tidak-valid'])->nullable();
            $table->string('file_laporan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_laporan_validator');
    }
};
