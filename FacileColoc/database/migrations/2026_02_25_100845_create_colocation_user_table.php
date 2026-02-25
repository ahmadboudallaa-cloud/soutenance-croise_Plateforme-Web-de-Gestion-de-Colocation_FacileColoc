<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colocation_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('colocation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // role dans la colocation (pas un acteur global)
            $table->string('role')->default('member'); // owner | member

            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['colocation_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colocation_user');
    }
};