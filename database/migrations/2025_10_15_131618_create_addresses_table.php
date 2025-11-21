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
        Schema::create('addresses', function (Blueprint $table) {
             $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('label', 50)->nullable();           // e.g., "Home", "Office"
            $table->string('line1', 191);
          
            $table->string('city', 120);
            $table->string('state', 120);
            $table->string('pincode', 12);                     // India: 6-digit; keep flexible
            $table->string('phone', 20);                       // store as string to preserve leading 0s

            $table->timestamps();
         
            $table->index(['user_id', 'city']);
            $table->index('pincode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
