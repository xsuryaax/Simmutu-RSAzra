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
        Schema::create('tbl_pdsa', function (Blueprint $table) {
            $table->id();
            $table->text('plan');
            $table->text('do');
            $table->text('study');
            $table->text('act');
            $table->string('file_pdsa')->nullable();
            $table->integer('laporan_analisis_id');
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
