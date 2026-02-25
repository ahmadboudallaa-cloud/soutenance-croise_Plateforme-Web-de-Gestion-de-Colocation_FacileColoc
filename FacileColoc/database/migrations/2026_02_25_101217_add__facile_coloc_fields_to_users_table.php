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
        Schema::table('users', function (Blueprint $table) {

            // Admin global plateforme
            $table->boolean('is_global_admin')
                  ->default(false)
                  ->after('password');

            // Date de bannissement
            $table->timestamp('banned_at')
                  ->nullable()
                  ->after('is_global_admin');

            // Système de réputation
            $table->integer('reputation')
                  ->default(0)
                  ->after('banned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'is_global_admin',
                'banned_at',
                'reputation'
            ]);
        });
    }
};