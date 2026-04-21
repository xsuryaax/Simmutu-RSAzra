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
        // 1. Master SPM
        Schema::create('tbl_spm', function (Blueprint $table) {
            $table->id();
            $table->string('nama_spm');
            $table->unsignedBigInteger('unit_id');
            $table->decimal('target_spm', 10, 2);
            $table->enum('arah_target', ['lebih_besar', 'lebih_kecil', 'range']);
            $table->decimal('target_min', 10, 2)->nullable();
            $table->decimal('target_max', 10, 2)->nullable();
            $table->enum('status_spm', ['aktif', 'non-aktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('tbl_unit')->onDelete('cascade');
        });

        // 2. Laporan Pengisian SPM
        Schema::create('tbl_spm_laporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spm_id');
            $table->unsignedBigInteger('unit_id');
            $table->decimal('numerator', 10, 2);
            $table->decimal('denominator', 10, 2);
            $table->decimal('nilai', 10, 2)->nullable();
            $table->enum('pencapaian', ['tercapai', 'tidak-tercapai', 'N/A']);
            $table->date('tanggal_laporan');
            $table->string('file_laporan')->nullable();
            $table->timestamps();

            $table->foreign('spm_id')->references('id')->on('tbl_spm')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('tbl_unit')->onDelete('cascade');
        });

        // 3. Analisa SPM
        Schema::create('tbl_spm_analisa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spm_id');
            $table->unsignedBigInteger('unit_id');
            $table->date('tanggal_analisa');
            $table->text('analisa')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();

            $table->foreign('spm_id')->references('id')->on('tbl_spm')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('tbl_unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_spm_analisa');
        Schema::dropIfExists('tbl_spm_laporan');
        Schema::dropIfExists('tbl_spm');
    }
};
