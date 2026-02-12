<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->string('no_penjualan', 20)->primary();
            $table->date('tanggal_penjualan');
            $table->string('id_pelanggan', 10);
            $table->decimal('diskon', 5, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
