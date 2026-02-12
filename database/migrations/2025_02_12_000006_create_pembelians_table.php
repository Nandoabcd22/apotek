<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->string('no_pembelian', 20)->primary();
            $table->date('tanggal_pembelian');
            $table->string('id_supplier', 10);
            $table->decimal('diskon', 5, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->foreign('id_supplier')->references('id_supplier')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
