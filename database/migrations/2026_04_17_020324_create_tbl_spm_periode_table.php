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
        Schema::create('tbl_spm_periode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spm_id');
            $table->unsignedBigInteger('periode_id');
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('spm_id')->references('id')->on('tbl_spm')->onDelete('cascade');
            $table->foreign('periode_id')->references('id')->on('tbl_periode')->onDelete('cascade');
        });

        // Seed existing active SPMs into the currently active period to preserve accessibility
        $activePeriode = \Illuminate\Support\Facades\DB::table('tbl_periode')->where('status', 'aktif')->first();
        if ($activePeriode) {
            $activeSpms = \Illuminate\Support\Facades\DB::table('tbl_spm')->where('status_spm', 'aktif')->get();
            $inserts = [];
            foreach ($activeSpms as $spm) {
                $inserts[] = [
                    'spm_id' => $spm->id,
                    'periode_id' => $activePeriode->id,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            if (count($inserts) > 0) {
                \Illuminate\Support\Facades\DB::table('tbl_spm_periode')->insert($inserts);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_spm_periode');
    }
};
