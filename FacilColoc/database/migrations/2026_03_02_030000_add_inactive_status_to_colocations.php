<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE colocations MODIFY status ENUM('active','inactive','cancelled') NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE colocations MODIFY status ENUM('active','cancelled') NOT NULL DEFAULT 'active'");
    }
};
