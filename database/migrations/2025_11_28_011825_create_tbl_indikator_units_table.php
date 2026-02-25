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
        Schema::create('tbl_indikator', function (Blueprint $table) {
            $table->id();
            $table->string('nama_indikator');
            $table->decimal('target_indikator', 5, 2)->nullable();
            $table->decimal('target_min', 8, 2)->nullable();
            $table->decimal('target_max', 8, 2)->nullable();

            $table->enum('arah_target', ['lebih_besar', 'lebih_kecil', 'range'])
                ->default('lebih_besar');
            $table->enum('tipe_indikator', ['lokal', 'nasional']);
            $table->enum('status_indikator', ['aktif', 'non-aktif']);
            $table->integer('unit_id');
            $table->integer('kamus_indikator_id')->nullable();
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
