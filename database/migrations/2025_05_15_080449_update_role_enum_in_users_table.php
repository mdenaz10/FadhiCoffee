<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum dari ['admin', 'kasir'] menjadi ['admin', 'owner']
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'kasir', 'owner') NOT NULL");

    }

    public function down(): void
    {
        // Balik lagi ke enum awal jika dibutuhkan
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'kasir', 'owner') NOT NULL");

    }
};
