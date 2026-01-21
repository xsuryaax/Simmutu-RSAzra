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
            $table->Integer('assignment_id');
            $table->longText('plan')->nullable();
            $table->longText('do')->nullable();
            $table->longText('study')->nullable();
            $table->longText('action')->nullable();
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
