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
        Schema::create('tbl_pdsa_assignments', function (Blueprint $table) {
            $table->id();
            $table->integer('indikator_id');
            $table->integer('unit_id');
            $table->integer('tahun');
            $table->enum('quarter', ['Q1', 'Q2', 'Q3', 'Q4']);
            $table->text('catatan_mutu')->nullable();
            $table->enum('status_pdsa', [
                'assigned',
                'submitted',
                'revised',
                'approved'
            ])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pdsa_assignments');
    }
};
