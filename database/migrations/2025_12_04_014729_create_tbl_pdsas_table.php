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
        Schema::create('tbl_pdsa', function (Blueprint $table) {
            $table->id();
            $table->Integer('indikator_id');
            $table->Integer('unit_id');
            $table->integer('tahun');
            $table->enum('quarter', ['Q1', 'Q2', 'Q3', 'Q4']);
            $table->decimal('realisasi', 5, 2);
            $table->longText('plan');
            $table->longText('do');
            $table->longText('study');
            $table->longText('action');
            $table->enum('status', ['open', 'review', 'revisi', 'closed'])
                ->default('open');
            $table->Integer('created_by');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pdsa');
    }
};
