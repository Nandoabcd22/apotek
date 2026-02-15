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
        Schema::table('penjualans', function (Blueprint $table) {
            // Drop the old foreign key and column
            $table->dropForeign(['id_pelanggan']);
            $table->dropColumn('id_pelanggan');
            
            // Add new user_id foreign key
            $table->unsignedBigInteger('user_id')->after('tanggal_penjualan');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            // Drop the new user_id foreign key and column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            
            // Add back the old id_pelanggan column
            $table->string('id_pelanggan', 10)->after('tanggal_penjualan');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('restrict');
        });
    }
};
