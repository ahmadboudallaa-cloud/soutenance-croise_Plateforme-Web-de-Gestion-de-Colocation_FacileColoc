<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
   public function up(): void
{
    if (!Schema::hasTable('payments')) {

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colocation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });

    }
}
    
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

