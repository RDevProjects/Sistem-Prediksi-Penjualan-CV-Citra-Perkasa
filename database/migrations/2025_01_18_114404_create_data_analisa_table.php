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
        Schema::create('data_analisa', function (Blueprint $table) {
            $table->id();
            $table->string('key'); // Untuk menyimpan kunci JSON (a0.1, a0.3, a0.5)
            $table->string('bulan'); // Bulan
            $table->integer('tahun'); // Tahun
            $table->float('At'); // Nilai At
            $table->float('Ft'); // Nilai Ft
            $table->float('APE'); // Nilai APE
            $table->float('total_mape')->nullable(); // Total MAPE
            $table->timestamp('created_at')->nullable()->useCurrent(false); // created_at
            $table->timestamp('updated_at')->nullable(); // updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_analisa');
    }
};
