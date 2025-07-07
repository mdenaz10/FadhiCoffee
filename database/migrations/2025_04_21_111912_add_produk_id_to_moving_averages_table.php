<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::table('moving_averages', function (Blueprint $table) {
      $table->foreignId('produk_id')->nullable()->constrained('produk');
      $table->decimal('moving_average', 10, 2)->nullable(); // menambahkan kolom moving_average
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('moving_averages', function (Blueprint $table) {
      //
    });
  }
};
