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
        Schema::create('franchises', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('business_name')->unique();
            $table->text('address');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password'); // store hashed passwords
            $table->string('image')->nullable(); // optional image
            $table->decimal('deposit_amount', 10, 2)->default(0); // decimal for money
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('franchises');
    }
};
