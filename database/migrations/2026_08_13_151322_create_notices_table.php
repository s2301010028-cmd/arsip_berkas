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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('lokasi');
            
            // Shift Pagi
            $table->string('petugas_pagi')->nullable();
            $table->string('awal_pagi')->nullable();
            $table->string('akhir_pagi')->nullable();
            $table->integer('jumlah_pagi')->nullable();
            $table->string('status_pagi')->nullable();
            $table->text('keterangan_pagi')->nullable();
            
            // Shift Sore
            $table->string('petugas_sore')->nullable();
            $table->string('awal_sore')->nullable();
            $table->string('akhir_sore')->nullable();
            $table->integer('jumlah_sore')->nullable();
            $table->string('status_sore')->nullable();
            $table->text('keterangan_sore')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
