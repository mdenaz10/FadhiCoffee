<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('moving_averages', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->decimal('moving_average', 10, 2);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('moving_averages');
    }
};

