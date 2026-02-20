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
        Schema::create('tbl_periode', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode');
            $table->year('tahun');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('deadline')->nullable();
            $table->enum('status', ['aktif', 'non-aktif'])->default('non-aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_periode');
    }
};
