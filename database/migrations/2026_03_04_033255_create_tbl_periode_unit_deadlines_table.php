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
        Schema::create('tbl_periode_unit_deadline', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('unit_id');
            $table->timestamps();

            $table->unique(['periode_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_periode_unit_deadline');
    }
};
