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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('category_id');
            $table->decimal('amount', 12, 2);
            $table->enum('mode', ['cash', 'upi', 'card']);
            $table->string('vendor_name')->nullable();
            $table->text('description')->nullable();
            $table->string('proof')->nullable(); // stores path/filename
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
