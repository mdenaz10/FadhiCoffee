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
      Schema::create('transaksi_produk', function (Blueprint $table) {
        $table->id();
        $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
        $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
        $table->integer('jumlah');
        $table->decimal('total_harga', 15, 2);
        $table->timestamps();
    });
  }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
